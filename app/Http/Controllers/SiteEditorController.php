<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteEditorController extends Controller
{
    /**
     * Display listing of editable pages.
     */
    public function index()
    {
        $pages = SitePage::orderBy('id')->get();
        return view('site-editor.index', compact('pages'));
    }

    /**
     * Show the section editor for a specific page.
     */
    public function edit(SitePage $sitePage)
    {
        $sectionTypes = SitePage::sectionTypes();
        return view('site-editor.edit', compact('sitePage', 'sectionTypes'));
    }

    /**
     * Update the page sections.
     */
    public function update(Request $request, SitePage $sitePage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'required|json',
            'is_published' => 'boolean',
        ]);

        $sitePage->update([
            'title' => $validated['title'],
            'sections' => json_decode($validated['sections'], true),
            'is_published' => $request->boolean('is_published', true),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('site-editor.edit', $sitePage)
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Upload an image for the site editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $path = $request->file('image')->store('site-editor', 'public');

        return response()->json([
            'success' => true,
            'url' => '/storage/' . $path,
        ]);
    }

    /**
     * Update page meta (SEO settings).
     */
    public function updateMeta(Request $request, SitePage $sitePage)
    {
        $validated = $request->validate([
            'meta_description' => 'nullable|string|max:500',
        ]);

        $meta = $sitePage->meta ?? [];
        $meta['description'] = $validated['meta_description'];
        $sitePage->update([
            'meta' => $meta,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Page meta updated.');
    }

    /**
     * Add a new section to a page.
     */
    public function addSection(Request $request, SitePage $sitePage)
    {
        $validated = $request->validate([
            'type' => 'required|string',
        ]);

        $sections = $sitePage->sections ?? [];
        $maxOrder = collect($sections)->max('order') ?? 0;

        $newSection = [
            'type' => $validated['type'],
            'order' => $maxOrder + 1,
            'data' => $this->getDefaultData($validated['type']),
        ];

        $sections[] = $newSection;
        $sitePage->update([
            'sections' => $sections,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Section added.');
    }

    /**
     * Remove a section from a page.
     */
    public function removeSection(Request $request, SitePage $sitePage)
    {
        $validated = $request->validate([
            'index' => 'required|integer|min:0',
        ]);

        $sections = $sitePage->sections ?? [];

        if (isset($sections[$validated['index']])) {
            array_splice($sections, $validated['index'], 1);
            // Re-order
            foreach ($sections as $i => &$section) {
                $section['order'] = $i + 1;
            }
            $sitePage->update([
                'sections' => $sections,
                'updated_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Section removed.');
    }

    /**
     * Preview a page as it would appear on the public site.
     */
    public function preview(SitePage $sitePage)
    {
        return view('site-editor.preview', compact('sitePage'));
    }

    /**
     * Get default data structure for a section type.
     */
    private function getDefaultData(string $type): array
    {
        return match ($type) {
            'hero' => [
                'badge' => 'Welcome',
                'heading' => 'Your Heading Here',
                'subheading' => 'Your subheading text here.',
                'button_text' => 'Learn More',
                'button_link' => '#',
                'button2_text' => '',
                'button2_link' => '',
            ],
            'page_header' => [
                'heading' => 'Page Title',
                'subheading' => 'Page description goes here.',
            ],
            'text_block' => [
                'heading' => 'Section Title',
                'content' => 'Enter your content here...',
            ],
            'image_text' => [
                'label' => '',
                'heading' => 'Section Title',
                'content' => 'Enter your content here...',
                'image' => '',
                'image_position' => 'left',
            ],
            'services_grid', 'services_list' => [
                'label' => 'Our Services',
                'heading' => 'What We Offer',
                'subheading' => 'Description of services.',
                'items' => [
                    ['icon' => 'bi-star', 'title' => 'Service Name', 'description' => 'Service description.'],
                ],
            ],
            'news_list' => [
                'items' => [
                    ['date' => now()->format('F j, Y'), 'title' => 'News Title', 'excerpt' => 'News excerpt...', 'image' => '', 'featured' => false],
                ],
            ],
            'about_preview' => [
                'label' => 'About Us',
                'heading' => 'About Our Community',
                'description' => 'Write about your community here...',
                'image' => '',
                'location' => '',
                'land_area' => '',
            ],
            'mission_vision' => [
                'mission' => 'To provide efficient, effective, and transparent public service.',
                'vision' => 'A progressive, peaceful, and resilient community.',
            ],
            'council_grid' => [
                'label' => 'Our Leaders',
                'heading' => 'Barangay Council',
                'subheading' => 'Meet the dedicated officials serving our community.',
                'captain' => ['name' => 'Hon. Captain Name', 'title' => 'Punong Barangay', 'image' => ''],
                'members' => [
                    ['name' => 'Hon. Member Name', 'title' => 'Kagawad', 'image' => ''],
                ],
            ],
            'contact_info' => [
                'address' => '',
                'phone' => '',
                'email' => '',
                'office_hours' => '',
                'facebook' => '',
            ],
            default => [],
        };
    }
}
