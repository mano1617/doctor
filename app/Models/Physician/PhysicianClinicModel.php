<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianClinicModel extends Model
{
    protected $table = "lmr_physician_clinic";

    protected $fillable = [
        'user_id', 'name', 'address', 'district', 'state', 'country', 'pincode', 'landmark', 'mobile_no', 'landline',
        'email_address', 'website', 'map_image', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
