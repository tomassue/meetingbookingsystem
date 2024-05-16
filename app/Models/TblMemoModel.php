<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblMemoModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_memo';

    protected $fillable = [
        'id_booking_no',
        // 'subject',
        'message',
        'id_ref_signatories'
    ];
}
