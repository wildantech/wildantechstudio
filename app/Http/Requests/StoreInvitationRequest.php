<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'bride_name' => ['required', 'string', 'max:120'],
            'bride_nickname' => ['nullable', 'string', 'max:80'],
            'bride_father' => ['required', 'string', 'max:120'],
            'bride_mother' => ['required', 'string', 'max:120'],
            'bride_child_order' => ['required', 'integer', 'min:1', 'max:10'],
            'groom_name' => ['required', 'string', 'max:120'],
            'groom_nickname' => ['nullable', 'string', 'max:80'],
            'groom_father' => ['required', 'string', 'max:120'],
            'groom_mother' => ['required', 'string', 'max:120'],
            'groom_child_order' => ['required', 'integer', 'min:1', 'max:10'],
            'theme' => ['required', 'in:indigo,midnight-moon,jawa,netflix,purnama,niku-story,floral,heritage,moonlight,classic'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'bride_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'groom_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array', 'max:12'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'music_file' => ['nullable', 'file', 'mimes:mp3,m4a,aac,ogg,wav', 'max:12288'],
            'opening_text' => ['nullable', 'string', 'max:1000'],
            'closing_text' => ['nullable', 'string', 'max:500'],
            'bride_instagram' => ['nullable', 'url', 'max:2048'],
            'groom_instagram' => ['nullable', 'url', 'max:2048'],
            'love_story' => ['nullable', 'array', 'max:6'],
            'love_story_present' => ['sometimes', 'boolean'],
            'love_story.*.title' => ['required', 'string', 'max:120'],
            'love_story.*.date' => ['nullable', 'string', 'max:80'],
            'love_story.*.description' => ['required', 'string', 'max:1000'],
            'livestream_url' => ['nullable', 'url', 'max:2048'],
            'gift_delivery_address' => ['nullable', 'string', 'max:1000'],
            'gift_bank_name' => ['nullable', 'string', 'max:100'],
            'gift_account_name' => ['nullable', 'string', 'max:120'],
            'gift_account_number' => ['nullable', 'string', 'max:80'],
            'gifts' => ['nullable', 'array', 'max:8'],
            'gifts.*.provider' => ['required', 'in:bca,bni,bri,bsi,btn,dana,gopay,mandiri,ovo,seabank,shopeepay'],
            'gifts.*.account_name' => ['required', 'string', 'max:120'],
            'gifts.*.account_number' => ['required', 'string', 'max:80'],
            'is_published' => ['sometimes', 'boolean'],
            'events' => ['required', 'array', 'min:1', 'max:6'],
            'events.*.title' => ['required', 'string', 'max:100'],
            'events.*.starts_at' => ['required', 'date'],
            'events.*.ends_at' => ['nullable', 'date', 'after_or_equal:events.*.starts_at'],
            'events.*.venue_name' => ['required', 'string', 'max:160'],
            'events.*.address' => ['nullable', 'string', 'max:1000'],
            'events.*.maps_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
