<?php


namespace App\FileProcessor;


class LocalFileNameGenerator implements FileNameGenerator
{

    public function generate($file): string
    {
        return Hash::make(time()) . '.' . $file->getExtension();
    }
}
