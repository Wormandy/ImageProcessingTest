<?php


namespace App\FileProcessor;


class FakeImageConverter
{
    protected $filename;

    public function __construct()
    {
        $this->filename;
    }

    public function convert()
    {
        return $this->filename;
    }
}
