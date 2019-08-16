<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Profile extends Model
{
    use SoftDeletes;
	
	protected $table = 'user_profiles';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
	}

	public function blogGroup()
    {
        return $this->belongsTo(Blood_Group::class,'blood_group_id');
    }
}
