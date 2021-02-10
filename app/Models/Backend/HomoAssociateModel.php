<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class HomoAssociateModel extends Model
{
    protected $table = "lmr_homoeo_associate";
    protected $fillable = [
        "user_id", "name", "since", "region_circle", "moto", "admin_name", "bearers", "members", "latest_news", "mobile_no", "email_address",
        "new_events", "website", "posts", "profile_image", "description", "notifications", "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2');
    }
}
