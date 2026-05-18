<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;

class FaqController extends BaseCrudController
{
    protected string $modelClass = Faq::class;
    protected string $routeName = 'admin.faqs';
    protected string $resourceName = 'FAQ';
    protected array $fields = [
        'question' => ['label' => 'Question', 'type' => 'text', 'rules' => 'required|string|max:255'],
        'answer' => ['label' => 'Answer', 'type' => 'ckeditor', 'rules' => 'required|string'],
    ];

    protected function validationRules(): array
    {
        $rules = parent::validationRules();
        $rules['answer'] = [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                if (\App\Helpers\HtmlHelper::wordCount($value) > 300) {
                    $fail('The answer may not be greater than 300 words.');
                }
            },
        ];
        return $rules;
    }
}
