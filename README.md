# BB code parser for php 7.0+

Builds:

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/054684fa-c2d1-4cc3-8905-d4a797961c22/big.png)](https://insight.sensiolabs.com/projects/054684fa-c2d1-4cc3-8905-d4a797961c22)

[![Build Status](https://travis-ci.org/angelk/bbCode.svg?branch=jenkins-integrati)](https://travis-ci.org/angelk/bbCode)

There are two parts - tokenizer and parser.

Tokenization - convert string to tokens.

BbCodeParser - convert bbCodeTokens to html (+ some validations)

# The Easy Way
```php
$tokenizer = new \Potaka\BbCode\Tokenizer\Tokenizer();

$bbText = '[b]bold[/b]text[u]under[i]line[/i][/u]';

$tokenized = $tokenizer->tokenize($text);
$factory = new  \Potaka\BbCode\Factory();
$bbcode = $factory->getFullBbCode();
$html = $bbcode->format($tokenized);
```

The value if `html` is
```html
<b>bold</b>text<u>under<i>line</i></u>
```

# Installation
```
composer require potaka/bbcode
```

# Internal explanation

## Tokenization
For example
```
$bbText = '[b]bold[/b]text[u]under[i]line[/i][/u]';
```

Will be tokenized to
```yml
Tag:
  type: null,
  tags:
    tag1:
      type: b
      tags:
        tag1:
          type: null
          text: bold
    tag2:
      type: null
      text: text
    tag3:
      type: u
      tags:
        tag1:
          type: null,
          text: under
        tag2:
          type: i
          tags:
            tag1:
              type: null,
              text: line
```

## Tokenized to html
You need to have valid `bb code tags`. Build in tags are available in https://github.com/angelk/bbCode/tree/master/src/Potaka/BbCode/Tag

Building the parser:
```php
use Potaka\BbCode;
use Potaka\BbCode\Tokenizer;

use Potaka\BbCode\Tag\Bold;
use Potaka\BbCode\Tag\Underline;
use Potaka\BbCode\Tag\Italic;

use Potaka\BbCode\Tag\Link;

$bbcode = new BbCode();
```

Lets add the `b` code
```
$bold = new Bold();
$bbcode->addTag($bold);
```

Lets format the token from above

```
$tokenizer = new Tokenizer();
$tokenized = $tokenizer->tokenize($bbText);

$bbcode->format($tokenized);
```

will return
```
<b>bold</b>text[u]under[i]line[/i][/u]
```

`u` and `i` are not formated cuz tags are not added.

Lets add em.

```
$underline = new Underline();
$bbcode->addTag($underline);

$italic = new Italic();
$bbcode->addTag($italic);
```

Test again
```
$bbcode->format($tokenized);
```
Result:
```html
<b>bold</b>text<u>under[i]line[/i]</u>
```

Why `i` is not converted? Cuz `u` doesn't allow child tag of type `i`. Lets fix this
```
$bbcode->addAllowedChildTag($underline, $italic);
```

Everything should work now!

Whats the purpose of this allowing? Imagine you have link `[url]http://google.bg[/url]`.
What if someone try to put link in link `[url=http://google.bg]google.[url=http://gmail.com]bg[/url][/url]`?
This will generate
```html
<a href="http://google.bg">
  google.<a href="http://gmail.com">bg</a>
</a>
```
This html is invalid. It could even provide [xss](https://en.wikipedia.org/wiki/Cross-site_scripting). This is why you should not allow `url` inside `url`.
