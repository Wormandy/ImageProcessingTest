<?php


namespace App\FileProcessor;

use Intervention\Image\Facades\Image;

class ImageSlicer
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function slice()
    {
        $image = Image::make($this->filename);
        $stepX = 52;
        $stepY = 52;
        $width = $image->width();
        $height = $image->height();
        $pieces = [];
        for ($x = 0; $x < $width /$stepX; $x++) {
            for ($y = 0; $y < $height / $stepY; $y++) {
                $imagePiece = $image->crop($stepX, $stepY, $x*$stepX+1, $y*$stepY+1);
                $filename = $this->generateFileName($x, $y);
                $imagePiece->save($filename);
                $pieces[] = $filename;
                $image = Image::make($this->filename);
            }
        }
        return $pieces;
    }

    public function generateFileName($posX, $posY)
    {
        $path_pieces = pathinfo($this->filename);
        return $path_pieces['dirname'].'/'.$path_pieces['filename'].'/3_1_' . $posX . '_' . $posY . '.png';
    }
}
