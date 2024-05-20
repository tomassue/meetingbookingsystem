<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblAttendeesModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_attendees';

    protected $fillable = [
        'id_booking_no',
        'id_users'
    ];
}
