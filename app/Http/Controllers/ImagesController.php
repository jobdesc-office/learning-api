<?php

namespace App\Http\Controllers;

use App\Models\Masters\Files;
use Exception;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

class ImagesController extends Controller
{

    private $imageNotFound = "app/public/default/default_image.jpeg";

    public function index($size, $directories, $filename)
    {
        try {
            $directories = "app/public/" . str_replace("-", "/", $directories);

            $info = getimagesize(storage_path($this->imageNotFound));
            list($iwidth, $iheight) = $info;

            $imagemanager = new ImageManager(array('driver' => 'gd'));
            $image = $imagemanager->make(storage_path($this->imageNotFound));

            $fullpath = storage_path($directories . DIRECTORY_SEPARATOR . $filename);

            if (file_exists($fullpath) && !is_dir($fullpath)) {

                $info = getimagesize($fullpath);
                list($iwidth, $iheight) = $info;

                $image = $imagemanager->make($fullpath);
            }

            switch ($size) {
                case Files::IMAGE_SIZE_DATATABLES:
                    if ($iwidth > 50) {
                        $width = 50;
                        $height = $iheight * 50 / $iwidth;
                    } else {
                        $width = $iwidth;
                        $height = $iheight;
                    }
                    break;
                case Files::IMAGE_SIZE_THUMBNAIL_POTRAIT:
                    $height = 50;
                    if ($iheight > 50)
                        $width = $iwidth * 50 / $iheight;
                    else
                        $width = $iwidth + (50 - $height);

                    break;

                case Files::IMAGE_SIZE_MEDIUM_THUMBNAIL:
                    $height = 100;
                    if ($iheight > 100)
                        $width = $iwidth * 100 / $iheight;
                    else
                        $width = $iwidth + (100 - $height);
                    break;

                case Files::IMAGE_SIZE_MEDIUM:
                    $width = 30 / 100 * $iwidth;
                    $height = 30 / 100 * $iheight;
                    break;

                case Files::IMAGE_SIZE_LARGE:
                    $width = 50 / 100 * $iwidth;
                    $height = 50 / 100 * $iheight;
                    break;

                default:
                    $width = $iwidth;
                    $height = $iheight;
                    break;
            }

            $image->orientate()
                ->resize($width, $height, function (Constraint $constraints) {
                    $constraints->aspectRatio();
                });

            return $image->response('png');
        } catch (Exception $e) {
            echo $e->getMessage();
            return response('Error Page');
        }
    }
}
