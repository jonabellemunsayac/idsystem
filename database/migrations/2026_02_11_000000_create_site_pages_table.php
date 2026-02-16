<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('sections')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Seed the default pages matching existing public views
        DB::table('site_pages')->insert([
            [
                'title' => 'Home',
                'slug' => 'home',
                'sections' => json_encode([
                    [
                        'type' => 'hero',
                        'order' => 1,
                        'data' => [
                            'badge' => 'Welcome to Pasig City',
                            'heading' => 'Experience a Progressive & Safe Community',
                            'subheading' => 'Barangay Kalawaan is committed to providing efficient public service, ensuring safety, and fostering unity among its residents.',
                            'button_text' => 'Explore Services',
                            'button_link' => '/services',
                            'button2_text' => 'Learn More',
                            'button2_link' => '/about',
                        ],
                    ],
                    [
                        'type' => 'services_grid',
                        'order' => 2,
                        'data' => [
                            'label' => 'Our Service',
                            'heading' => 'Efficient Public Service',
                            'subheading' => 'Access barangay services online or visit us for assistance.',
                            'items' => [
                                ['icon' => 'bi-person-badge', 'title' => 'Barangay ID', 'description' => 'Get your official identification card for valid transactions.'],
                                ['icon' => 'bi-file-earmark-check', 'title' => 'Clearance', 'description' => 'Apply for barangay clearance for employment or other purposes.'],
                                ['icon' => 'bi-check-circle', 'title' => 'Certificates', 'description' => 'Request certificates of residency, indigency, and more.'],
                                ['icon' => 'bi-shop', 'title' => 'Business Permit', 'description' => 'Secure necessary permits for your local business operations.'],
                            ],
                        ],
                    ],
                    [
                        'type' => 'about_preview',
                        'order' => 3,
                        'data' => [
                            'label' => 'About Us',
                            'heading' => 'A Historic & Vibrant Community',
                            'description' => 'Kalawaan is one of the thirty barangays comprising the City of Pasig. Sprawling along the legendary Pasig River, it has grown from a humble settlement of duck raisers in 1926 to a thriving residential and commercial area today.',
                            'image' => 'images/kalawaan.jpg',
                            'location' => 'Pasig City',
                            'land_area' => '200+ hectares',
                        ],
                    ],
                ]),
                'meta' => json_encode(['description' => 'Barangay Kalawaan official website']),
                'is_published' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
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
                            'content' => 'Kalawaan is one of the thirty barangays comprising the City of Pasig. Along the legendary Pasig River, it has grown from a humble settlement of duck raisers in 1926 to a thriving residential and commercial area today.',
                        ],
                    ],
                ]),
                'meta' => json_encode(['description' => 'About Barangay Kalawaan']),
                'is_published' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'sections' => json_encode([
                    [
                        'type' => 'page_header',
                        'order' => 1,
                        'data' => [
                            'heading' => 'Barangay Services',
                            'subheading' => 'We offer various services to assist our residents.',
                        ],
                    ],
                    [
                        'type' => 'services_list',
                        'order' => 2,
                        'data' => [
                            'items' => [
                                ['icon' => 'bi-person-badge', 'title' => 'Barangay ID', 'description' => 'Get your official barangay identification card.'],
                                ['icon' => 'bi-file-earmark-check', 'title' => 'Barangay Clearance', 'description' => 'Apply for barangay clearance for employment or legal purposes.'],
                                ['icon' => 'bi-check-circle', 'title' => 'Certificates', 'description' => 'Request certificates of residency, indigency, and more.'],
                                ['icon' => 'bi-shop', 'title' => 'Business Permit', 'description' => 'Secure permits for local business operations.'],
                            ],
                        ],
                    ],
                ]),
                'meta' => json_encode(['description' => 'Barangay Kalawaan services']),
                'is_published' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'News & Updates',
                'slug' => 'news',
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
                                ['date' => 'July 15, 2025', 'title' => 'Medical Mission Schedule Announced', 'excerpt' => 'Free check-ups and medicine distribution will be held at the Barangay Hall.', 'featured' => false],
                                ['date' => 'July 10, 2025', 'title' => 'Community Clean-up Drive Success', 'excerpt' => 'Residents volunteered for a greener and cleaner Kalawaan this weekend.', 'featured' => false],
                                ['date' => 'July 4, 2025', 'title' => 'Pasig LGU acts on Topaz Road incident', 'excerpt' => 'Local government agencies coordinate to address safety concerns in the area.', 'featured' => true],
                            ],
                        ],
                    ],
                ]),
                'meta' => json_encode(['description' => 'Barangay Kalawaan news and updates']),
                'is_published' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'sections' => json_encode([
                    [
                        'type' => 'page_header',
                        'order' => 1,
                        'data' => [
                            'heading' => 'Contact Us',
                            'subheading' => 'Get in touch with the Barangay Kalawaan office.',
                        ],
                    ],
                    [
                        'type' => 'contact_info',
                        'order' => 2,
                        'data' => [
                            'address' => 'Barangay Hall, Kalawaan, Pasig City',
                            'phone' => '(02) 8643-1111',
                            'email' => 'brgykalawaan.gov@gmail.com',
                            'office_hours' => 'Monday - Friday, 8:00 AM - 5:00 PM',
                            'facebook' => 'https://www.facebook.com/barangay.kalawaan.2024',
                        ],
                    ],
                ]),
                'meta' => json_encode(['description' => 'Contact Barangay Kalawaan']),
                'is_published' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pages');
    }
};
