<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Http\Request;

class captchaController extends Controller
{


    public function create()
    {
        $code = rand(10000, 99999);
        session(['code' => $code]);

        $width = 170;
        $height = 60;


        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 110, 110, 110);
        $medgray = imagecolorallocate($image, 180, 180, 180);
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefilledrectangle($image, 0, 0,  $width , $height, $white);

        $square_count = 6;
        for ($i = 0; $i <$square_count; $i++) {
            $cx = (int)rand(0, $width / 2);
            $cy = (int)rand(0, $height);
            $h = $cy + (int)rand(0, $height / 5);
            $w = $cx + (int)rand($width / 3, $width);
            imagefilledrectangle($image, $cx, $cy, $w, $h, $medgray);
        }
        $ellipse_count =  7;
        for ($i = 0; $i < $ellipse_count; $i++) {
            $cx = (int)rand(-1*($width/2), $width + ($width/2));
            $cy = (int)rand(-1*($height/2), $height + ($height/2));
            $h  = (int)rand($height/2, 2*$height);
            $w  = (int)rand($width/2, 2*$width);
            imageellipse($image, $cx, $cy, $w, $h, $gray);
        }


        imagettftext($image, 30, 0, 10, 40, $color, 'sahel/Sahel.ttf', $code);
        return response((string)imagepng($image))->header('Content-Type', 'image/png');
    }
}
