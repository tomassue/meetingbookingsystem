<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblNotificationsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_notifications';

    protected $fillable = [
        'id_booking_no',
        'id_user',
        'is_read'
    ];
}
