<?php

namespace Pupuga\Libs\Data;

class Html
{
    /**
     * clean empty p tags in html
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function cleanEmptyTagsHtml($html)
    {
        $html = preg_replace(array('/\<p\>([ \t\n\r\f\v]*)\<div/', '/\<\/div\>([ \t\n\r\f\v]*)\<\/p\>/'), array('<div', '</div>'), $html);
        $html = preg_replace(array('/\<\/p\>([ \t\n\r\f\v]*)\<\/p\>/'), array(''), $html);

        return $html;
    }

    /**
     * do shortcode
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function transformHtml($html)
    {
        $html = do_shortcode($html);

        return $html;
    }

    /**
     * wpautop & do shortcode & clean
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function perfectHtml($html)
    {
        $html = self::cleanEmptyTagsHtml(do_shortcode(wpautop($html)));

        return $html;
    }

    public static function replaceTemplates($content, $lang = 'ru')
    {
    	$month = date('m');
	    $monthName = Date::getLangMonth($lang, $month);

    	$searchReplace = array(
		    '{{day}}' => date('d'),
		    '{{month}}' => date('m'),
		    '{{monthName}}' => $monthName[0],
		    '{{monthNameEnd}}' => $monthName[1],
    		'{{year}}' => date('Y'),
	    );

    	return str_replace(array_keys($searchReplace), array_values($searchReplace), $content);
    }
}