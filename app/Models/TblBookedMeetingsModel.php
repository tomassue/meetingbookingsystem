<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblBookedMeetingsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_booked_meetings';

    protected $fillable = [
        'start_date_time',
        'end_date_time',
        'type_of_attendees',
        'attendees',
        'subject',
        'id_file_data',
        'meeting_description'
    ];
}
