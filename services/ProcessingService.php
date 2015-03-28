<?php
include('libs/FaceDetector.php');
include('libs/color_difference.php');

class ProcessingService {
    private $fileUrl;
    private $image;
    private $imageCanvas;
    
    private $palette = array(
      'white' => array(255, 255, 255),
      'black' => array(0, 0, 0),
      'navyblue' => array(0, 0, 139),
      'green' => array(0, 128, 0),
      'red' => array(255, 0, 0),
      'darkred' => array(139, 0, 0),
      'purple' => array(128, 0, 128),
      'orange' => array(255, 165, 0),
      'yellow' => array(255, 255, 0),
      'limegreen' => array(50, 205, 50),
      'teal' => array(0, 128, 128),
      'aqualight' => array(173, 216, 230),
      'royalblue' => array(0, 0, 255),
      'hotpink' => array(255, 105, 180),
      'darkgrey' => array(128, 128, 128),
      'lightgrey' => array(211, 211, 211)
    );
    
    private $pixels = array(
      'white' => 0,
      'black' => 0,
      'navyblue' => 0,
      'green' => 0,
      'red' => 0,
      'darkred' => 0,
      'purple' => 0,
      'orange' => 0,
      'yellow' => 0,
      'limegreen' => 0,
      'teal' => 0,
      'aqualight' => 0,
      'royalblue' => 0,
      'hotpink' => 0,
      'darkgrey' => 0,
      'lightgrey' => 0
    );
    
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
            
            // copy just the interesting part
            $this->imageCanvas = imagecreatetruecolor($newWidth , $newHeight);
            imagecopy($this->imageCanvas, $this->image, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight);
            
            // dither
            //imagetruecolortopalette($this->imageCanvas, false, 16);
            
            // find closest colors
            for ($i=0;$i<$newWidth;$i++) {
                for ($j=0;$j<$newHeight;$j++) {
                    $rgb = imagecolorat($this->imageCanvas, $i, $j);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    $color_rgb = array($r, $g, $b);
                    $color_delta_e = new color_difference($color_rgb);
                    $match_index = $color_delta_e->getClosestMatch($this->palette);
                    $color = $this->palette[$match_index];
                    
                    // save color
                    $this->pixels[$match_index]++;
                }
            }
            
            // process color data
            $total = $newWidth * $newHeight;
            
            foreach ($this->pixels as $color => $count) {
                $percent = $count*100/$total;
                if ($percent <= 5) {
                    $this->pixels[$color] = 0;
                } else {
                    $this->pixels[$color] = round($percent);
                }
            }
            
            print_r($this->pixels);
            //$this->displayImage();
        }
    }
    
    public function displayImage()
    {
        header('Content-Type: image/jpeg');
        imagejpeg($this->imageCanvas);
    }
}

?>
