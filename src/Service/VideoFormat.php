<?php


namespace App\Service;


class VideoFormat
{
    public function extractUrl($fullLink)
    {

        $link = $fullLink->getLink();
        $myExplode = explode("\"", $link);

        foreach ($myExplode as $value) {

            if (preg_match('#(((https?|ftp)://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4}))#', $value, $match)) {
                return $fullLink->setlink($value);

            }
        }

    }


}