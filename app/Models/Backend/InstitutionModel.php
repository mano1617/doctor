<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class InstitutionModel extends Model
{
    protected $table = "lmr_homoeo_institutions";
    protected $fillable = [
        "user_id", "name", "since", "address", "district", "state", "country", "pincode", "landmark", "mobile_no", "email_address",
        "website", "profile_image", "about_us", "contact_nos", "achievements", "courses", "courses_ug", "courses_pg", "acreditations",
        "opd_hospital", "ipd_hospital", "status"
    ];

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2');
    }
}
