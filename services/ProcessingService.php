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
     }
     
     function __destruct() {
        imagedestroy($this->image);
        imagedestroy($this->imageCanvas);
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
            //echo "face detected\n";
            
            $imageW = imagesx($this->image);
            $imageH = imagesy($this->image);
            $faceX = $detector->face['x'];
            $faceY = $detector->face['y'];
            $faceW = $detector->face['w'];
            
            $newWidth = ceil($faceW * 2);
            $newHeight = $imageH-$faceY-$faceW;
            $cropStartX = $faceX - $faceW/2;
            $cropStartY = $faceY+$faceW;
            
            $this->imageCanvas = imagecreatetruecolor($newWidth , $newHeight);
            imagecopy($this->imageCanvas, $this->image, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight);
            
            
        }
    }
    
    public function displayImage()
    {
        // Output and free from memory
        header('Content-Type: image/jpeg');
        imagejpeg($this->imageCanvas);
    }
}

?>
