<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianClinicModel extends Model
{
    protected $table = "lmr_physician_clinic";

    protected $fillable = [
        'clinic_type','user_id', 'name', 'address', 'district', 'state', 'country', 'pincode', 'landmark', 'mobile_no', 'landline',
        'email_address', 'website', 'map_image', 'status', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\Auth\User::class,'user_id');
    }

    public function workingDays()
    {
        return $this->hasMany(PhysicianClinicTimesModel::class,'clinic_id')->where('status','1');
    }

    public function consultants()
    {
        return $this->hasMany(PhysicianClinicConsultsModel::class,'clinic_id')->where([
            ['status','!=','2']
        ]);
    }
    
}
