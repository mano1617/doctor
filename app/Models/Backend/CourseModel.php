<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    protected $table = "lmr_courses";
    protected $fillable = ['name', 'status'];

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2')->get();
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('status', '1')->get();
    }
}
