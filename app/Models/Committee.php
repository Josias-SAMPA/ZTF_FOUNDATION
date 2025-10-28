<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table='committees';
    protected $fillable=[
        'name',
        'description'
    ];

    public function departments(){
        return $this->hasMany(Department::class);
    }
}
