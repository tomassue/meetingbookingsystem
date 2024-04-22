<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblFileDataModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_file_data';

    protected $fillable = [
        'file_name',
        'file_size',
        'file_type',
        'file_data'
    ];
}
