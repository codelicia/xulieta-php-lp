<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP\CodeRunner;

use function ob_get_clean;
use function ob_start;
use function str_replace;
use function trim;

final class EvalStrategy implements Strategy
{
    public function __invoke(string $code): string
    {
        ob_start();

        eval(str_replace('<?php', '', trim($code)));

        return ob_get_clean();
    }
}
