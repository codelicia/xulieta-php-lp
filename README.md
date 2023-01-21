📚 Xulieta - Literate programming
=================================

> **Warning**
> This library is highly experimental.

#### 🤓 Literate programming?

[Literate programming][1] is a programming paradigm introduced by Donald Knuth in
which a computer program is given an explanation of its logic in a natural language,
such as English, interspersed with snippets of macros and traditional source code,
from which compilable source code can be generated. The approach is used in scientific
computing and in data science routinely for reproducible research and open access
purposes. Literate programming tools are used by millions of programmers today.

---

> **Note**
> This library will lint and run php code, be careful with side-effects.

### Installation

 ```shell script
 composer require codelicia/xulieta-lp --dev
 ```

### Checking for errors

In order to lint the basics of documentation structure, one just needs to
provide a path for a directory or file to be linted.

 ```shell script
 ./vendor/bin/xulieta check:erromeu <directory>
 ```

### Integration with GitHub Actions

We provide out  of the box an  `output` format that you can  use to have
automatic  feedback from  GitHub  CI.  That is  done  by specifying  the
`checkstyle` output and passing it to some external binary that does the
commenting.

We recommend the usage of [cs2pr][2].

 ```shell script
 ./vendor/bin/xulieta check:erromeu <directory> --output=checkstyle | cs2pr
 ```

### Advanced Configuration

In order to enable it, you should configure the `.xulieta.xml` with the following
`parser` and `validator`:

 ```xml
<?xml version="1.0" encoding="UTF-8" ?>
<xulieta xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/codelicia/xulieta/xulieta.xsd">

    <parser>Codelicia\XulietaPhpLP\Parser\MarkdownParser</parser>
    <validator>Codelicia\XulietaPhpLP\LiterateProgramming</validator>

</xulieta>
 ```

### Internals

<details>
  <summary>Click to see the internal diagram</summary>

```mermaid
classDiagram
direction BT
class CodeRunner {
   __invoke(code)
}
class EvalStrategy {
   __invoke(code)
}
class LiterateProgramming {
   getViolation(sampleCode)
   supports(sampleCode)
   hasViolation(sampleCode)
}
class MarkdownParser {
   supportedExtensions()
   supports(file)
   getAllSampleCodes(file)
}
class Strategy {
   __invoke(code)
}
class TemporaryFileStrategy {
   __invoke(code)
}
class Validator {
   getViolation(sampleCode)
   supports(sampleCode)
   hasViolation(sampleCode)
}

EvalStrategy  ..>  Strategy
LiterateProgramming  ..>  Validator
TemporaryFileStrategy  ..>  Strategy
```
</details>

## Author 🎩✨

- malukenho (@malukenho)
- Eher (@EHER)

---
[1]:https://en.wikipedia.org/wiki/Literate_programming
[2]:https://github.com/staabm/annotate-pull-request-from-checkstyle
