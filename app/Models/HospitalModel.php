<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Physician\PhysicianClinicTimesModel;
use App\Models\Physician\PhysicianMembershipModel;
use App\Models\Backend\HospitalConsultantModel;
use App\Models\Backend\HospitalGalleryModel;

class HospitalModel extends Model
{
    protected $table = "lmr_hospitals";
    protected $fillable = [
        'user_id', 'name', 'since', 'address', 'district', 'state', 'country', 'pincode', 'landmark', 'mobile_no', 'contact_numbers',
        'email_address', 'website', 'profile_image', 'status', 'about_us', 'other_description', 'is_branch'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\Auth\User::class,'user_id');
    }

    public function workingDays()
    {
        return $this->hasMany(PhysicianClinicTimesModel::class,'clinic_id')->where([
            ['status','=','1'],
            ['clinic_type','=','hospital']
        ]);
    }

    public function achievements()
    {
        return $this->hasMany(PhysicianMembershipModel::class,'record_type');
    }

    public function consultants()
    {
        return $this->hasMany(HospitalConsultantModel::class,'hospital_id')->where([
            ['status','!=','2']
        ]);
    }

    public function galleries()
    {
        return $this->hasMany(HospitalGalleryModel::class,'hospital_id')->where([
            ['status','!=','2']
        ]);
    }
}
