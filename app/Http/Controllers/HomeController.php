<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Banner;
use App\Models\CompanyDetail;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Banner::latest()->first();
        $services = Service::all();
        $about = About::latest()->first();
        $features = Feature::all();
        $testimonials = Testimonial::all();
        $projects = Project::all();
        $faqs = Faq::all();
        $company = CompanyDetail::latest()->first();

        return view('home', compact(
            'banner',
            'services',
            'about',
            'features',
            'testimonials',
            'projects',
            'faqs',
            'company'
        ));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
}
