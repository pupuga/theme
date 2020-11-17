<?php

namespace Pupuga\Libs\Data;

class Xml
{
    /**
     * @return object
     */
    public static function xmlToObjects($xml)
    {
        $objects = null;

        if ($xml) {
            $xml = '<?xml version="1.0" encoding="UTF-8" ?><structure>' . str_replace('&', '&amp;', $xml) . '</structure>';
            try {
                $objects = new \SimpleXMLElement($xml);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return $objects;
    }

}