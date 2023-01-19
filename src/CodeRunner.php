<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP;

use Codelicia\XulietaPhpLP\CodeRunner\EvalStrategy;
use Codelicia\XulietaPhpLP\CodeRunner\Strategy;
use Codelicia\XulietaPhpLP\CodeRunner\TemporaryFileStrategy;

use function ini_get;

final class CodeRunner
{
    private Strategy $canEvaluate;

    public function __construct()
    {
        $this->canEvaluate = ini_get('suhosin.executor.disable_eval')
            ? new TemporaryFileStrategy()
            : new EvalStrategy();
    }

    public function __invoke(string $code): string
    {
        return $this->canEvaluate->__invoke($code);
    }
}
