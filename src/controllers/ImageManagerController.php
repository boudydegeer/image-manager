<?php

namespace Joselfonseca\ImageManager\Controllers;

use Joselfonseca\ImageManager\Commands\UploadFile\UploadFileCommand;
use Joselfonseca\ImageManager\Commands\RenderFile\RenderFileCommand;
use Joselfonseca\ImageManager\Commands\DeleteFile\DeleteFileCommand;
use Laracasts\Commander\CommanderTrait;
/** exceptions * */
use Joselfonseca\ImageManager\Exceptions\ValidationExeption;
use Joselfonseca\ImageManager\Exceptions\AlocateFileException;
use Joselfonseca\ImageManager\Exceptions\ModelNotFoundException as JoseModelNotFoundException;

use Joselfonseca\ImageManager\Interfaces\ImageRepositoryInterface;

/**
 * Description of ImageManagerController
 *
 * @author jfonseca
 */
class ImageManagerController extends \Controller {

    use CommanderTrait;
    
    private $ImageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository) {
        $this->ImageRepository = $imageRepository;
    }

    public function index() {
        return \View::make('image-manager::image_manager');
    }
    
    public function getImages(){
        $files = $this->ImageRepository->getFiles();
        return \View::make('image-manager::images_collection')->with('files', $files);
    }

    public function thumb($id) {
        return $this->execute(RenderFileCommand::class, ['id' => $id, 'width' => 250, 'height' => 250]);
    }
    
    public function full($id, $width = null, $height = null){
        return $this->execute(RenderFileCommand::class, ['id' => $id, 'width' => $width, 'height' => $height]);
    }

    public function store() {
        try {
            $file = $this->execute(UploadFileCommand::class, ['file' => \Input::file('file')]);
        } catch (ValidationExeption $e) {
            $return = ['errorCode' => 'ValidationError', 'messages' => $e->getErrors()];
            return \Response::json($return, 400);
        } catch (AlocateFileException $e) {
            $return = ['errorCode' => 'AlocateError', 'messages' => ['Could not save the file to location.']];
            return \Response::json($return, 500);
        }
        $return = ['file' => $file->getFileInfo()];
        return \Response::json($return);
    }
    
    public function delete($id){
        try{
            $this->execute(DeleteFileCommand::class, ['id' => $id]);
        }catch(JoseModelNotFoundException $e){
            $return = ['errorCode' => 'ModelNotFound', 'message' => 'The file does not exsist.'];
            return \Response::json($return, 404);
        }
        return \Response::json(['status' => true]);
    }

}
