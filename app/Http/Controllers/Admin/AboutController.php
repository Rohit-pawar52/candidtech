<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;

class AboutController extends BaseCrudController
{
    protected string $modelClass = About::class;
    protected string $routeName = 'admin.abouts';
    protected string $resourceName = 'About Section';
    protected array $fields = [
        'heading' => ['label' => 'Heading', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'content' => ['label' => 'Content', 'type' => 'textarea', 'rules' => 'nullable|string'],
        'image' => ['label' => 'Image Path', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
    ];
}
