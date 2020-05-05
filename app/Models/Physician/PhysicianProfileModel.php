<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianProfileModel extends Model
{
    protected $table = "lmr_profile_physician";

    protected $fillable = [
        'user_id', 'gender', 'avatar', 'address', 'dob', 'age', 'district', 'state', 'country', 'pincode', 'landmark', 'mobile_no',
        'landline', 'about_me', 'map_image', 'qr_code', 'has_branches', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
