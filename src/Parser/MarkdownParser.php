<?php

declare(strict_types=1);

namespace Codelicia\XulietaPhpLP\Parser;

use Codelicia\Xulieta\Parser\Parser;
use Codelicia\Xulieta\ValueObject\SampleCode;
use Symfony\Component\Finder\SplFileInfo;

use function array_pop;
use function array_shift;
use function explode;
use function implode;
use function in_array;
use function ltrim;
use function preg_match;
use function preg_split;

use const PREG_SPLIT_DELIM_CAPTURE;

final class MarkdownParser implements Parser
{
    private const PATTERN = '/\n?(`{3}[\w]*\n[\S\s]+?\n\`{3})\n/';

    public function supportedExtensions(): array
    {
        return ['markdown', 'md'];
    }

    public function supports(SplFileInfo $file): bool
    {
        return in_array($file->getExtension(), $this->supportedExtensions(), false);
    }

    /** @return SampleCode[] */
    public function getAllSampleCodes(SplFileInfo $file): array
    {
        // TODO: Use tangled code so we can execute everything at the end
        //       by getting a unique sample code with all the code we need
        $sampleCode    = '';
        $chunks        = preg_split(self::PATTERN, $file->getContents(), -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($chunks as $documentChunk) {
            $lines        = explode("\n", $documentChunk);

            preg_match('/^```/', $lines[0] ?? '', $matches);

            if ($matches === []) {
                continue;
            }

            $languageDeclaration = array_shift($lines);
            $language            = ltrim($languageDeclaration, '`');

            array_pop($lines);

            $sampleCode .= "\n" . implode("\n", $lines);
        }

        // @todo fix issue with the "language" variable
        return $sampleCode ? [new SampleCode($file->getPathname(), $language, 0, $sampleCode)] : [];
    }
}
