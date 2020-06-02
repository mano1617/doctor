<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianEduModel extends Model
{

    protected $table = "lmr_profile_physician_education";

    protected $fillable = [
        'user_id', 'branch_of_medicine', 'registration_no', 'medical_council', 'professional_qualification', 'additional_qualification', 'status'        
    ];    

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
}
