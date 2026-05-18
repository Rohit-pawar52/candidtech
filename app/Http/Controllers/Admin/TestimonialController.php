<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;

class TestimonialController extends BaseCrudController
{
    protected string $modelClass = Testimonial::class;
    protected string $routeName = 'admin.testimonials';
    protected string $resourceName = 'Testimonial';
    protected array $fields = [
        'name' => ['label' => 'Name', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'position' => ['label' => 'Position', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'quote' => ['label' => 'Quote', 'type' => 'textarea', 'rules' => 'required|string'],
        'avatar' => ['label' => 'Avatar Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
    ];
}
