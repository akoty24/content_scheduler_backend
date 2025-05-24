<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait storeImage
{
    public function storeImage($image_path, $path)
    {
        if (file_exists($image_path) && is_readable($image_path)) {
            $image = $image_path;
            $image_name = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $image_name);
            return $path . '/' . $image_name;
                } else {
                    throw new \Exception('The file does not exist or is not readable.');
                }

     
    }

}