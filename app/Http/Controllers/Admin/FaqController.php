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
        'answer' => ['label' => 'Answer', 'type' => 'textarea', 'rules' => 'required|string'],
    ];
}
