<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use SoftDeletes;
	

	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
	}

    public function gender()
    {
        return $this->belongsTo(Gender::class,'gender_id');
    }
}
