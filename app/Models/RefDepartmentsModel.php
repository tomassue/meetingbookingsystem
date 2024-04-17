<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDepartmentsModel extends Model
{
    use HasFactory;

    protected $table = 'ref_departments';

    protected $fillable = [
        'department_name'
    ];
}
