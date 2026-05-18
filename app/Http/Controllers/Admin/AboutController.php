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
        'content' => ['label' => 'Content', 'type' => 'ckeditor', 'rules' => 'nullable|string'],
        'image' => ['label' => 'Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
    ];

    protected function validationRules(): array
    {
        $rules = parent::validationRules();

        $rules['content'] = [
            'nullable',
            'string',
            function ($attribute, $value, $fail) {
                if (str_word_count(strip_tags($value)) > 1000) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' may not be greater than 1000 words.');
                }
            },
        ];

        return $rules;
    }
}
