<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Models\Invitation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard.index');
    }

    public function create(): View
    {
        return view('dashboard.invitations.form', [
            'invitation' => null,
            'events' => [
                ['title' => 'Akad Nikah', 'starts_at' => '', 'ends_at' => '', 'venue_name' => '', 'address' => '', 'maps_url' => ''],
            ],
        ]);
    }

    public function store(StoreInvitationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $events = $data['events'];
        unset($data['events']);
        $data['love_story'] = $data['love_story'] ?? [];
        unset($data['love_story_present']);
        $gifts = $data['gifts'] ?? [];
        unset($data['gifts']);

        $isPublished = (bool) ($data['is_published'] ?? false);
        unset($data['is_published']);
        $data['gift_bank_name'] = null;
        $data['gift_account_name'] = null;
        $data['gift_account_number'] = null;
        $media = $this->storeUploadedMedia($request);
        unset($data['cover_image'], $data['bride_photo'], $data['groom_photo'], $data['gallery_images'], $data['music_file']);
        $data['host_names'] = $data['bride_name'].' & '.$data['groom_name'];

        $invitation = DB::transaction(function () use ($request, $data, $events, $gifts, $isPublished, $media): Invitation {
            $invitation = $request->user()->invitations()->create([
                ...$data,
                'slug' => $this->uniqueSlug($data['title']),
                ...$media,
                'is_published' => $isPublished,
                'published_at' => $isPublished ? now() : null,
                'expires_at' => $isPublished ? now()->addDays(30) : null,
            ]);

            $invitation->events()->createMany($events);
            $invitation->gifts()->createMany(array_map(fn (array $gift, int $index): array => [...$gift, 'sort_order' => $index], $gifts, array_keys($gifts)));

            return $invitation;
        });

        return redirect()->route('dashboard.invitations.show', $invitation)
            ->with('status', 'Undangan berhasil dibuat. Tambahkan tamu dan bagikan tautan personalnya.');
    }

    public function show(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);
        $invitation->load('events', 'gifts');

        return view('dashboard.invitations.show', [
            'invitation' => $invitation,
            'guests' => $invitation->guests()->with('invitation')->orderBy('name')->paginate(20),
            'wishes' => $invitation->wishes()->with('guest')->orderByDesc('created_at')->limit(20)->get(),
            'guestCount' => $invitation->guests()->count(),
            'respondedCount' => $invitation->guests()->whereNotNull('rsvp_status')->count(),
        ]);
    }

    public function edit(Invitation $invitation): View
    {
        $this->authorize('update', $invitation);
        $invitation->load('events', 'gifts');

        return view('dashboard.invitations.form', [
            'invitation' => $invitation,
            'events' => old('events', $invitation->events->map(fn ($event): array => [
                'title' => $event->title,
                'starts_at' => $event->starts_at->format('Y-m-d\\TH:i'),
                'ends_at' => $event->ends_at?->format('Y-m-d\\TH:i') ?? '',
                'venue_name' => $event->venue_name,
                'address' => $event->address,
                'maps_url' => $event->maps_url,
            ])->all()),
            'gifts' => old('gifts', $invitation->gifts->map(fn ($gift): array => [
                'provider' => $gift->provider,
                'account_name' => $gift->account_name,
                'account_number' => $gift->account_number,
            ])->all()),
        ]);
    }

    public function update(UpdateInvitationRequest $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $data = $request->validated();
        $events = $data['events'];
        unset($data['events']);
        $data['love_story'] = $data['love_story'] ?? [];
        unset($data['love_story_present']);
        $gifts = $data['gifts'] ?? [];
        unset($data['gifts']);

        $isPublished = (bool) ($data['is_published'] ?? false);
        unset($data['is_published']);
        $data['gift_bank_name'] = null;
        $data['gift_account_name'] = null;
        $data['gift_account_number'] = null;
        $removeGallery = array_intersect($data['remove_gallery_images'] ?? [], $invitation->gallery_images ?? []);
        $removeBridePhoto = (bool) ($data['remove_bride_photo'] ?? false);
        $removeGroomPhoto = (bool) ($data['remove_groom_photo'] ?? false);
        $removeCoverImage = (bool) ($data['remove_cover_image'] ?? false);
        $removeMusic = (bool) ($data['remove_music_file'] ?? false);
        unset($data['remove_gallery_images'], $data['remove_bride_photo'], $data['remove_groom_photo'], $data['remove_cover_image'], $data['remove_music_file']);
        $newGalleryFiles = $request->file('gallery_images', []);
        $newGalleryFiles = is_array($newGalleryFiles) ? $newGalleryFiles : [];
        $galleryImages = array_values(array_diff($invitation->gallery_images ?? [], $removeGallery));
        if (count($galleryImages) + count($newGalleryFiles) > 12) {
            throw ValidationException::withMessages(['gallery_images' => 'Galeri maksimal 12 foto. Hapus beberapa foto lama sebelum menambah yang baru.']);
        }

        $newMedia = $this->storeUploadedMedia($request);
        $newGallery = $newMedia['gallery_images'];
        unset($newMedia['gallery_images']);
        $galleryImages = [...$galleryImages, ...$newGallery];
        $oldMedia = $invitation->mediaPaths();
        $data['host_names'] = $data['bride_name'].' & '.$data['groom_name'];
        foreach (['cover_image', 'bride_photo', 'groom_photo', 'music_file'] as $field) {
            $remove = match ($field) {
                'cover_image' => $removeCoverImage,
                'bride_photo' => $removeBridePhoto,
                'groom_photo' => $removeGroomPhoto,
                'music_file' => $removeMusic,
            };
            $data[$field] = $newMedia[$field] ?? ($remove ? null : $invitation->{$field});
        }
        $data['gallery_images'] = $galleryImages;

        DB::transaction(function () use ($invitation, $data, $events, $gifts, $isPublished): void {
            $invitation->update([
                ...$data,
                'is_published' => $isPublished,
                'published_at' => $isPublished ? ($invitation->published_at ?? now()) : null,
                'expires_at' => $isPublished
                    ? ($invitation->expires_at?->isFuture() ? $invitation->expires_at : now()->addDays(30))
                    : null,
            ]);
            $invitation->events()->delete();
            $invitation->events()->createMany($events);
            $invitation->gifts()->delete();
            $invitation->gifts()->createMany(array_map(fn (array $gift, int $index): array => [...$gift, 'sort_order' => $index], $gifts, array_keys($gifts)));
        });

        Storage::disk('public')->delete(array_values(array_diff($oldMedia, $invitation->mediaPaths())));

        return redirect()->route('dashboard.invitations.show', $invitation)
            ->with('status', 'Perubahan undangan disimpan.');
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        $this->authorize('delete', $invitation);
        $this->deleteInvitationMedia($invitation);
        $invitation->delete();

        return redirect()->route('dashboard.index')->with('status', 'Undangan dihapus.');
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'undangan';
        do {
            $slug = $base.'-'.Str::lower(Str::random(5));
        } while (Invitation::query()->where('slug', $slug)->exists());

        return $slug;
    }

    /** @return array{cover_image: ?string, bride_photo: ?string, groom_photo: ?string, gallery_images: array<int, string>, music_file: ?string} */
    private function storeUploadedMedia(Request $request): array
    {
        $gallery = $request->file('gallery_images', []);
        $gallery = is_array($gallery) ? $gallery : [];

        return [
            'cover_image' => $request->file('cover_image')?->store('invitations', 'public'),
            'bride_photo' => $request->file('bride_photo')?->store('invitations/portraits', 'public'),
            'groom_photo' => $request->file('groom_photo')?->store('invitations/portraits', 'public'),
            'gallery_images' => array_values(array_filter(array_map(fn ($file) => $file->store('invitations/gallery', 'public'), $gallery))),
            'music_file' => $request->file('music_file')?->store('invitations/audio', 'public'),
        ];
    }

    private function deleteInvitationMedia(Invitation $invitation): void
    {
        Storage::disk('public')->delete($invitation->mediaPaths());
    }
}
