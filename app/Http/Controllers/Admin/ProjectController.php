<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;

class ProjectController extends BaseCrudController
{
    protected string $modelClass = Project::class;
    protected string $routeName = 'admin.projects';
    protected string $resourceName = 'Project';
    protected array $fields = [
        'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'category' => ['label' => 'Category', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'image' => ['label' => 'Image Path', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'url' => ['label' => 'Project URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
    ];
}
