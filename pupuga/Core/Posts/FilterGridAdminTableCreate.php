<?php

namespace Pupuga\Core\Posts;

abstract class FilterGridAdminTableCreate
{
    protected $clauses = array();
    protected $clausesCustom = array();
    protected $clausesReplace = array();

    public function __construct()
    {
    }

    public function action()
    {
        if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/edit.php') !== false) {
            add_filter('posts_clauses', array($this, 'actionHook'), 10, 2);
        }
    }

    public function actionHook($clauses, $query)
    {
        $this->clauses = $clauses;
        $clauses = $this->createSql();

        return $clauses;
    }

    protected function setClauseCustom($function, $sql, $replace)
    {
        $clause = substr(strtolower($function), 3);
        $this->clausesCustom[$clause] = $sql;
        if ($replace) {
            $this->clausesReplace[$clause] = $replace;
        }

        return $clause;
    }

    public function setWhere($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setGroupby($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setJoin($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setOrderby($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setDistinct($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setFields($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    public function setLimits($sql, $replace = false)
    {
        $this->setClauseCustom(__FUNCTION__, $sql, $replace);

        return $this;
    }

    protected function createSql()
    {
        $clauses = array();
        foreach ($this->clauses as $key => $clause) {
            $clauseCustom = trim($this->clausesCustom[$key] ?: '');
            $clauses[$key] = trim((isset($this->clausesReplace[$key]) && $this->clausesReplace[$key]) ? $clauseCustom : $clause . ' ' . $clauseCustom);
        }

        return $clauses;
    }

}