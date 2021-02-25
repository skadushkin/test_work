<?php
namespace common\helpers;

class RandHelper {

    public static function color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}