<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP\CodeRunner;

use function file_put_contents;
use function ob_get_clean;
use function ob_start;
use function sys_get_temp_dir;
use function uniqid;
use function unlink;

/**
 * Workaround to make sure we can execute code even without eval function available.
 */
final class TemporaryFileStrategy implements Strategy
{
    public function __invoke(string $code): string
    {
        $fileName = sys_get_temp_dir() . '/' . uniqid('', true) . '.php';
        file_put_contents($fileName, $code);

        ob_start();
        require $fileName;
        unlink($fileName);

        return ob_get_clean();
    }
}
