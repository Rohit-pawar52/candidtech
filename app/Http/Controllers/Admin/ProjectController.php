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
        'description' => ['label' => 'Description', 'type' => 'ckeditor', 'rules' => 'nullable|string'],
        'image' => ['label' => 'Project Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
        'url' => ['label' => 'Project URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
    ];

    protected function validationRules(): array
    {
        $rules = parent::validationRules();
        $rules['description'] = [
            'nullable',
            'string',
            function ($attribute, $value, $fail) {
                if ($value && \App\Helpers\HtmlHelper::wordCount($value) > 400) {
                    $fail('The description may not be greater than 400 words.');
                }
            },
        ];
        return $rules;
    }
}
