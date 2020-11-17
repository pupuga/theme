<?php

namespace Pupuga\Libs\Data;

class Random
{
    /**
     * generates random code
     *
     * @param int $length
     * @param bool $typeSmall
     *
     * @return string
     */
    public static function generateCode($length = 3, $typeSmall = true)
    {
        if ($typeSmall === true) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        return $code;
    }
}
