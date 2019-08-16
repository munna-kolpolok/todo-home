<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Role_User extends Model
{
    use SoftDeletes;
	
	protected $table = 'role_users';
	//protected $table = 'role_user'; for role_user
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

}
