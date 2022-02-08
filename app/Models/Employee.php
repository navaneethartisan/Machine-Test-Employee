<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function MyDesignation()
    {
        return $this->hasOne(Designation::class,'id','designation_id');
    }
}
