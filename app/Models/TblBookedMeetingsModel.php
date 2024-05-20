<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblBookedMeetingsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_booked_meetings';
    protected $primaryKey = "booking_no";
    public $keyType = 'string'; # This works like the cast 'key' => string. Since our primary key is a mixed integers and strings, we need to declare it as a string.

    protected $fillable = [
        'booking_no',
        'start_date_time',
        'end_date_time',
        'type_of_attendees',
        //* Attendees are now saved in another table.
        //// 'attendees',
        'subject',
        'id_file_data',
        'meeting_description'
    ];
}
