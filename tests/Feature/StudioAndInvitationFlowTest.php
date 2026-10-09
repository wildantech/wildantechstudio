<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationGuest;
use App\Models\InvitationWish;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudioAndInvitationFlowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_homepage_lists_published_projects_and_active_services(): void
    {
        $project = Project::factory()->create(['title' => 'SIMONTA', 'is_published' => true]);
        Project::factory()->create(['title' => 'Draft Project', 'is_published' => false]);
        Service::factory()->create(['title' => 'Undangan Digital', 'is_active' => true]);
        Service::factory()->create(['title' => 'Hidden Service', 'is_active' => false]);

        $response = $this->get(route('home'));

        $response->assertSee('SIMONTA')
            ->assertDontSee('Draft Project')
            ->assertSee('Undangan Digital')
            ->assertDontSee('Hidden Service');
        $this->assertModelExists($project);
    }

    public function test_registration_creates_a_customer_account_without_admin_privileges(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Alya Rahma',
            'email' => 'alya@example.test',
            'password' => 'AmanSekali123!',
            'password_confirmation' => 'AmanSekali123!',
            'terms' => '1',
            'is_admin' => '1',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $user = User::query()->where('email', 'alya@example.test')->firstOrFail();
        $this->assertFalse($user->is_admin);
        $this->assertTrue(password_verify('AmanSekali123!', $user->password));
        $this->assertNotSame('AmanSekali123!', $user->password);
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_is_rate_limited_after_five_failed_attempts_per_email_and_ip(): void
    {
        $user = User::factory()->create(['email' => 'alya@example.test']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])->assertRedirect();
        }

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertTooManyRequests();
    }

    public function test_customer_can_create_an_invitation_with_multiple_events(): void
    {
        $customer = User::factory()->create();
        $this->actingAs($customer);

        $response = $this->post(route('dashboard.invitations.store'), [
            'title' => 'Alya dan Raka',
            'bride_name' => 'Alya',
            'bride_father' => 'Bapak A',
            'bride_mother' => 'Ibu A',
            'bride_child_order' => 1,
            'groom_name' => 'Raka',
            'groom_father' => 'Bapak R',
            'groom_mother' => 'Ibu R',
            'groom_child_order' => 2,
            'theme' => 'lavender',
            'is_published' => '1',
            'gifts' => [
                ['provider' => 'bri', 'account_name' => 'Alya Rahma', 'account_number' => '1234567890'],
                ['provider' => 'dana', 'account_name' => 'Alya Rahma', 'account_number' => '081234567890'],
            ],
            'events' => [
                ['title' => 'Akad', 'starts_at' => '2026-12-26T09:00', 'venue_name' => 'Pendopo', 'address' => 'Sapuran'],
                ['title' => 'Resepsi', 'starts_at' => '2026-12-26T12:00', 'venue_name' => 'Pendopo', 'address' => 'Sapuran'],
            ],
        ]);

        $invitation = Invitation::query()->where('user_id', $customer->id)->firstOrFail();
        $response->assertRedirect(route('dashboard.invitations.show', $invitation));
        $this->assertSame(2, $invitation->events()->count());
        $this->assertTrue($invitation->is_published);
        $this->assertSame('lavender', $invitation->theme);
        $this->assertSame('Alya & Raka', $invitation->host_names);
        $this->assertTrue($invitation->expires_at->isFuture());
        $this->assertSame(['bri', 'dana'], $invitation->gifts()->orderBy('sort_order')->pluck('provider')->all());
    }

    public function test_customer_cannot_view_another_customers_invitation(): void
    {
        $owner = User::factory()->create();
        $otherCustomer = User::factory()->create();
        $invitation = Invitation::factory()->for($owner)->create();

        $response = $this->actingAs($otherCustomer)->get(route('dashboard.invitations.show', $invitation));

        $response->assertNotFound();
    }

    public function test_customer_dashboard_renders_invitation_and_guest_management(): void
    {
        $customer = User::factory()->create();
        $invitation = Invitation::factory()->for($customer)->create();
        InvitationGuest::factory()->for($invitation)->create(['name' => 'Budi Santoso']);

        $response = $this->actingAs($customer)->get(route('dashboard.invitations.show', $invitation));

        $response->assertSee('Budi Santoso')->assertSee('Tambah tamu')->assertSee('Buka WhatsApp');
    }

    public function test_customer_can_add_a_guest_and_open_a_personal_whatsapp_link(): void
    {
        $customer = User::factory()->create();
        $invitation = Invitation::factory()->for($customer)->create();
        $this->actingAs($customer);

        $response = $this->post(route('dashboard.guests.store', $invitation), [
            'name' => 'Budi Santoso',
            'phone' => '0812 3456-7890',
            'group_name' => 'Keluarga',
        ]);

        $guest = $invitation->guests()->firstOrFail();
        $response->assertRedirect();
        $this->assertSame('6281234567890', $guest->phone);
        $this->assertStringContainsString('https://wa.me/6281234567890?text=', $guest->whatsappUrl());
        $this->assertStringContainsString($guest->token, $guest->whatsappUrl());
    }

    public function test_guest_can_view_a_personalized_published_invitation_and_submit_rsvp(): void
    {
        $invitation = Invitation::factory()->create([
            'is_published' => true,
            'theme' => 'lavender',
            'bride_child_order' => 1,
            'groom_child_order' => 2,
            'music_file' => 'invitations/audio/song.mp3',
            'gallery_images' => ['invitations/gallery/memory.webp'],
        ]);
        InvitationEvent::factory()->for($invitation)->create(['title' => 'Akad Nikah']);
        $invitation->gifts()->create(['provider' => 'bri', 'account_name' => 'Alya Rahma', 'account_number' => '1234567890']);
        $guest = InvitationGuest::factory()->for($invitation)->create(['name' => 'Budi Santoso']);

        $page = $this->get(route('invitations.public.show', [$invitation->slug, $guest->token]));
        $page->assertSee('theme-lavender')->assertSee('class="night-sky"', false)->assertSee('class="night-moon"', false)
            ->assertSee('bunga%20sudut%202.png')->assertSee('Budi Santoso')->assertSee('Akad Nikah')->assertSee('QS. Ar-Rum: 21')
            ->assertSee('The Wedding Of')->assertSee('Buka Undangan')->assertSee('Menuju hari bahagia')->assertSee('Putar musik')
            ->assertSee('src="/storage/invitations/audio/song.mp3"', false)
            ->assertSee('src="/storage/invitations/gallery/memory.webp"', false)
            ->assertSee('Galeri')->assertSee('execCommand(\'copy\')', false)->assertSee('Tekan lama nomor')
            ->assertSee('BRI')->assertSee('images/bank/bri.png')
            ->assertSee('images/aset/islam%20istri.png')->assertSee('images/aset/islam%20suami.png')
            ->assertSee('Putri pertama dari')->assertSee('Putra kedua dari')
            ->assertSee($invitation->bride_father)->assertSee($invitation->groom_mother)
            ->assertSee('Ilustrasi pengantin putri')->assertSee('Ilustrasi pengantin putra');

        $response = $this->post(route('invitations.public.rsvp', [$invitation->slug, $guest->token]), [
            'rsvp_status' => 'attending',
            'party_size' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('invitation_guests', [
            'id' => $guest->id,
            'rsvp_status' => 'attending',
            'party_size' => 2,
        ]);
    }

    public function test_unpublished_or_unknown_personal_invitation_is_not_found(): void
    {
        $invitation = Invitation::factory()->create(['is_published' => false]);
        $guest = InvitationGuest::factory()->for($invitation)->create();

        $response = $this->get(route('invitations.public.show', [$invitation->slug, $guest->token]));

        $response->assertNotFound();
    }

    public function test_public_invitation_form_collects_family_details_and_theme_options(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)->get(route('dashboard.invitations.create'))
            ->assertSee('name="title" value=""', false)
            ->assertDontSee('{{ old(')
            ->assertDontSee('@if ($invitation')
            ->assertSee('Putra dari Bapak')
            ->assertSee('Ibu')
            ->assertSee('Urutan putra')->assertSee('Kesepuluh')->assertDontSee('Putra ke-')
            ->assertSee('Velvet · burgundy')
            ->assertSee('Galeri foto')
            ->assertSee('Musik latar')
            ->assertSee('Pilih bank / e-wallet')->assertSee('ShopeePay')
            ->assertSee('Nocturne · lavender malam')
            ->assertSee('Pilih lokasi di peta')->assertSee('Cari nama tempat atau alamat')
            ->assertSee('30 hari setelah pertama kali diterbitkan');
    }

    public function test_expired_public_invitation_is_hidden_before_cleanup_runs(): void
    {
        $invitation = Invitation::factory()->create([
            'is_published' => true,
            'expires_at' => now()->subMinute(),
        ]);
        $guest = InvitationGuest::factory()->for($invitation)->create();

        $this->get(route('invitations.public.show', [$invitation->slug, $guest->token]))
            ->assertNotFound();
    }

    public function test_purge_command_deletes_expired_invitation_and_all_media(): void
    {
        Storage::fake('public');
        $media = [
            'invitations/expired.jpg',
            'invitations/portraits/bride.jpg',
            'invitations/portraits/groom.jpg',
            'invitations/gallery/one.jpg',
            'invitations/audio/song.mp3',
        ];
        foreach ($media as $path) {
            Storage::disk('public')->put($path, 'media-data');
        }
        $expired = Invitation::factory()->create([
            'is_published' => true,
            'expires_at' => now()->subMinute(),
            'cover_image' => 'invitations/expired.jpg',
            'bride_photo' => 'invitations/portraits/bride.jpg',
            'groom_photo' => 'invitations/portraits/groom.jpg',
            'gallery_images' => ['invitations/gallery/one.jpg'],
            'music_file' => 'invitations/audio/song.mp3',
        ]);
        $active = Invitation::factory()->create(['is_published' => true, 'expires_at' => now()->addDay()]);

        $this->artisan('invitations:purge-expired')->expectsOutput('1 undangan kedaluwarsa dihapus.')->assertExitCode(0);

        $this->assertModelMissing($expired);
        $this->assertModelExists($active);
        foreach ($media as $path) {
            Storage::disk('public')->assertMissing($path);
        }
    }

    public function test_customer_can_upload_an_invitation_cover_photo(): void
    {
        Storage::fake('public');
        $customer = User::factory()->create();

        $this->actingAs($customer)->post(route('dashboard.invitations.store'), [
            'title' => 'Pernikahan Alya dan Raka',
            'bride_name' => 'Alya', 'bride_father' => 'Bapak A', 'bride_mother' => 'Ibu A', 'bride_child_order' => 1,
            'groom_name' => 'Raka', 'groom_father' => 'Bapak R', 'groom_mother' => 'Ibu R', 'groom_child_order' => 2,
            'theme' => 'wine',
            'bride_photo' => UploadedFile::fake()->image('alya.jpg'),
            'groom_photo' => UploadedFile::fake()->image('raka.jpg'),
            'cover_image' => UploadedFile::fake()->image('pasangan.jpg'),
            'gallery_images' => [UploadedFile::fake()->image('akad.jpg'), UploadedFile::fake()->image('resepsi.jpg')],
            'music_file' => UploadedFile::fake()->create('wedding.mp3', 32, 'audio/mpeg'),
            'events' => [['title' => 'Akad Nikah', 'starts_at' => '2026-12-26T09:00', 'venue_name' => 'Pendopo']],
        ])->assertSessionHasNoErrors();

        $invitation = Invitation::query()->where('user_id', $customer->id)->firstOrFail();
        $this->assertSame('wine', $invitation->theme);
        $this->assertNotNull($invitation->cover_image);
        $this->assertNotNull($invitation->bride_photo);
        $this->assertNotNull($invitation->groom_photo);
        $this->assertNotNull($invitation->music_file);
        $this->assertCount(2, $invitation->gallery_images);
        Storage::disk('public')->assertExists($invitation->cover_image);
        Storage::disk('public')->assertExists($invitation->bride_photo);
        Storage::disk('public')->assertExists($invitation->groom_photo);
        Storage::disk('public')->assertExists($invitation->gallery_images[0]);
        Storage::disk('public')->assertExists($invitation->music_file);
    }

    public function test_guest_wish_is_hidden_until_the_invitation_owner_approves_it(): void
    {
        $owner = User::factory()->create();
        $invitation = Invitation::factory()->for($owner)->create(['is_published' => true]);
        $guest = InvitationGuest::factory()->for($invitation)->create();

        $this->post(route('invitations.public.wishes.store', [$invitation->slug, $guest->token]), [
            'message' => 'Semoga menjadi keluarga yang bahagia.',
        ])->assertRedirect();

        $wish = InvitationWish::query()->firstOrFail();
        $this->get(route('invitations.public.show', [$invitation->slug, $guest->token]))
            ->assertDontSee('Semoga menjadi keluarga yang bahagia.');

        $this->actingAs($owner)->post(route('dashboard.wishes.approve', [$invitation, $wish->id]))->assertRedirect();
        $this->get(route('invitations.public.show', [$invitation->slug, $guest->token]))
            ->assertSee('Semoga menjadi keluarga yang bahagia.');
    }

    public function test_customer_cannot_access_studio_content_management(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer)->get(route('dashboard.admin.projects.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_render_project_and_service_management(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('dashboard.admin.projects.index'))
            ->assertSee('Karya');
        $this->get(route('dashboard.admin.services.index'))
            ->assertSee('Layanan');
    }

    public function test_admin_can_add_a_project_with_technology_stack(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('dashboard.admin.projects.store'), [
            'title' => 'Panel Operasional',
            'category' => 'Proyek mandiri',
            'summary' => 'Panel ringkas untuk pencatatan kerja.',
            'description' => 'Menyatukan pencatatan dan pemantauan dalam satu halaman.',
            'technology_stack' => "Laravel, PHP\nSQLite",
            'sort_order' => 2,
            'is_featured' => '1',
            'is_published' => '1',
        ]);

        $project = Project::query()->where('title', 'Panel Operasional')->firstOrFail();
        $response->assertRedirect(route('dashboard.admin.projects.index'));
        $this->assertSame(['Laravel', 'PHP', 'SQLite'], $project->technology_stack);
        $this->assertTrue($project->is_featured);
    }

    public function test_admin_can_add_a_service_for_the_public_studio_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('dashboard.admin.services.store'), [
            'title' => 'Prototipe sensor',
            'summary' => 'Prototipe sensor sesuai kebutuhan lapangan.',
            'description' => 'Perancangan dan pengujian perangkat sensor.',
            'category' => 'Perangkat',
            'icon' => 'cpu',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('dashboard.admin.services.index'));
        $this->assertDatabaseHas('services', ['slug' => 'prototipe-sensor', 'is_active' => true]);
    }

    public function test_invitations_catalog_displays_the_five_featured_themes(): void
    {
        $response = $this->get(route('studio.invitations'));

        $response->assertOk()
            ->assertSee('Niku Story')
            ->assertSee('Midnight Moon')
            ->assertSee('Jawa Heritage')
            ->assertSee('Netflix Style')
            ->assertSee('Indigo Night');
    }

    public function test_theme_preview_routes_render_for_all_five_themes(): void
    {
        $themes = ['niku-story', 'midnight-moon', 'jawa', 'netflix', 'indigo'];

        foreach ($themes as $theme) {
            $response = $this->get(route('studio.invitations.preview', $theme));
            $response->assertOk()
                ->assertSee('Alya')
                ->assertSee('Raka');
        }
    }
}
