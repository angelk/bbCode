<?php

namespace Potaka\BbCode;

/**
 * Description of bbCode
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCode {

    protected $parsers = array();

    public function addTag(bbCode\Tag\Tag $tag) {
        $this->parsers[] = $tag;
    }

    public function getParsers() {
        return $this->parsers;
    }

}
