<?php

namespace Joselfonseca\ImageManager\Commands\UpdateFile;

/**
 * Description of UploadFileCommand
 *
 * @author desarrollo
 */
class UpdateFileCommand {

    public $id;
    public $alt;

    public function __construct($id, $alt = '') 
    {
        $this->id = $id;
        $this->alt = $alt;
    }

}
