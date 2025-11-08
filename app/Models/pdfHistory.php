<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pdfHistory extends Model
{
    protected $fillable = [
        'department_id',
        'user_id',
        'filename',
        'filepath',
        'url'
    ];

    
}
