<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', ['projects' => Project::query()->orderBy('sort_order')->orderBy('title')->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $this->projectData($request->validated());
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['cover_image'] = $request->file('cover_image')?->store('projects', 'public');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        Project::create($data);

        return redirect()->route('dashboard.admin.projects.index')->with('status', 'Proyek ditambahkan.');
    }

    public function show(Project $project): RedirectResponse
    {
        return redirect()->route('dashboard.admin.projects.edit', $project);
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $this->projectData($request->validated());
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('dashboard.admin.projects.index')->with('status', 'Proyek diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->cover_image && Str::startsWith($project->cover_image, 'projects/')) {
            Storage::disk('public')->delete($project->cover_image);
        }

        $project->delete();

        return back()->with('status', 'Proyek dihapus.');
    }

    private function projectData(array $data): array
    {
        $data['technology_stack'] = collect(preg_split('/[,\n]+/', $data['technology_stack'] ?? '') ?: [])
            ->map(fn (string $technology): string => trim($technology))
            ->filter()
            ->unique()
            ->values()
            ->all();
        unset($data['cover_image']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'karya';
        $slug = $base;
        $suffix = 2;

        while (Project::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
