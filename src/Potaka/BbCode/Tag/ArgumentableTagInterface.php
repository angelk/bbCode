<?php

namespace Potaka\BbCode\Tag;

/**
 *
 * @author potaka
 */
interface ArgumentableTagInterface extends TagInterface
{
    public function __construct(string $argumentValue);
}
