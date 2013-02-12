<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of bold
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Bold implements Tag {

    /**
     * 
     * @param string $string
     * @return string
     * @throws Potaka\bbCode\Tag\Exception
     */
    public function format($string) {
        $string = (string) $string;
        $formattedString = preg_replace('#\[b\](.*?)\[/b\]#', '<strong>$1</strong>', $string);
        if ($formattedString === null) {
            throw new Exception("{$string} regexp failed");
        }

        return $formattedString;
    }

}
