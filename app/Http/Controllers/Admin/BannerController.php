<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;

class BannerController extends BaseCrudController
{
    protected string $modelClass = Banner::class;
    protected string $routeName = 'admin.banners';
    protected string $resourceName = 'Banner';
    protected array $fields = [
        'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'rules' => 'nullable|string'],
        'button_text' => ['label' => 'Button Text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'button_url' => ['label' => 'Button URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
        'background_image' => ['label' => 'Background Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
    ];
}
