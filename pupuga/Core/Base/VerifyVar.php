<?php

namespace Pupuga\Core\Base;

trait VerifyVar
{

    /**
     * verify any var
     *
     * @param $nameVar string
     *
     * @return bool $result
     */
    protected function verifyConfigVar($nameVar)
    {
        if (isset($this->config[$nameVar])) {
            $var = $this->config[$nameVar];
            if (is_array($var) && count($var) > 0) {
                $result = true;
            } elseif ($var != '' && $var == true) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

}