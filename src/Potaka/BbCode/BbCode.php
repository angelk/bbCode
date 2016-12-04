<?php

namespace Potaka\BbCode;

/**
 * Description of bbCode
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCode {

    protected $tags = array();

    public function addTag(Tag\TagInterface $tag) {
        $this->tags[] = $tag;
    }

    public function getTags() {
        return $this->tags;
    }

}
