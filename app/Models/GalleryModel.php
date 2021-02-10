<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    protected $table = "lmr_galleries";

    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'description',
        'sorting',        
        'clinic_id',        
        'user_id'                
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function clinic()
    {
        return $this->belongsTo(PhysicianClinicModel::class,'clinic_id');
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('status', '1')->orderBy('sorting')->get();
    }
    public function scopeBothInActive($query)
    {
        return $query->where('status','!=','2')->orderBy('sorting')->get();
    }
}
