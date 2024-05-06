<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblMeetingFeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_meeting_feedback';

    protected $fillable = [
        'id_booking_no',
        'attendee',
        'meeting_status',
        'proxy'
    ];
}
