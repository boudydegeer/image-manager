<?php

namespace Joselfonseca\ImageManager\Models;

use Illuminate\Database\Eloquent\Model;
use Joselfonseca\ImageManager\Interfaces\ImageDbStorageInterface;
use Laracasts\Commander\Events\EventGenerator;
use Joselfonseca\ImageManager\Commands\UploadFile\Events\FileWasSavedToDb;

/**
 * Description of ImageManagerFiles
 *
 * @author desarrollo
 */
class ImageManagerFiles extends Model implements ImageDbStorageInterface {

    protected $table = 'image_manager_files';
    protected $fillable = ['name', 'originalName', 'type', 'path', 'size', 'alt'];

    use EventGenerator;

    public function saveFileToDb($file) {
        $f = $this->create($file);
        $f->raise(new FileWasSavedToDb($f));
        return $f;
    }

    public function getFileById($id) {
        return $this->findOrFail($id);
    }

    public function getFileInfo() {
        return [
            'name' => $this->name,
            'originalName' => $this->originalName,
            'type' => $this->type,
            'url' => route('media', $this->id),
            'thumb' => route('showthumb', $this->id),
            'size' => (int) $this->size,
            'date_uploaded' => $this->created_at->format('Y-m-d H:i:s'),
            'urlAll' => route('ImageManagerImages')
        ];
    }

    public function products()
    {
        return $this->belongsToMany( 'Wandapanda\Store\Models\Product', 'product_image', 'image_manager_files', 'product' );
    }

    public function pages()
    {
        return $this->belongsToMany( 'Wandapanda\Site\Models\Page', 'page_image', 'image_manager_files', 'page' );
    }

    public function deleteFile() {
        return $this->delete();
    }

}
