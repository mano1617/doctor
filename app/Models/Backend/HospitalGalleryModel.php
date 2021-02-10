<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class HospitalGalleryModel extends Model
{
    protected $table = "lmr_hospital_galleries";

    protected $fillable = [ 'title', 'file_path', 'file_type', 'uploaded_at', 'description', 'sorting', 'hospital_id', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(HospitalModel::class, 'hospital_id');
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('status', '1')->orderBy('sorting')->get();
    }

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2')->orderBy('sorting')->get();
    }
}
