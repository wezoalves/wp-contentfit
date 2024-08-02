<?php

namespace Review\Affiliate;

use Review\Model\ProgramPlatform;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

final class Programs
{
    public function getAll() : array
    {
        $programs = [];

        $directory = new \RecursiveDirectoryIterator(__DIR__ . '/src/Affiliate');
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($regex as $file) {
            $fileName = basename($file[0], '.php');
            if ($fileName === 'Programs') {
                continue;
            }

            $className = 'Review\\Affiliate\\' . $fileName;

            if (class_exists($className)) {
                $program = new $className();

                $programs[] = (new ProgramPlatform())
                    ->setName($fileName)
                    ->setId(strtoupper($fileName));

            }
        }

        return $programs;
    }
}
