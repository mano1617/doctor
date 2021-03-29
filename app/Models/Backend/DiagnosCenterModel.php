<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class DiagnosCenterModel extends Model
{
    protected $table = "lmr_diagnos_centers";
    protected $fillable = [
        "user_id", "name", "parent_id", "since", "address", "state", "district", "country", "pincode", "landmark", "mobile_no", "email_address",
        "landline", "website", "map_image", "profile_image", "description", "have_branch", "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workingDays()
    {
        return $this->hasMany(WorkTimesModel::class, 'parent_id')
            ->where([
                ['status', '=', '1'],
                ['parent_type', '=', 'diagnostic'],
            ]);
    }

    public function galleries()
    {
        return $this->hasMany(GalleriesModel::class,'parent_id')->where([
            ['status','!=','2'],
            ['parent_type','=','diagnostic']
        ]);
    }

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2');
    }
}
