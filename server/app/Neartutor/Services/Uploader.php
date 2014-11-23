<?php

namespace Neartutor\Services;

/**
 * The Neartutor uploader service
 *
 *
 * @author Adekunle Adedayo
 */
class Uploader {

    use \Neartutor\Traits\ErrorTrait;

    private $image_height = 300;
    private $image_width = 300;
    private $resize = true;
    private $filename;
    private $destination_path = '/uploads/';
    private $is_image = false;

    public function upload($file) {
        try {
            if (!isset($this->filename)) {
                $this->filename = $file->getClientOriginalName();
            }
            $file->move(public_path() . $this->destination_path, $this->filename);

            if ($this->is_image && $this->resize) { // if file is an image
                $image = new \Eventviva\ImageResize(public_path() . $this->destination_path . $this->filename);
                $image->crop($this->image_width, $this->image_height);
                $image->save(public_path() . $this->destination_path . $this->filename);
            }

            return true;
        } catch (Exception $ex) {
            /**
             * @todo Log picture upload error
             */
            return false;
        }
    }

    public function setFileName($filename) {
        $this->filename = $filename;
        return $this;
    }

    public function getFileName() {
        return $this->filename;
    }

    public function setImageHeight($image_heigth) {
        $this->image_height = $image_heigth;
        return $this;
    }

    public function setImageWidth($image_width) {
        $this->image_width = $image_width;
        return $this;
    }

    public function ignoreImageResize() {
        $this->resize = false;
        return $this;
    }

    public function setDestinationPath($path) {
        $this->destination_path = $path;
        return $this;
    }

    public function isImage() {
        $this->is_image = true;
        return $this;
    }

}
