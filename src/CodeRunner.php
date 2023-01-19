<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP;

use function file_put_contents;
use function ini_get;
use function ob_get_clean;
use function ob_start;
use function str_replace;
use function sys_get_temp_dir;
use function trim;
use function uniqid;
use function unlink;

final class CodeRunner
{
    /**
     * Workaround to make sure we can execute code even without eval function available.
     */
    private bool $canEvaluate;

    public function __construct()
    {
        $this->canEvaluate = ! ini_get('suhosin.executor.disable_eval');
    }

    public function __invoke(string $code): string
    {
        if (! $this->canEvaluate) {
            $fileName = sys_get_temp_dir() . '/' . uniqid('', true) . '.php';
            file_put_contents($fileName, $code);

            ob_start();
            require $fileName;
            unlink($fileName);

            return ob_get_clean();
        }

        ob_start();
        eval(str_replace('<?php', '', trim($code)));

        return ob_get_clean();
    }
}
