<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class WorkTimesModel extends Model
{
    protected $table = "lmr_work_times";

    protected $fillable = [
        'user_id', 'parent_type', 'parent_id', 'day_name', 'morning_session_time', 'evening_session_time', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(HomoeopharmacyModel::class,'parent_id')->where('parent_type','pharmacy');
    }
}
