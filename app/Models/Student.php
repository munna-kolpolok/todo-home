<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];


    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    public function details()
    {
        return $this->hasMany(Student_Detail::class, 'student_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo('App\Models\Religion');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'class_id', 'id');
    }

    public function disability()
    {
        return $this->belongsTo('App\Models\Disability');
    }

    public function orphange()
    {
        return $this->belongsTo('App\Models\Orphange');
    }

    public function blood()
    {
        return $this->belongsTo(Blood_Group::class,'blood_group_id');
    }

}
