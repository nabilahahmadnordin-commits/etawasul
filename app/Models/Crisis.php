<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crisis extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'Crisis_ID';

    protected $fillable = [
        'Crisis_Type',
        'Crisis_Description',
        'Crisis_Severity',
        'Impact_level',
        'Location',
        'Date_Reported',
        'Status',
    ];
}
