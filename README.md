# BB code parser for php 7.0+

Builds:
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/054684fa-c2d1-4cc3-8905-d4a797961c22/big.png)](https://insight.sensiolabs.com/projects/054684fa-c2d1-4cc3-8905-d4a797961c22)

[![Build Status](https://travis-ci.org/angelk/bbCode.svg?branch=jenkins-integrati)](https://travis-ci.org/angelk/bbCode)

There are two parts - tokenizer and parser.

Tokenizer do the tokenization :)
For example
```
[b]bold[/b]text[u]under[i]line[/i][/u]
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

