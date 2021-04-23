<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Db\GetData;
use Pupuga\Core\Base;
use Pupuga\Libs\Data;

class SetCommon
{
    use InstanceTrait;

    private function __construct()
    {
        $this->setCommon();
	    $this->setConstants();
    }

    private function setCommon()
    {
        $common = $this->getOptions('%common_pupuga%');

        foreach ($common as $key => $value) {
            $end = '_xml_object';
            if (substr(($key), -11) === $end) {
                $value = Data\Xml::xmlToObjects($common[$key]);
                $key = rtrim($key, $end);
            }
            Base\Common::app()->common[$key] = $value;
        }
    }

	private function setConstants()
	{
        $config = Base\Common::app()->get( 'configuration_parameters' );
        $params = (isset($config)) ? (array) $config : array();
        $theme = (!empty($params) && isset($params['@attributes']['name'])) ? strtolower(str_replace(' ', '', $params['@attributes']['name'])) : '';
        define('THEME_NAME', $theme);
	}

    /**
     * gets pupuga options
     *
     * @param string $parameter
     *
     * @return array $results
     */
    private function getOptions($parameter)
    {
        $sql = "select * from table.options where option_name like '{$parameter}' ";
        $getResults = GetData::app()->getResults($sql);
        $results = array();
        if (is_array($getResults) && count($getResults)) {
            $parameter = trim($parameter, '%');
            foreach ($getResults as $result) {
                $key = trim($result->option_name, '_');
                $key = str_replace($parameter, '', $key);
                $key = trim($key, '_');
                $results[$key] = $result->option_value;
            }
        }

        return $results;
    }
}