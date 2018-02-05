<?php

namespace LM\PoToPhp;

/**
 * @todo Process file line by line in case the file is too big.
 * @todo Add unit tests.
 * @todo Separate the extraction logic from the file writing logic.
 */
class PoToPhpConverter
{
    function convert($poFilePath, $arrayFilePath)
    {
        $po = file_get_contents($poFilePath);
        $matches = [];
        $array = [];
        preg_match_all('/((?<=\vmsgid ").+(?="\vmsgstr ".+"\v))|((?<="\vmsgstr ").+(?="\v))/', $po, $matches, PREG_PATTERN_ORDER);
        $nMatches = count($matches[0]);
        for ($i = 0; $i < $nMatches; $i += 2) {
            $array[$matches[0][$i]] = $matches[0][$i + 1];
        }
        $arrayCode = var_export($array, true);
        file_put_contents($arrayFilePath, "<?php\n\nreturn {$arrayCode};\n");
    }
}
