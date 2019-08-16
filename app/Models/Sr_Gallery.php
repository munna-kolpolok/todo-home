<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Gallery extends Model
{
    use SoftDeletes;
    use Translatable;
	
	protected $table = 'sr_galleries';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public $translationModel = 'App\Models\Sr_Gallery_Translation';
    public $translationForeignKey = 'sr_gallery_id';
    public $translatedAttributes = ['album_name'];

    public function gallery_images()
    {
        return $this->hasMany('App\Models\Sr_Gallery_Image','sr_gallery_id');
    }

    public function mainImage()
    {
        return $this->hasOne(Sr_Gallery_Image::class, 'sr_gallery_id');
    }

    public function galleriesTranslations()
    {
        return $this->hasMany(Sr_Gallery_Translation::class, 'sr_gallery_id');
    }

    public function englishGallery()
    {
        return $this->hasOne(Sr_Gallery_Translation::class, 'sr_gallery_id')->where('locale','en');
    }

}
