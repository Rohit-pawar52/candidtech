<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;

class FeatureController extends BaseCrudController
{
    protected string $modelClass = Feature::class;
    protected string $routeName = 'admin.features';
    protected string $resourceName = 'Feature';
    protected array $fields = [
        'icon' => ['label' => 'Icon/Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
        'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => 'nullable|string'],
    ];
}
