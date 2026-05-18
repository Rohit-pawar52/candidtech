<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
    ];
}
