<?php

namespace Pupuga\Modules\CoolSpeed;


final class TagHeader
{
    var $data = '';

    public function sources($hrefs)
    {
        $pattern = "<link rel='dns-prefetch' href='{{href}}'>";
        $this->collect($hrefs, $pattern);

        return $this;
    }

    public function fonts($hrefs)
    {
        $pattern = "<link rel='preload' href='{{href}}' as='font' type='font/woff2' crossorigin='anonymous'>";
        $this->collect($hrefs, $pattern);

        return $this;
    }

    public function get()
    {
        return $this->data;
    }

    private function collect($hrefs, $pattern)
    {
        if (count($hrefs)) {
            foreach ($hrefs as $href) {
                $this->data .= str_replace('{{href}}', $href, $pattern);
            }
        }
    }

}