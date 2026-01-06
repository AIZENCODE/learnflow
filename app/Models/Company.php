<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'website',
        'color_hex',
        'logo_path',
        'favicon_path',
        'banner_path',
        'background_path',
        'logo_path_dark',
        'favicon_path_dark',
        'banner_path_dark',
        'background_path_dark',
        'created_by',
        'updated_by',
    ];
}
