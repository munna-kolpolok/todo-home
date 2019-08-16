<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Project_Story_Translation extends Model
{
    use SoftDeletes;
	
	protected $table = 'sr_project_story_translations';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	protected $fillable = ['title','description'];

    public function storyLanguage()
    {
        return $this->belongsTo('App\Models\Language','locale','code');
    }
}