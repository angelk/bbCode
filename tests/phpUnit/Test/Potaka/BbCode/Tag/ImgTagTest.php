<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;
use Potaka\BbCode\Tag\ImgTag;

/**
 * Description of ImgTagTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class ImgTagTest extends TestCase
{
    public function testFormat()
    {
        $cases = [
            'http://lorempixel.com/output/abstract-q-c-640-480-2.jpg', // test slash /
            'https://lorempixel.com/output/abstract-q-c-640-480-2.jpg', // ssl test
            'http://www.gravatar.com/avatar/18011762c920a331b9683454b0f2ec70.png?size=300', // test ? and =
        ];

        foreach ($cases as $testLink) {
            $tokenTag = new TokenTag('img');
            $tokenTag->setText($testLink);
            $img = new ImgTag();
            $html = $img->format($tokenTag);
            $this->assertSame('<img src="' . $testLink . '" />', $html);
        }
    }

    public function testInvalidFormat()
    {
        $cases = [
            'ftp://lorempixel.com/output/abstract-q-c-640-480-2.jpg', // ftp
        ];

        foreach ($cases as $testLink) {
            $tokenTag = new TokenTag('img');
            $tokenTag->setText($testLink);
            $img = new ImgTag();
            $html = $img->format($tokenTag);
            $this->assertSame('[img]' . $testLink . '[/img]', $html);
        }
    }
}
