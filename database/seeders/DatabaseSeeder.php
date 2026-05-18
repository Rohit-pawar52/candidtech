<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Banner;
use App\Models\CompanyDetail;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'is_admin' => true,
        ]);

        Banner::create([
            'title' => 'Design the space',
            'subtitle' => 'Engineer the experience',
            'button_text' => 'Get a Quote',
            'button_url' => '#contact',
            'background_image' => 'upload/s1.jpeg',
        ]);

        About::create([
            'heading' => 'Candidtech Interiors',
            'content' => 'At CandidTech, as one of the UAE’s leading fit-out contractors, we create luxury spaces where creativity is engineered to perfection. From villas and apartments to commercial offices, clinics, business centers, commercial restaurants, and retail fit-outs, we deliver seamless style, functionality, and flawless execution.',
            'image' => 'upload/about1.jpeg',
        ]);

        $services = [
            [
                'icon' => 'upload/service1.jpeg',
                'title' => 'Designing and Space Planning',
                'description' => 'We create functional, aesthetic plans that maximize every square foot of your interior.',
                'link' => '#',
            ],
            [
                'icon' => 'upload/service2.jpeg',
                'title' => 'Drawings and Approvals',
                'description' => 'Expert architectural drawings and approval support for smooth project execution.',
                'link' => '#',
            ],
            [
                'icon' => 'upload/service3.jpeg',
                'title' => 'Turnkey Fit Out',
                'description' => 'Complete turnkey fit-out solutions from concept to handover.',
                'link' => '#',
            ],
            [
                'icon' => 'upload/service4.jpeg',
                'title' => 'MEP Services',
                'description' => 'Reliable MEP coordination and delivery for modern interior spaces.',
                'link' => '#',
            ],
            [
                'icon' => 'upload/service5.jpeg',
                'title' => 'Joinery',
                'description' => 'Custom joinery and millwork that enhances design and durability.',
                'link' => '#',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $features = [
            [
                'icon' => 'upload/trust.png',
                'title' => 'Interior Expertise',
                'description' => 'Our team specializes in smart interior solutions for residential and commercial spaces.',
            ],
            [
                'icon' => 'upload/repeat.png',
                'title' => 'Free Consultation',
                'description' => 'Start your project with a no-cost consultation from our expert designers.',
            ],
            [
                'icon' => 'upload/delivery.png',
                'title' => 'Quick Deals',
                'description' => 'Fast turnaround proposals and clear project estimates.',
            ],
            [
                'icon' => 'upload/support.png',
                'title' => 'Affordable Price',
                'description' => 'Competitive pricing without compromising finish or quality.',
            ],
            [
                'icon' => 'upload/support.png',
                'title' => '24/7 Support',
                'description' => 'Responsive support to keep your project on track.',
            ],
            [
                'icon' => 'upload/support.png',
                'title' => 'Satisfaction Guaranteed',
                'description' => 'We deliver interior experiences designed to exceed expectations.',
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }

        $projects = [
            [
                'title' => 'Luxury Apartment Interior',
                'category' => 'Residential',
                'image' => 'upload/service1.jpeg',
                'url' => '#',
            ],
            [
                'title' => 'Office Fit-Out',
                'category' => 'Commercial',
                'image' => 'upload/service2.jpeg',
                'url' => '#',
            ],
            [
                'title' => 'Retail Space',
                'category' => 'Retail',
                'image' => 'upload/service3.jpeg',
                'url' => '#',
            ],
            [
                'title' => 'Healthcare Interior',
                'category' => 'Healthcare',
                'image' => 'upload/service4.jpeg',
                'url' => '#',
            ],
            [
                'title' => 'Restaurant Design',
                'category' => 'Hospitality',
                'image' => 'upload/service5.jpeg',
                'url' => '#',
            ],
            [
                'title' => 'Corporate Reception',
                'category' => 'Corporate',
                'image' => 'upload/service1.jpeg',
                'url' => '#',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        $testimonials = [
            [
                'name' => 'Khalid Al Mansoori',
                'position' => 'Dubai',
                'quote' => 'Candidtech delivered a flawless interior fit-out with excellent communication and timely completion.',
                'avatar' => 'upload/face.jpg',
            ],
            [
                'name' => 'Sara Ahmed',
                'position' => 'Business Center',
                'quote' => 'The team created a beautiful and functional office space that impressed our clients.',
                'avatar' => 'upload/face.jpg',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $faqs = [
            [
                'question' => 'What services do you provide?',
                'answer' => 'We provide interior design, space planning, drawings & approvals, turnkey fit-out, MEP services, and joinery.',
            ],
            [
                'question' => 'How long does a fit-out project take?',
                'answer' => 'Timelines vary by scale, but we work to deliver high quality results efficiently and transparently.',
            ],
            [
                'question' => 'Do you provide turnkey solutions?',
                'answer' => 'Yes, we manage turnkey projects from design concept through construction and handover.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        CompanyDetail::create([
            'phone' => '+971 555309790',
            'email' => 'info@candidtecheim.com',
            'address' => 'Office No. 5, 2nd Floor, Arif 7 Bintoak Building, Karama - Dubai',
            'facebook' => 'https://facebook.com/candidtech',
            'twitter' => 'https://twitter.com/candidtech',
            'instagram' => 'https://instagram.com/candidtech',
            'linkedin' => 'https://linkedin.com/company/candidtech',
        ]);

        ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'I would like to learn more about your interior fit-out services for a retail space.',
        ]);
    }
}
