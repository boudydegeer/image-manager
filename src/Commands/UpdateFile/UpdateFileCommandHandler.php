<?php

namespace Joselfonseca\ImageManager\Commands\UpdateFile;

use Joselfonseca\ImageManager\Interfaces\ImageRepositoryInterface;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class UpdateFileCommandHandler implements CommandHandler{
    
    use DispatchableTrait;
    
    private $imageRepository;
    
    public function __construct(ImageRepositoryInterface $repository){
        $this->imageRepository = $repository;
    }

    public function handle($command) {
        return $this->imageRepository->UpdateFile($command);
    }

}
