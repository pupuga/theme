<?php

namespace Pupuga\Core\Db;

final class Update
{
    private $sql;
    private $table;
    private $set = '';
    private $condition;

    public function __construct($table, $set, $condition)
    {
        if (count($set)) {
            $this->table = $table;
            $this->set($set);
            $this->condition = $condition;
            $this->setSql();
            $this->execute();
        }
    }

    public function getSql(): string
    {
        return GetData::app()->getSql($this->sql);
    }

    private function set($set): void
    {
        foreach ($set as $key => $value) {
            $key = ($key[0] == '_') ? $key : '_' . $key;
            $this->set .= (empty($this->set) ? '' : ', ') . "{$key}='{$value}'";
        }
    }

    private function setSql(): void
    {
        $this->sql = "UPDATE {$this->table} SET {$this->set} WHERE {$this->condition}";
    }

    private function execute(): void
    {
        if (!empty($this->sql)) {
            GetData::app()->query($this->sql);
        }
    }
}