<?php

namespace Pupuga\Core\Init;

class Media
{
    use InstanceTrait;

    private function __construct()
    {
        // *.svg
        add_filter('upload_mimes', array($this, 'addMimesFile'));
        add_filter('wp_prepare_attachment_for_js', array($this, 'svgThumbnailView'), 10, 3);
    }

    /**
     * add new mimes
     *
     **/
    public function addMimesFile($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }

    /**
     * svg thumbnail in admin part
     *
     * */
    public function svgThumbnailView($response, $attachment, $meta)
    {
        if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement')) {
            try {
                $path = get_attached_file($attachment->ID);
                if (@file_exists($path)) {
                    $svg = new \SimpleXMLElement(@file_get_contents($path));
                    $src = $response['url'];
                    $width = (int)$svg['width'];
                    $height = (int)$svg['height'];

                    //media gallery
                    $response['image'] = compact('src', 'width', 'height');
                    $response['thumb'] = compact('src', 'width', 'height');

                    //media single
                    $response['sizes']['full'] = array(
                        'height' => $height,
                        'width' => $width,
                        'url' => $src,
                        'orientation' => $height > $width ? 'portrait' : 'landscape',
                    );
                }
            } catch (\Exception $e) {
            }
        }

        return $response;
    }
}