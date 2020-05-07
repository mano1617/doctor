<?php

namespace App\Models\Physician;

use Illuminate\Database\Eloquent\Model;

class PhysicianProfessionModel extends Model
{
    protected $table = "lmr_profile_physician_profession";

    protected $fillable = [
        'user_id', 'sector', 'clinic_type', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
