<?php

namespace Pupuga\Libs\Data;

class Date
{
    /**
     * convert number (1 - 12) to month name
     *
     * @param string $lang
     * @param string $number
     *
     * @return string|array
     */
    public static function getLangMonth($lang = 'no', $number = null)
    {
    	$result = '';
        switch ($lang) {
            case 'no' :
	            $months = array('Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember');
	            $monthsNumber = array('Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember');
                break;
	        case 'ru' :
		        $months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
		        $monthsNumber = array('Января', 'Февраля', 'Марта', 'Апрелья', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
		        break;
            case 'de' :
                $months = array('Januar', 'Februar', 'März', 'April', 'Mai ', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
                $monthsNumber = array('Januar', 'Februar', 'März', 'April', 'Mai ', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
                break;
        }
	    if (isset($months) && isset($monthsNumber)) {
		    if (is_null($number)) {
			    $result = (implode('', $months) === implode('', $monthsNumber)) ? $months : array($months, $monthsNumber);
		    } else {
			    $month = $months[$number - 1];
			    $monthNumber = $monthsNumber[$number - 1];
			    $result = ($month === $monthNumber) ? $month : array($month, $monthNumber);
		    }
	    }

        return $result;
    }

    /**
     * convert date (y-m-d) to custom format
     *
     * @param  string $date
     * @param  string $format (y-m-d)
     *
     * @return string $formatDate
     */
    public static function getLangDate($date, $format = 'd m y')
    {
        $dateParts = explode('-', $date);
        $dateParts[1] = self::getLangMonth($dateParts[1]);
        $formatDate = str_replace(array('y', 'm', 'd'), $dateParts, $format);
        return $formatDate;
    }

    /**
     * return year or period of years
     *
     * @param  string $period (year | years)
     * @param  string $before text is placing before date
     * @param  string $after text is placing after date
     *
     * @return string $copyright
     */
    public static function getCopyright($period = '', $before = 'Copyright &copy; ', $after = '')
    {
        $year = date('Y');

        $period = empty($period)
            ? $year
            : $period . ' - ' . $year;

        $copyright = $before . $period . $after;

        return $copyright;
    }

    public static function checkStringDate($date, $format = 'Y-m-d'): ?object
    {
        $dateObject = \DateTime::createFromFormat($format, $date);

        return ($dateObject && $dateObject->format($format) == $date) ? $dateObject : null;
    }
}