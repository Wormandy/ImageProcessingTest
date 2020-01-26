<?php


namespace App\FileProcessor;


class FakeFileNameGenerator implements FileNameGenerator
{

    public function generate($file): string
    {
        return $file->getClientOriginalName();
    }
}
