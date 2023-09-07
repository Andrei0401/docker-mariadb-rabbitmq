<?php
namespace App\Helper;

class Url {

    public static function generateUrl()
    {
        $bytes = random_bytes(mt_rand(5, 10));
        return sprintf('http://%s.com', bin2hex($bytes));
    }

    public static function generateUrls($count = 10) {
        $urls = array();
        for($i = 0; $i < $count; $i++) {
            $urls[] = self::generateUrl();
        }
        return $urls;
    }
}
