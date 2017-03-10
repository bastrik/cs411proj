<?php
require_once("head.php");
function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'y',
        2592000 => 'mo',
        604800 => 'w',
        86400 => 'd',
        3600 => 'h',
        60 => 'm',
        1 => 's'
    );
    if($time<1){
        return '0 seconds';
    }

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.$text;
    }

}
function processString($content)
{
    $content = preg_replace('~(\s|^)(https?://.+?)(\s|$)~im','$1<a href="$2" target="_blank">$2</a>$3',$content);
    $content = preg_replace('~(\s|^)(www\..+?)(\s|$)~im','$1<a href="http://$2" target="_blank">$2</a>$3',$content);
    return $content;
}
