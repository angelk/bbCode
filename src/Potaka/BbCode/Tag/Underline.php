<?php

namespace Potaka\BbCode\Tag;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Underline
 *
 * @author potaka
 */
class Underline extends SimpleTag {

    public function getOpentag() {
        return '[u]';
    }

    public function getClosetag() {
        return '[/u]';
    }

    public function getOpenHtmlTag() {
        return '<u>';
    }

    public function getCloseHtmlTag() {
        return '</u>';
    }

}
