<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSignatoriesModel extends Model
{
    use HasFactory;

    protected $table = 'ref_signatories';

    protected $fillable = [
        'honorifics',
        'full_name',
        'title',
        'signature'
    ];
}
