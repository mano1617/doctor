<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use App\Models\Auth\Traits\Scope\UserScope;


/**
 * Class User.
 */
class User extends BaseUser
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;

    public function gallery()
    {
        return $this->hasMany(ProfileGalleryModel::class,'user_id');
    }

    public function physicianProfile()
    {
        return $this->hasOne('App\Models\Physician\PhysicianProfileModel','user_id');
    }

    public function physicianEducation()
    {
        // return $this->hasOne('App\Models\Physician\PhysicianEduModel','user_id');
        return $this->hasMany('App\Models\Physician\PhysicianEduModel','user_id');
    }

    public function physicianAdditionalEducation()
    {
        return $this->hasOne('App\Models\Physician\PhysicianAdditionalEduModel','user_id');
    }

    public function physicianProfession()
    {
        return $this->hasOne('App\Models\Physician\PhysicianProfessionModel','user_id');
    }

    public function physicianExperience()
    {
        return $this->hasOne('App\Models\Physician\PhysicianExperienceModel','user_id');
    }

    public function physicianMembAchives()
    {
        return $this->hasOne('App\Models\Physician\PhysicianMembershipModel','user_id');
    }

    public function scopeBothInActive($query)
    {
        return $query->where('active','!=',2)->latest('first_name')->get();
    }
}
