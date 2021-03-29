<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class DepartmentsModel extends Model
{
    protected $table = "lmr_departments";
    protected $fillable = ['degree_type', 'name', 'status'];

    public function scopeBothInActive($query)
    {
        return $query->where('status', '!=', '2')->get();
    }

    public function scopeGroups($query, $degreeType)
    {
        return $query->where([
            ['degree_type','=',$degreeType],
            ['status','=', '1']
        ])->get();
    }

}
