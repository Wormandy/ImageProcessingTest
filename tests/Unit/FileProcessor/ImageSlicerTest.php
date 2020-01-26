<?php

namespace Tests\Unit\FileProcessor;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\TestCase;
use App\FileProcessor\ImageSlicer;
use Intervention\Image\Facades\Image;

class ImageSlicerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $app = require __DIR__.'/../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
    }

    /** @test */
    public function sliceImage()
    {
        $slicer = new ImageSlicer(base_path('tests/assets/testImage1.png'));
        $images = $slicer->slice();
        $this->assertIsArray($images);
        $this->assertEquals(48, count($images));
    }

    /** @test */
    public function itgeneratesCorrectFileNames()
    {
        $slicer = new ImageSlicer(base_path('tests/assets/testImage1.png'));
        $checkName = base_path('tests/assets/testImage1/3_1_5_6.png');
        $this->assertEquals($checkName, $slicer->generateFileName(5,6));
    }
}
