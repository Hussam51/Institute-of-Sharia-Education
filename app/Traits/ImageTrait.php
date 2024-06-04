<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function uploadImage($img,$path)
    {
       
        $imageName=$img->getClientOriginalName();
      return $imageUrl= $img->move($path,$imageName);
    }


    public function deleteImage($imagePath)
{
    if (Storage::disk('public')->exists($imagePath)) {
        Storage::disk('public')->delete($imagePath);
        return true;
    }
    
    return false;
}

   
}