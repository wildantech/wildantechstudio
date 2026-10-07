<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class StudioController extends Controller
{
    public function index(): View
    {
        return view('studio.home', [
            'projects' => Project::query()
                ->where('is_published', true)
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(6)
                ->get(),
            'services' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function project(Project $project): View
    {
        abort_unless($project->is_published, 404);

        return view('studio.project', compact('project'));
    }

    public function invitations(): View
    {
        return view('studio.invitations');
    }
}
