<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends BaseCrudController
{
    protected string $modelClass = Service::class;
    protected string $routeName = 'admin.services';
    protected string $resourceName = 'Service';
    protected array $fields = [
        'icon' => ['label' => 'Icon', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => 'nullable|string'],
        'link' => ['label' => 'Link (optional)', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
    ];
}
