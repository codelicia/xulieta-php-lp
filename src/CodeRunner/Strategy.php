<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP\CodeRunner;

interface Strategy
{
    public function __invoke(string $code): string;
}
