<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyDetail;

class CompanyDetailController extends BaseCrudController
{
    protected string $modelClass = CompanyDetail::class;
    protected string $routeName = 'admin.company-details';
    protected string $resourceName = 'Company Details';
    protected array $fields = [
        'phone' => ['label' => 'Phone', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
        'email' => ['label' => 'Email', 'type' => 'email', 'rules' => 'nullable|email|max:255'],
        'address' => ['label' => 'Address', 'type' => 'textarea', 'rules' => 'nullable|string'],
        'facebook' => ['label' => 'Facebook URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
        'twitter' => ['label' => 'Twitter URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
        'instagram' => ['label' => 'Instagram URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
        'linkedin' => ['label' => 'LinkedIn URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
    ];
}
