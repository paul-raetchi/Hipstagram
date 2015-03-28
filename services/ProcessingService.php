<?php
include "libs/FaceDetector.php";

class ProcessingService {
    private $fileUrl;
    private $image;
    private $imageCanvas;
    
    function __construct($fileUrl)
    {
        $this->fileUrl = $fileUrl;
        $this->image = $this->openImage($fileUrl);
 
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }
    
    private function openImage($fileUrl)
    {
        $extension = strtolower(strrchr($fileUrl, '.'));
     
        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($fileUrl);
                break;
            case '.gif':
                $img = @imagecreatefromgif($fileUrl);
                break;
            case '.png':
                $img = @imagecreatefrompng($fileUrl);
                break;
            default:
                $img = false;
                // $img = imagecreatefromgd2($fileUrl);
                break;
        }
        return $img;
    }

    public function process()
    {
        $detector = new svay\FaceDetector('libs/detection.dat');
        $faceDetected = $detector->faceDetect($this->fileUrl);
        if ($faceDetected) {
            echo "face detected";
            //$detector->toJpeg();
            echo $detector->face['x'];
        }
    }
}

?>
