<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
	
	protected $table = 'users';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function profile()
    {
        return $this->hasOne(User_Profile::class);
	}

    public function scholarshipDonors()
    {
        return $this->hasMany(Scholarship_Donor::class, 'user_id', 'id');
    }
}
