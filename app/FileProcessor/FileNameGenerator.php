<?php


namespace App\FileProcessor;


interface FileNameGenerator
{
    public function generate($file): string;

}
