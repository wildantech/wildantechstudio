<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $invitations = Invitation::query()
            ->when(! $request->user()->is_admin, fn ($query) => $query->whereBelongsTo($request->user()))
            ->with('user:id,name,email')
            ->withCount([
                'guests',
                'guests as responded_guests_count' => fn ($query) => $query->whereNotNull('rsvp_status'),
                'wishes as pending_wishes_count' => fn ($query) => $query->where('is_approved', false),
            ])
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(8);

        return view('dashboard.index', [
            'invitations' => $invitations,
            'projectCount' => $request->user()->is_admin ? Project::count() : null,
            'serviceCount' => $request->user()->is_admin ? Service::count() : null,
        ]);
    }
}
