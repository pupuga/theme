<?php

namespace Pupuga\Libs\Files;

class Files
{
    public static function getFile(string $file, bool $echo = false, $params = null)
    {
        $html = '';
        if (is_file($file)) {
            if ($echo) {
                require $file;
            } else {
                ob_start();
                require($file);
                $html = ob_get_clean();
            }
        }

        return $html;
    }

    public static function getTemplate(string $template, bool $echo = false, $params = null): ?string
    {
        $file = new \SplFileInfo($template);
        $template .= (empty($file->getExtension())) ? '.php' : '';

        return self::getFile($template, $echo, $params);
    }

	public static function getFileWithWrapper(string $file, bool $echo = false, array $wrappers = array()): ?string
	{
		$data = self::getFile($file, false, array());
		$data = $wrappers[0] . $data . $wrappers[1];
		if ($echo) {
			echo $data;
			$data = null;
		}

        return $data;
	}

	public static function getCss(string $file, bool $echo = false)
	{
		$wrappers = array('<style type="text/css" media="screen">', '</style>');
		self::getFileWithWrapper($file, $echo, $wrappers);
	}

	public static function getJs(string $file, bool $echo = false)
	{
		$wrappers = array('<script>', '</script>');
		self::getFileWithWrapper($file, $echo, $wrappers);
	}

}