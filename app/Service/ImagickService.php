<?php


namespace App\Service;
use Thumbs;

require_once ('thumbs.php');


class ImagickService
{

   public static function setImageCompressionQuality($imagePath, $quality)
    {
        $imagick = new \Imagick(realpath($imagePath));
        $imagick->setImageCompressionQuality($quality);
        $imagick->writeImage($imagePath);
    }

    public static function CreateImageMain($imagePath,$imageName){
        $image = new Thumbs($imagePath.$imageName);
        $image->cut(800, 393);
        $image->save($imagePath.'photo_main.jpg');
        return 'photo_main.jpg';
    }

    public static function CreatePhotosPublic($path,$filename){
       //dd($filename);
        $image = new Thumbs($path.$filename);
        $image->cut(900, 789);
        $image->save($path.$filename);
        return $path.$filename;
    }


    public static function CreateImageMap($imagePath,$imageName){
        $image = new Thumbs($imagePath.$imageName);
        $image->cut(220, 220);
        $image->save($imagePath.'photo_map.jpg');

        $imagick = new \Imagick(realpath($imagePath.'photo_map.jpg'));
        if (!($iSize = getimagesize($imagePath.'photo_map.jpg'))) {
            return false;
        }
        switch ($iSize['mime']) {
            case 'image/jpeg':
                $imagick->setImageFormat("png32");
                break;
            default:
                return false;
                break;
        }
        $width = 220;
        $height = 220;
        $cornerRadius = 110;
// create mask image
        $mask = new \Imagick();
        $mask->newImage($width, $height, new \ImagickPixel('transparent'), 'png');
// create the rounded rectangle
        $shape = new \ImagickDraw();
        $shape->setFillColor(new \ImagickPixel('magenta'));
        $shape->roundRectangle(0, 0, $width, $height, $cornerRadius, $cornerRadius);
// draw the rectangle
        $mask->drawImage($shape);
// apply mask
        $imagick->setImageMatte(1);
        $imagick->compositeImage($mask, \Imagick::COMPOSITE_DSTIN, 0, 0);

        //self::circle($imagePath.'photo_map.jpg','photo_map.png');
        //$imagick->roundCorners(110, 110);
        //$color=new ImagickPixel();
        //$color->setColor("rgb(255,255,255)");
        //$imagick->borderImage($color,1,1);
        $imagick->writeImage($imagePath.'photo_map.png');
        return 'photo_map.png';
    }

}
