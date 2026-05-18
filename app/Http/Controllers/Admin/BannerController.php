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
        'subtitle' => ['label' => 'Subtitle', 'type' => 'ckeditor', 'rules' => 'nullable|string'],
        'button_text' => ['label' => 'Button Text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'button_url' => ['label' => 'Button URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
        'background_image' => ['label' => 'Background Image', 'type' => 'file', 'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'],
    ];

    protected function validationRules(): array
    {
        $rules = parent::validationRules();
        $rules['subtitle'] = [
            'nullable',
            'string',
            function ($attribute, $value, $fail) {
                if ($value && \App\Helpers\HtmlHelper::wordCount($value) > 100) {
                    $fail('The subtitle may not be greater than 100 words.');
                }
            },
        ];
        return $rules;
    }
}
