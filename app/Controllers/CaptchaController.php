<?php

namespace App\Controllers;

class CaptchaController extends BaseController
{
   public function math()
{
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $answer = $num1 + $num2;

    session()->set('math_captcha', $answer);

    $width = 140;
    $height = 45;

    $image = imagecreatetruecolor($width, $height);

    // light background
    $bg = imagecolorallocate($image, 245, 248, 250);
    imagefilledrectangle($image, 0, 0, $width, $height, $bg);

    // colors like screenshot
    $green = imagecolorallocate($image, 60, 180, 75);
    $blue  = imagecolorallocate($image, 0, 120, 215);
    $gray  = imagecolorallocate($image, 120, 120, 120);

    // noise
    for ($i = 0; $i < 6; $i++) {
        imageline(
            $image,
            rand(0,$width),
            rand(0,$height),
            rand(0,$width),
            rand(0,$height),
            $gray
        );
    }

    // colors
    $green = imagecolorallocate($image, 70, 180, 80);
    $blue  = imagecolorallocate($image, 40, 90, 200);
    $gray  = imagecolorallocate($image, 120, 120, 120);

    // text
    imagestring($image, 5, 20, 12, $num1, $green);
    imagestring($image, 5, 40, 12, '+', $gray);
    imagestring($image, 5, 55, 12, $num2, $blue);
    imagestring($image, 5, 80, 12, '=', $gray);

    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
    exit;
}
}