<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileGalleryModel extends Model
{
    protected $table = "lmr_profile_gallery";

    protected $fillable = [
        'user_id', 'name', 'file_name', 'date_added', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
