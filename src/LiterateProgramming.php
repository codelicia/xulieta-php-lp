<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP;

use Codelicia\Xulieta\Validator\Validator;
use Codelicia\Xulieta\ValueObject\SampleCode;
use Codelicia\Xulieta\ValueObject\Violation;
use LogicException;
use PhpParser\Parser as PhpParser;
use PhpParser\ParserFactory;
use Throwable;

final class LiterateProgramming implements Validator
{
    private PhpParser $phpParser;

    public function __construct(?PhpParser $phpParser = null)
    {
        $this->phpParser = $phpParser ?? (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    public function supports(SampleCode $sampleCode): bool
    {
        return $sampleCode->language() === 'php';
    }

    public function hasViolation(SampleCode $sampleCode): bool
    {
        try {
            $this->phpParser->parse($sampleCode->code());
        } catch (Throwable $e) {
            return true;
        }

        return false;
    }

    public function getViolation(SampleCode $sampleCode): Violation
    {
        try {
            $this->phpParser->parse($sampleCode->code());
        } catch (Throwable $e) {
            preg_match('{on line (\d+)}', $e->getMessage(), $line);

            $validationErrorInLine = $line[1] ?? 0;

            return new Violation($sampleCode, $e->getMessage(), (int) $validationErrorInLine);
        }

        throw new LogicException();
    }
}
