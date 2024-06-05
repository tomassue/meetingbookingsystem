<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblPersonalMeetingsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_personal_meetings';

    protected $primaryKey = 'booking_no';
    protected $keyType = 'string';

    protected $fillable = [
        'booking_no',
        'start_date_time',
        'end_date_time',
        'subject',
        'description',
        'id_user'
    ];
}
