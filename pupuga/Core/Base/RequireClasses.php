<?php

namespace Pupuga\Core\Base;

use Pupuga;
use Pupuga\Libs\Files;

class RequireClasses extends Pupuga\Classes
{
    public function __construct()
    {
        $this->loadClasses();
    }

    /**
     * require files
     */
    private function loadClasses()
    {
        if (count($this->requireFiles)) {
            foreach ($this->requireFiles as $dir => $classes) {
	            Files\Classes::launchClasses($classes, "Pupuga\\{$dir}");
            }
        }
    }
}