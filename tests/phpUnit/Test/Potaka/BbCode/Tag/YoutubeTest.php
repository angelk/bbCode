<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;
use Potaka\BbCode\Tag\YoutubeTag;

/**
 * Description of YoutubeTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class YoutubeTest extends TestCase
{
    public function testFormat()
    {
        $cases = [
            [
                'link' =>  'https://www.youtube.com/watch?v=zur_B7kw9uM',
                'id' => 'zur_B7kw9uM',
            ],
            [
                'link' => 'https://www.youtube.com/watch?v=zur_B7kw9uM&feature=youtu.be&t=8259',
                'id' => 'zur_B7kw9uM',
            ],
        ];

        foreach ($cases as $testData) {
            $tokenTag = new TokenTag('youtube');
            $tokenTag->setText($testData['link']);
            $youtubeTag = new YoutubeTag();
            $html = $youtubeTag->format($tokenTag);
            $this->assertSame('<iframe src="https://www.youtube.com/embed/' . $testData['id'] . '" frameborder="0" allowfullscreen></iframe>', $html);
        }
    }

    public function testInvalidFormat()
    {
        $cases = [
            'ftp://lorempixel.com/output/abstract-q-c-640-480-2.jpg', // ftp
        ];

        foreach ($cases as $testData) {
            $tokenTag = new TokenTag('youtube');
            $tokenTag->setText($testData);
            $youtubeTag = new YoutubeTag();
            $html = $youtubeTag->format($tokenTag);
            $this->assertSame('[youtube]' . $testData . '[/youtube]', $html);
        }
    }

    public function testGetName()
    {
        $youtube = new YoutubeTag();
        $this->assertSame('youtube', $youtube->getName());
    }
}
