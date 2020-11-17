<?php

namespace Pupuga\Libs\Data;

class Check
{
    /**
     * is string a integer ?
     *
     * @param $string
     *
     * @return bool
     */
    public static function isInteger($string)
    {
        $boolean = false;

        if (!empty($string) && ctype_digit($string) && is_numeric($string)) {
            $boolean = true;
        }

        return $boolean;
    }

    /**
     * is string a phone ?
     *
     * @param $string
     *
     * @return bool
     */
    public static function isPhone($string)
    {
        $boolean = false;

        if (count($string) > 0) {
            $string = trim($string, '+');
        }

        if (!empty($string) && ctype_digit($string) && is_numeric($string)) {
            $boolean = true;
        }

        return $boolean;
    }

    /**
     * is string an email ?
     *
     * @param $string
     *
     * @return bool
     */
    public static function isEmail($string)
    {
        $boolean = false;

        if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
            $boolean = true;
        }

        return $boolean;
    }

    /**
     * is string a Norwegian serial id ?
     *
     * @param $string
     *
     * @return bool
     */
    public static function isNorwegianSerialId($string)
    {
        $pno = $string;

        // Check length
        if (strlen($pno) != 11) return false;

        // Split
        $day = substr($pno, 0, 2);
        $month = substr($pno, 2, 2);
        $year = substr($pno, 4, 2);
        $ind = substr($pno, 6, 3);
        $c1 = substr($pno, 9, 1);
        $c2 = substr($pno, 10, 1);
        $yearNo = intval($year);

        if ($ind > 0 && $ind < 500) {
            $yearNo += 1900;
        } else if ($ind > 499 && $ind < 750 && $year > 55 && $year < 100) {
            $yearNo += 1800;
        } else if ($ind > 499 && $ind < 999 && $year >= 00 && $year < 40) {
            $yearNo += 2000;
        } else if ($ind > 899 && $ind < 999 && $year > 39 && $year < 100) {
            $yearNo += 1900;
        } else {
            return false;
        }

        $d1 = intval(substr($day, 0, 1));
        $d2 = intval(substr($day, 1, 1));
        $m1 = intval(substr($month, 0, 1));
        $m2 = intval(substr($month, 1, 1));
        $a1 = intval(substr($year, 0, 1));
        $a2 = intval(substr($year, 1, 1));
        $i1 = intval(substr($ind, 0, 1));
        $i2 = intval(substr($ind, 1, 1));
        $i3 = intval(substr($ind, 2, 1));

        // Calculate control check c1
        $c1calc = 11 - (((3 * $d1) + (7 * $d2) + (6 * $m1) + $m2 + (8 * $a1) + (9 * $a2) + (4 * $i1) + (5 * $i2) + (2 * $i3)) % 11);
        if ($c1calc == 11) $c1calc = 0;
        if ($c1calc == 10) return false;
        if ($c1 != $c1calc) return false;

        // Calculate control check c2
        $c2calc = 11 - (((5 * $d1) + (4 * $d2) + (3 * $m1) + (2 * $m2) + (7 * $a1) + (6 * $a2) + (5 * $i1) + (4 * $i2) + (3 * $i3) + (2 * $c1calc)) % 11);
        if ($c2calc == 11) $c2calc = 0;
        if ($c2calc == 10) return false;
        if ($c2 != $c2calc) return false;

        // Ønske fra Kenneth
        $age = function ($y, $m, $d) {
            $ty = date('Y');
            $tm = date('n');
            $td = date('j');

            $age = ($ty + 1900) - $y;
            if ($tm < ($m - 1)) $age--;
            if ((($m - 1) == $tm) && ($td < $d)) $age--;
            if ($age > 1900) $age -= 1900;

            return $age;
        };
        if ($age <= 24) return false;

        return true;
    }
}