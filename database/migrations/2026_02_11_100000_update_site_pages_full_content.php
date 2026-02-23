<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update "About Us" page with complete sections (history, mission/vision, council)
        DB::table('site_pages')->where('slug', 'about')->update([
            'sections' => json_encode([
                [
                    'type' => 'page_header',
                    'order' => 1,
                    'data' => [
                        'heading' => 'About Us',
                        'subheading' => 'Learn about our history, mission, and the people serving our community.',
                    ],
                ],
                [
                    'type' => 'image_text',
                    'order' => 2,
                    'data' => [
                        'label' => 'Our History',
                        'heading' => 'From Duck Raisers to a Thriving Barangay',
                        'content' => "Barangay Kalawaan is one of the thirty barangays comprising the City of Pasig. Its name was derived from the word \"Kalawaan\" which means \"place of spiders\" or possibly relating to the vast bodies of water found in the area during the early times.\n\nHistorically, it was a humble settlement of duck raisers in 1926. Over the decades, it has transformed into a vibrant residential and commercial area while maintaining its rich cultural heritage and community spirit.",
                        'image' => '/images/kalawaan.jpg',
                        'image_position' => 'left',
                    ],
                ],
                [
                    'type' => 'mission_vision',
                    'order' => 3,
                    'data' => [
                        'mission' => 'To provide efficient, effective, and transparent public service to the constituents of Barangay Kalawaan, promoting peace, order, and progress through community involvement.',
                        'vision' => 'A progressive, peaceful, and resilient Barangay Kalawaan inhabited by God-fearing and empowered citizens living in a clean and safe environment.',
                    ],
                ],
                [
                    'type' => 'council_grid',
                    'order' => 4,
                    'data' => [
                        'label' => 'Our Leaders',
                        'heading' => 'Barangay Council',
                        'subheading' => 'Meet the dedicated officials serving our community.',
                        'captain' => [
                            'name' => 'Hon. Juan Dela Cruz',
                            'title' => 'Punong Barangay',
                            'image' => '/images/cap.jpg',
                        ],
                        'members' => [
                            ['name' => 'Hon. Maria Santos', 'title' => 'Kagawad', 'image' => '/images/1.png'],
                            ['name' => 'Hon. Pedro Reyes', 'title' => 'Kagawad', 'image' => '/images/2.png'],
                            ['name' => 'Hon. Ana Lim', 'title' => 'Kagawad', 'image' => '/images/3.png'],
                            ['name' => 'Hon. Jose Garcia', 'title' => 'Kagawad', 'image' => '/images/4.png'],
                            ['name' => 'Hon. Lita Cruz', 'title' => 'Kagawad', 'image' => '/images/5.png'],
                            ['name' => 'Hon. Robert Tan', 'title' => 'Kagawad', 'image' => '/images/6.png'],
                            ['name' => 'Hon. Tessie Sy', 'title' => 'Kagawad', 'image' => '/images/7.png'],
                            ['name' => 'Hon. SK Chair', 'title' => 'SK Chairperson', 'image' => '/images/ARNOLDTAJAN.png'],
                        ],
                    ],
                ],
            ]),
            'updated_at' => now(),
        ]);

        // Update "News" page - add image field to news items
        DB::table('site_pages')->where('slug', 'news')->update([
            'sections' => json_encode([
                [
                    'type' => 'page_header',
                    'order' => 1,
                    'data' => [
                        'heading' => 'News & Updates',
                        'subheading' => 'Stay informed about the latest happenings in our community.',
                    ],
                ],
                [
                    'type' => 'news_list',
                    'order' => 2,
                    'data' => [
                        'items' => [
                            [
                                'date' => 'July 20, 2025',
                                'title' => 'Major Infrastructure Projects Launched in Kalawaan',
                                'excerpt' => 'The local government has officially broken ground on several key infrastructure projects aimed at improving drainage systems and road networks within the barangay.',
                                'image' => '/images/blog1.png',
                                'featured' => true,
                            ],
                            [
                                'date' => 'July 18, 2025',
                                'title' => 'Updated Waste Collection Schedule',
                                'excerpt' => 'Please be advised of the new garbage collection schedule effective starting next week...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                            [
                                'date' => 'July 15, 2025',
                                'title' => 'Free Rabies Vaccination Drive',
                                'excerpt' => 'Protect your pets! Join the free anti-rabies vaccination campaign this coming Saturday...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                            [
                                'date' => 'July 10, 2025',
                                'title' => 'Scholarship Application Now Open',
                                'excerpt' => 'Pasig City Scholars application for the upcoming academic year is now accepting requirements...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                            [
                                'date' => 'July 5, 2025',
                                'title' => 'Senior Citizens Pension Payout',
                                'excerpt' => 'Social pension distribution for registered senior citizens will be held at the covered court...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                            [
                                'date' => 'July 1, 2025',
                                'title' => 'Fire Safety Seminar Conducted',
                                'excerpt' => 'BFP Pasig conducted a fire safety awareness seminar for residents and business owners...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                        ],
                    ],
                ],
            ]),
            'updated_at' => now(),
        ]);

        // Update "Home" page - add news section at the end and add image to about preview
        $homePage = DB::table('site_pages')->where('slug', 'home')->first();
        if ($homePage) {
            $sections = json_decode($homePage->sections, true) ?? [];

            // Add news_list section if not already present
            $hasNews = collect($sections)->contains('type', 'news_list');
            if (!$hasNews) {
                $sections[] = [
                    'type' => 'news_list',
                    'order' => count($sections) + 1,
                    'data' => [
                        'items' => [
                            [
                                'date' => 'July 20, 2025',
                                'title' => 'Major Infrastructure Projects Launched',
                                'excerpt' => 'The local government has officially broken ground on several key infrastructure projects...',
                                'image' => '/images/blog1.png',
                                'featured' => true,
                            ],
                            [
                                'date' => 'July 15, 2025',
                                'title' => 'Medical Mission Schedule Announced',
                                'excerpt' => 'Free check-ups and medicine distribution will be held at the Barangay Hall...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                            [
                                'date' => 'July 10, 2025',
                                'title' => 'Community Clean-up Drive Success',
                                'excerpt' => 'Residents volunteered for a greener and cleaner Kalawaan this weekend...',
                                'image' => '/images/blog1.png',
                                'featured' => false,
                            ],
                        ],
                    ],
                ];
            }

            DB::table('site_pages')->where('slug', 'home')->update([
                'sections' => json_encode($sections),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Revert about page to minimal sections
        DB::table('site_pages')->where('slug', 'about')->update([
            'sections' => json_encode([
                [
                    'type' => 'page_header',
                    'order' => 1,
                    'data' => [
                        'heading' => 'About Barangay Kalawaan',
                        'subheading' => 'Learn about our history, mission, and the people serving our community.',
                    ],
                ],
                [
                    'type' => 'text_block',
                    'order' => 2,
                    'data' => [
                        'heading' => 'Our History',
                        'content' => 'Kalawaan is one of the thirty barangays comprising the City of Pasig.',
                    ],
                ],
            ]),
            'updated_at' => now(),
        ]);
    }
};
