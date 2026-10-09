<?php

namespace App\Http\Controllers;

use App\Models\Writing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WritingController extends Controller
{
    private const TYPES = [
        'article' => 'Artikel',
        'book' => 'Buku',
        'poem' => 'Puisi',
    ];

    public function index(Request $request): View
    {
        $type = $request->query('jenis');
        $selectedType = array_key_exists((string) $type, self::TYPES) ? $type : 'all';

        $writings = Writing::query()
            ->where('status', 'published')
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->when($selectedType !== 'all', fn ($query) => $query->where('type', $selectedType))
            ->with('author:id,name,bio,is_writer')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('writings.index', [
            'writings' => $writings,
            'types' => self::TYPES,
            'selectedType' => $selectedType,
            'publishedCount' => Writing::query()->where('status', 'published')->count(),
        ]);
    }

    public function show(Writing $writing): View
    {
        abort_unless(
            $writing->status === 'published' && (! $writing->published_at || $writing->published_at->isPast()),
            404,
        );

        $writing->body = $this->formatBody($writing->body);
        $writing->load('author:id,name,bio,is_writer');

        return view('writings.show', ['writing' => $writing, 'types' => self::TYPES]);
    }

    public function dashboardIndex(Request $request): View
    {
        $this->authorizeWriter($request);
        $author = $request->user();
        $writings = $author->writings()
            ->orderByRaw("CASE WHEN status = 'draft' THEN 0 ELSE 1 END")
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('writings.dashboard', [
            'writings' => $writings,
            'publishedCount' => $author->writings()->where('status', 'published')->count(),
            'draftCount' => $author->writings()->where('status', 'draft')->count(),
            'types' => self::TYPES,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorizeWriter($request);

        return view('writings.form', ['writing' => new Writing, 'types' => self::TYPES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeWriter($request);
        $data = $this->validatedData($request);
        $writing = new Writing($data);
        $writing->user_id = $request->user()->id;
        $writing->slug = $this->uniqueSlug($data['title']);
        $writing->status = $data['status'];
        $writing->published_at = $data['status'] === 'published' ? now() : null;
        $this->storeUploads($request, $writing);
        $writing->save();

        return redirect()->route('dashboard.writings.index')->with(
            'status',
            $writing->status === 'published' ? 'Karyamu sudah terbit di ruang baca.' : 'Draf berhasil disimpan.',
        );
    }

    public function edit(Request $request, Writing $writing): View
    {
        $this->authorizeWriting($request, $writing);

        return view('writings.form', ['writing' => $writing, 'types' => self::TYPES]);
    }

    public function update(Request $request, Writing $writing): RedirectResponse
    {
        $this->authorizeWriting($request, $writing);
        $data = $this->validatedData($request);
        $writing->fill($data);
        $writing->slug = $this->uniqueSlug($data['title'], $writing);
        $writing->status = $data['status'];
        $writing->published_at = $data['status'] === 'published' ? ($writing->published_at ?? now()) : null;
        $this->storeUploads($request, $writing);
        $writing->save();

        return redirect()->route('dashboard.writings.index')->with(
            'status',
            $writing->status === 'published' ? 'Perubahan tulisan berhasil diterbitkan.' : 'Draf berhasil diperbarui.',
        );
    }

    public function destroy(Request $request, Writing $writing): RedirectResponse
    {
        $this->authorizeWriting($request, $writing);
        Storage::disk('public')->delete(array_filter([$writing->cover_path, $writing->attachment_path]));
        $writing->delete();

        return redirect()->route('dashboard.writings.index')->with('status', 'Tulisan berhasil dihapus.');
    }

    /** @return array{title: string, type: string, excerpt: ?string, body: ?string, status: string} */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'type' => ['required', 'in:article,book,poem'],
            'excerpt' => ['nullable', 'string', 'max:360'],
            'body' => ['nullable', 'string', 'max:150000'],
            'status' => ['required', 'in:draft,published'],
            'cover' => ['nullable', 'image', 'max:5120'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,txt', 'max:30720'],
        ]);

        $data = Arr::only($validated, ['title', 'type', 'excerpt', 'body', 'status']);
        $data['body'] = $this->formatBody($data['body'] ?? null);

        $existingWriting = $request->route('writing');

        $hasExistingAttachment = $existingWriting instanceof Writing && $existingWriting->attachment_path && ! $request->boolean('remove_attachment');

        if (blank($data['body'] ?? null) && ! $request->hasFile('attachment') && ! $hasExistingAttachment) {
            throw ValidationException::withMessages(['body' => 'Isi karya atau lampirkan naskah sebelum menyimpan.']);
        }

        return $data;
    }

    private function formatBody(?string $body): ?string
    {
        if (blank($body)) {
            return null;
        }

        if (! preg_match('/<\/?(p|br|strong|b|em|i|u|h2|h3|blockquote|ul|ol|li|div)\b[^>]*>/i', $body)) {
            $paragraphs = preg_split('/\R{2,}/', trim($body)) ?: [];
            $body = implode('', array_map(
                fn (string $paragraph): string => '<p>'.nl2br(e($paragraph)).'</p>',
                $paragraphs,
            ));
        }

        $body = preg_replace_callback(
            '/<(\/?)div\b[^>]*>/i',
            fn (array $matches): string => '<'.$matches[1].'p>',
            $body,
        ) ?? $body;
        $body = strip_tags($body, '<p><br><strong><b><em><i><u><h2><h3><blockquote><ul><ol><li>');

        return preg_replace(
            '/<(\/?)(p|br|strong|b|em|i|u|h2|h3|blockquote|ul|ol|li)\b[^>]*>/i',
            '<$1$2>',
            $body,
        ) ?? $body;
    }

    private function storeUploads(Request $request, Writing $writing): void
    {
        if ($request->boolean('remove_cover') && $writing->cover_path) {
            Storage::disk('public')->delete($writing->cover_path);
            $writing->cover_path = null;
        }

        if ($request->hasFile('cover')) {
            if ($writing->cover_path) {
                Storage::disk('public')->delete($writing->cover_path);
            }

            $writing->cover_path = $request->file('cover')->store('writings/covers', 'public');
        }

        if ($request->boolean('remove_attachment') && $writing->attachment_path) {
            Storage::disk('public')->delete($writing->attachment_path);
            $writing->attachment_path = null;
            $writing->attachment_name = null;
        }

        if ($request->hasFile('attachment')) {
            if ($writing->attachment_path) {
                Storage::disk('public')->delete($writing->attachment_path);
            }

            $file = $request->file('attachment');
            $writing->attachment_path = $file->store('writings/files', 'public');
            $writing->attachment_name = $file->getClientOriginalName();
        }
    }

    private function uniqueSlug(string $title, ?Writing $writing = null): string
    {
        $baseSlug = Str::slug($title) ?: 'karya';
        $slug = $baseSlug;
        $suffix = 2;

        while (Writing::query()->where('slug', $slug)->when($writing, fn ($query) => $query->where('id', '!=', $writing->id))->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        return $slug;
    }

    private function authorizeWriter(Request $request): void
    {
        abort_unless($request->user()->is_writer || $request->user()->is_admin, 403);
    }

    private function authorizeWriting(Request $request, Writing $writing): void
    {
        $this->authorizeWriter($request);
        abort_unless($request->user()->is_admin || $writing->user_id === $request->user()->id, 403);
    }
}
