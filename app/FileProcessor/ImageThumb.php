<?php


namespace App\FileProcessor;


class ImageThumb
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function thumbnail()
    {
        //Do some job to thumb images
    }
}
