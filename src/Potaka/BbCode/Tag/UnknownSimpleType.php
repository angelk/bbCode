<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * Description of UnknownSimpleType
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class UnknownSimpleType implements ArgumentableTagInterface
{
    private $argument;

    public function __construct(string $argumentvalue = null)
    {
        $this->argument = $argumentvalue;
    }

    public function format(TokenTag $tokenTag) : string
    {
        $formattedString = "[{$tokenTag->getType()}";

        if ($this->argument !== null) {
            $formattedString .= "={$this->argument}";
        }

        $formattedString .= "]{$tokenTag->getText()}[/{$tokenTag->getType()}]";
        return $formattedString;
    }

    public function getName(): string
    {
        return '';
    }
}
