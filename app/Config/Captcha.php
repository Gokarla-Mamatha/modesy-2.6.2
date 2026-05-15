<?php

namespace Config;

use Mews\Captcha\Config\Captcha as BaseCaptcha;

class Captcha extends BaseCaptcha
{
    public $characters = '2346789abcdefghjmnpqrtuxyz';
    public $length = 5;
    public $width = 150;
    public $height = 40;
    public $quality = 90;
    public $math = false;
    public $expire = 60;
}