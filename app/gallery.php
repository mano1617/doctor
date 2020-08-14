<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'clinic_id',
        'physician_id',        
        'order_no'       
    ];
}
