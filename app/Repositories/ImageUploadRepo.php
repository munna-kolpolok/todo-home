<?php

namespace App\Repositories;

use File;
use Image;

class ImageUploadRepo
{
    public static function uploadImage($path, $image, $dimension, $existing_path = null)
    {
        $database_image_path = '';
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if (File::exists($path)) {
            //remove existing image when update operation
            if (!empty($existing_path)) {
                $existing_image = public_path().'/'.$existing_path;
                if (file_exists($existing_image)) {
                    //first unlink the image
                    @unlink($existing_image);
                }
            }

            $databasePath = str_replace(public_path().'/', '',$path);
            list($width, $height) = explode('-',$dimension);
            $image_name = 'bidyanondo-'.uniqid().'.'.$image->getClientOriginalExtension();
            $image_path=$path . $image_name;
            Image::make($image->getRealPath())->resize($width, $height)->save($image_path);
            $database_image_path=$databasePath.$image_name;
        }
        return $database_image_path;
    }

    public static function unlinkPath($image)
    {
        $image_path = public_path() . '/' . $image;
        if (file_exists($image_path)) {
            //first unlink the image
            @unlink($image_path);
        }
        return true;
    }

    public static function deleteDirectory($path)
    {
        if (File::exists($path)){
            File::deleteDirectory($path);
        }
        return true;
    }
}