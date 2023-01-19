<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP;

use Codelicia\XulietaPhpLP\CodeRunner\EvalStrategy;
use Codelicia\XulietaPhpLP\CodeRunner\Strategy;
use Codelicia\XulietaPhpLP\CodeRunner\TemporaryFileStrategy;

use function ini_get;

final class CodeRunner
{
    private Strategy $strategy;

    public function __construct()
    {
        $this->strategy = ini_get('suhosin.executor.disable_eval')
            ? new TemporaryFileStrategy()
            : new EvalStrategy();
    }

    public function __invoke(string $code): string
    {
        return $this->strategy->__invoke($code);
    }
}
