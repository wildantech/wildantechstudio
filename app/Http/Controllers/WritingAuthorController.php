<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class WritingAuthorController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $author = $request->user();

        if ($author?->is_writer) {
            return redirect()->route('dashboard.writings.index');
        }

        return view($author ? 'writings.author-activate' : 'writings.author-register', ['existingAccount' => $author]);
    }

    public function store(Request $request): RedirectResponse
    {
        $existingAuthor = $request->user();

        if ($existingAuthor) {
            if ($existingAuthor->is_writer) {
                return redirect()->route('dashboard.writings.index');
            }

            $data = $request->validate([
                'name' => ['required', 'string', 'max:120'],
                'bio' => ['required', 'string', 'max:1200'],
            ]);

            $existingAuthor->fill([
                'name' => $data['name'],
                'bio' => $data['bio'],
                'is_writer' => true,
            ])->save();

            return redirect()->route('dashboard.writings.index')->with('status', 'Ruang tulisanmu siap. Selamat berkarya!');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users,email'],
            'bio' => ['required', 'string', 'max:1200'],
            'password' => ['required', 'confirmed', Password::min(10)],
        ]);

        $author = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'bio' => $data['bio'],
            'password' => $data['password'],
            'is_writer' => true,
        ]);

        Auth::login($author);
        $request->session()->regenerate();

        return redirect()->route('dashboard.writings.index')->with('status', 'Ruang tulisanmu siap. Selamat berkarya!');
    }
}
