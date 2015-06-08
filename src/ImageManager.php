<?php

namespace Joselfonseca\ImageManager;

use Joselfonseca\ImageManager\Commands\UploadFile\UploadFileCommand;
use Laracasts\Commander\CommanderTrait;
use Joselfonseca\ImageManager\Interfaces\ImageRepositoryInterface;
use Joselfonseca\ImageManager\Commands\RenderFile\RenderFileCommand;

/**
 * Description of ImageManager
 *
 * @author jfonseca
 */
class ImageManager {
    
    use CommanderTrait;

    private $ImageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository) {
        $this->ImageRepository = $imageRepository;
    }
    
    public function doUpload() {
        return $this->execute(UploadFileCommand::class, ['file' => \Input::file('file')]);
    }
    
    public function resize($id, $width = null, $height = null, $canvas = true){
        return $this->execute(RenderFileCommand::class, ['id' => $id, 'width' => $width, 'height' => $height, 'canvas' => (bool) $canvas]);
    }
    
    public function imageInfo($id){
        return $this->ImageRepository->getFileModel($id);
    }

    public static function getField($params) {
        $text = ($params['text']) ? $params['text'] : 'Select File';
        $class = ($params['class']) ? $params['class'] : 'btn btn-default';
        $field_name = (isset($params['field_name'])) ? $params['field_name'] : 'image';
        $default = (isset($params['default'])) ? $params['default'] : \Input::old($params['field_name']);;
        if(!empty($default)){
            $image = '<img src="'.route('showthumb', $default).'" class="imageManagerImage" />';
        }else{
            $image = '<img src="" style="display:none" class="imageManagerImage" />';
        }
        return '<div class="ImageManager">'
                . $image .'<br /><br />'
                . '<button class="fileManager ' . $class . '" type="Button" data-url="' . route('ImageManager') . '">' . $text . '</button>'
                . \Form::hidden($field_name, $default, ['class' => 'inputFile'])
                . '</div>';
    }


    public static function getFieldForMultiple($params)
    {
        $text = ($params['text']) ? $params['text'] : 'Select File';
        $class = ($params['class']) ? $params['class'] : 'btn btn-default';

        $field_name = (isset($params['field_name'])) ? $params['field_name'] : 'images[]';
        $default = (isset($params['default'])) ? $params['default'] : \Input::old($params['field_name']);;
        $image  = '';
        if(!empty($default))
        {

            foreach($default as $photo)
            {
                $image .=
                  '<div class="col-lg-2">
                    <img src="' . route( 'showthumb', $photo ) . '" class="imageManagerImage" />'
                    . \Form::hidden( $field_name, $photo, [ 'class' => 'inputFile' ] ).
                  '</div>';
            }

        }
        else
        {
            $image = '<img src="" style="display:none" class="imageManagerImage" />';
        }
        return '<div class="form-group ImageManager">'
                . '<label class="col-lg-2 control-label">Images</label>'
                . '<div class="col-lg-10">'
                .  '<button class="fileManager pull-right ' . $class . '" type="Button" data-url="' . route( 'ImageManager' ) . '">' . $text . '</button>'
                . '</div>'
                . '<div class="col-lg-10 col-lg-offset-2 images">'
                . $image

                . '</div>'

                . '</div>';
    }
    
    

}
