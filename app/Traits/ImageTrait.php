<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function uploadImage($img,$path)
    {
       
        $imageName=$img->getClientOriginalName();

         $imageUrl= $img->storeAs($path,$imageName,[
            'disk'=>'uploads'
        ]);
        return $imageUrl;
     // return $imageUrl= $img->move($path,$imageName);
    }


    public function deleteImage($imagePath)
{
    if (Storage::disk('uploads')->exists($imagePath)) {
        Storage::disk('uploads')->delete($imagePath);
        return true;
    }
    
    return false;
}

   
}