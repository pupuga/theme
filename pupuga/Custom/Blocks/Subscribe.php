<?php

namespace Pupuga\Custom\Blocks;

use Carbon_Fields\Field;
use Pupuga\Core\Carbon\AbstractBlock;

class Test extends AbstractBlock {

    protected $title = 'Test block';

    protected function addFields(): array
    {
        return array(
            Field::make( 'text', $this->prefix . 'title', 'Title' )->set_classes('cf-field--half'),
        );
    }
}