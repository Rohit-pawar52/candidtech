<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Banner;
use App\Models\CompanyDetail;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'banners' => Banner::count(),
            'services' => Service::count(),
            'abouts' => About::count(),
            'features' => Feature::count(),
            'projects' => Project::count(),
            'testimonials' => Testimonial::count(),
            'faqs' => Faq::count(),
            'contactMessages' => ContactMessage::count(),
            'companyDetails' => CompanyDetail::count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
