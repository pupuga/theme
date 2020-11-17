<?php

namespace Pupuga\Modules\CoolSpeed;

use Pupuga\Libs\Files\Resource;

final class HtmlSources
{
    /**
     * @var \DOMDocument
    */
    protected $dom;
    protected $html;
    protected $nodes = array();

    public function __construct(&$html)
    {
        $this->html = &$html;
        $this->load();
    }


    public function __call($name, $arguments)
    {
        $this->nodes[$name] = Config::app()->get('parse')[$name]['file'];

        return $this;
    }

    public function getSources()
    {
        $this->parseSources();

        return $this->nodes;
    }

    private function load()
    {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        if (Config::app()->get('mode')['encoding']) {
            $this->html = mb_convert_encoding($this->html, 'HTML-ENTITIES', "UTF-8");
        }
        $this->dom->loadHTML($this->html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);
        $this->saveHtml();
    }

    private function saveHtml()
    {
        $search = array(
            '/<!--(.*)-->/Uis',// remove comments
            '/\>[^\S ]+/s',    // remove whitespaces after tags
            '/[^\S ]+\</s',    // remove whitespaces before tags
            '/(\s)+/s',        // remove multiple whitespace sequences
        );
        $replace = array('','>','<','\\1');
        $this->html = (Config::app()->get('mode')['dev']) ? $this->dom->saveHTML() : preg_replace($search, $replace, $this->dom->saveHTML());
        $this->html = html_entity_decode($this->html);
    }

    private function parseSources()
    {
        foreach($this->nodes as $type => $node) {
            foreach ($this->dom->getElementsByTagName($node['tag']) as $tag) {;
                $source = $tag->getAttribute($node['source']);
                if ($source && stripos($source, $_SERVER['SERVER_NAME']) !== false) {
                    $source = new Resource($source);
                    if ($source->isExt($node['ext']) || count($node['ext']) == 0 || !isset($node['ext'])) {
                        $this->nodes[$type]['html'][] = $this->dom->saveHTML($tag);
                        $this->nodes[$type]['url'][] = $source->getUrl();
                        $i = count($this->nodes[$type]['html']) - 1;
                        if ($node['path']) {
                            $file = $source->getPath();
                            if (is_file($file)) {
                                $this->nodes[$type]['files'][$i] = $file;
                                if (!Config::app()->get('mode')['dev'] || (Config::app()->get('mode')['dev'] && !Config::app()->get('mode')['exclude'])) {
                                    $className = __NAMESPACE__ . '\Process' . ucfirst($type);
                                    $content = (class_exists($className)) ? (new $className($source, $file))->getData() : false;
                                    if ($content !== false) {
                                        $this->html = str_replace($this->nodes[$type]['html'][$i], "<{$type}>{$content}</{$type}>", $this->html);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        unset($this->dom);
    }
}