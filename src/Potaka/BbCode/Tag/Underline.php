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
class Underline extends SimpleTag
{
    public function getOpentag() : string
    {
        return '[u]';
    }

    public function getClosetag() : string
    {
        return '[/u]';
    }

    public function getOpenHtmlTag() : string
    {
        return '<u>';
    }

    public function getCloseHtmlTag() : string
    {
        return '</u>';
    }
}
