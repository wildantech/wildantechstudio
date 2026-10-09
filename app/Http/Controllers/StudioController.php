<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationGift;
use App\Models\InvitationGuest;
use App\Models\InvitationWish;
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

    public function previewTheme(string $theme): View
    {
        $themeMap = [
            'midnight' => 'midnight-moon',
            'midnight-moon' => 'midnight-moon',
            'jawa' => 'jawa',
            'jawa-heritage' => 'jawa',
            'netflix' => 'netflix',
            'niku' => 'niku-story',
            'niku-story' => 'niku-story',
            'indigo' => 'indigo',
        ];

        abort_unless(isset($themeMap[$theme]), 404);
        $resolvedTheme = $themeMap[$theme];

        $invitation = new Invitation([
            'title' => 'The Wedding of Alya & Raka',
            'slug' => 'demo-'.$resolvedTheme,
            'theme' => $resolvedTheme,
            'bride_name' => 'Alya Nur Rahma',
            'bride_nickname' => 'Alya',
            'groom_name' => 'Raka Pradipta',
            'groom_nickname' => 'Raka',
            'bride_father' => 'Bambang Hartono',
            'bride_mother' => 'Sri Rahayu',
            'groom_father' => 'Hartono Wijaya',
            'groom_mother' => 'Nurul Hidayati',
            'bride_child_order' => 1,
            'groom_child_order' => 2,
            'bride_instagram' => 'https://instagram.com/wildantech',
            'groom_instagram' => 'https://instagram.com/wildantech',
            'greeting_text' => 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan syukuran pernikahan putra-putri kami.',
            'closing_text' => 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.',
            'love_story' => [
                ['title' => 'Pertemuan Pertama', 'date' => '2021', 'description' => 'Berawal dari rekan satu organisasi kampus di Yogyakarta, perlahan saling mengenal dan berbagi cerita.'],
                ['title' => 'Komitmen Bersama', 'date' => '2024', 'description' => 'Memutuskan untuk melangkah ke jenjang yang lebih serius dengan restu kedua keluarga.'],
                ['title' => 'Menuju Hari Bahagia', 'date' => '2026', 'description' => 'Memulai babak baru perjalanan hidup bersama dalam ikatan suci pernikahan.'],
            ],
            'gift_bank_name' => 'BCA',
            'gift_account_number' => '8465019283',
            'gift_account_name' => 'Alya Nur Rahma',
            'gift_delivery_address' => 'Jl. Kaliurang KM 5, Sleman, D.I. Yogyakarta',
            'music_file' => null,
            'is_published' => true,
        ]);

        $event1 = new InvitationEvent([
            'title' => 'Akad Nikah',
            'starts_at' => now()->addDays(14)->setTime(8, 0),
            'ends_at' => now()->addDays(14)->setTime(10, 0),
            'venue_name' => 'Masjid Kampus UGM',
            'address' => 'Bulaksumur, Caturtunggal, Sleman, D.I. Yogyakarta',
            'maps_url' => 'https://maps.google.com',
        ]);

        $event2 = new InvitationEvent([
            'title' => 'Resepsi Pernikahan',
            'starts_at' => now()->addDays(14)->setTime(11, 0),
            'ends_at' => now()->addDays(14)->setTime(14, 0),
            'venue_name' => 'Grand Ballroom Royal Ambarrukmo',
            'address' => 'Jl. Laksda Adisucipto No.81, Sleman, D.I. Yogyakarta',
            'maps_url' => 'https://maps.google.com',
        ]);

        $gift1 = new InvitationGift([
            'provider' => 'BCA',
            'account_number' => '8465019283',
            'account_name' => 'Alya Nur Rahma',
        ]);

        $gift2 = new InvitationGift([
            'provider' => 'Mandiri',
            'account_number' => '1370019284756',
            'account_name' => 'Raka Pradipta',
        ]);

        $invitation->setRelation('events', collect([$event1, $event2]));
        $invitation->setRelation('gifts', collect([$gift1, $gift2]));

        $guest = new InvitationGuest([
            'name' => 'Tamu Kehormatan',
            'phone' => '08123456789',
            'token' => 'preview-token',
            'rsvp_status' => 'attending',
            'party_size' => 2,
        ]);

        $wish1 = new InvitationWish([
            'message' => 'Selamat menempuh hidup baru Alya & Raka! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah.',
            'is_approved' => true,
        ]);
        $wish1->setRelation('guest', new InvitationGuest(['name' => 'Dimas & Keluarga']));

        $wish2 = new InvitationWish([
            'message' => 'Barakallahu lakuma wa baraka alaika wa jamaa bainakuma fii khair. Lancar sampai hari H ya!',
            'is_approved' => true,
        ]);
        $wish2->setRelation('guest', new InvitationGuest(['name' => 'Sarah Amanda']));

        $invitation->setRelation('wishes', collect([$wish1, $wish2]));
        $invitation->attending_guests_count = 24;
        $invitation->declined_guests_count = 3;

        return view('invitations.public', compact('invitation', 'guest'));
    }
}
