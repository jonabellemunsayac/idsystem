<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SitePage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'sections',
        'meta',
        'is_published',
        'updated_by',
    ];

    protected $casts = [
        'sections' => 'array',
        'meta' => 'array',
        'is_published' => 'boolean',
    ];

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get available section types with their labels and default data structure.
     */
    public static function sectionTypes(): array
    {
        return [
            'hero' => [
                'label' => 'Hero Banner',
                'icon' => 'bi-image',
                'fields' => ['badge', 'heading', 'subheading', 'button_text', 'button_link', 'button2_text', 'button2_link'],
            ],
            'page_header' => [
                'label' => 'Page Header',
                'icon' => 'bi-type-h1',
                'fields' => ['heading', 'subheading'],
            ],
            'text_block' => [
                'label' => 'Text Block',
                'icon' => 'bi-text-paragraph',
                'fields' => ['heading', 'content'],
            ],
            'image_text' => [
                'label' => 'Image & Text',
                'icon' => 'bi-layout-split',
                'fields' => ['label', 'heading', 'content', 'image', 'image_position'],
            ],
            'services_grid' => [
                'label' => 'Services Grid',
                'icon' => 'bi-grid-3x3-gap',
                'fields' => ['label', 'heading', 'subheading', 'items'],
            ],
            'services_list' => [
                'label' => 'Services List',
                'icon' => 'bi-list-check',
                'fields' => ['items'],
            ],
            'news_list' => [
                'label' => 'News List',
                'icon' => 'bi-newspaper',
                'fields' => ['items'],
            ],
            'about_preview' => [
                'label' => 'About Preview',
                'icon' => 'bi-info-circle',
                'fields' => ['label', 'heading', 'description', 'image', 'location', 'land_area'],
            ],
            'mission_vision' => [
                'label' => 'Mission & Vision',
                'icon' => 'bi-flag',
                'fields' => ['mission', 'vision'],
            ],
            'council_grid' => [
                'label' => 'Council / Team',
                'icon' => 'bi-people',
                'fields' => ['label', 'heading', 'subheading', 'captain', 'members'],
            ],
            'contact_info' => [
                'label' => 'Contact Info',
                'icon' => 'bi-envelope',
                'fields' => ['address', 'phone', 'email', 'office_hours', 'facebook'],
            ],
        ];
    }
}
