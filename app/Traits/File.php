<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\Log;

trait File
{
    public function setImagesUrls($others_images_paths = [], $all = true)
    {
        if ($all) {
            $this->images->each(
                function ($image) {
                    $path = public_path('storage/' . $image->path);
                    if (file_exists($path)) {
                        $image->url = asset('storage/' . $image->path);
                        $image->size = filesize($path);
                    } else {
                        $image->url = '';
                        $image->size = 0;
                    }
                }
            );
        }
        foreach ($others_images_paths as $attribute => $path) {
            $disk_path = public_path('storage/' . $path);
            $image = new Image();
            $image->nom = null;
            $image->url = !empty($path) ? asset('storage/' . $path) : '';
            $image->size = !empty($path) && file_exists($disk_path) ? filesize($disk_path) : 0;
            $this->{$attribute} = $image;
            
        }
        return $this;
    }
    public function setDocumentsUrls()
    {
        if ($this->documents->isEmpty()) {
            return $this;
        }

        $this->documents->each(
            function ($fichier) {
                if (empty($fichier->path)) {
                    $fichier->url = '';
                    $fichier->size = 0;
                    return;
                }
                $path = public_path('storage/' . $fichier->path);
                try {
                    if (file_exists($path)) {
                        $fichier->size = filesize($path);
                        $fileExtension = pathinfo($fichier->path, PATHINFO_EXTENSION);
                        $fichier->url = getFileIcon($fileExtension);
                    } else {
                        $fichier->url = '';
                        $fichier->size = 0;
                    }
                } catch (\Exception $e) {
                    Log::error('Erreur lors du traitement du fichier : ' . $e->getMessage());
                    $fichier->url = '';
                    $fichier->size = 0;
                }
            }
        );

        return $this;
    }

    public function setFilesUrls($images = true, $documents = false)
    {
        // Gestion automatique des images
        if ($images && isset($this->images)) {
            $this->images->each(function ($image) {
                $this->setFileAttributes($image, $image->path);
            });
        }

        // Gestion automatique des documents
        if ($documents && isset($this->documents) && !$this->documents->isEmpty()) {
            $this->documents->each(function ($document) {
                $this->setFileAttributes($document, $document->path, true);
            });
        }

        foreach ($this->getAttributes() as $attribute => $value) {
            if (str_ends_with($attribute, '_path') && !empty($value)) {
                $image = new Image();
                $image->nom = null;
                $this->setFileAttributes($image, $value);
                $this->{str_replace('_path', '', $attribute)} = $image;
            }
        }

        return $this;
    }

    private function setFileAttributes($file, $path, $isDocument = false)
    {
        if (empty($path)) {
            $file->url = '';
            $file->size = 0;
            return;
        }

        $fullPath = public_path('storage/' . $path);

        try {
            if (file_exists($fullPath)) {
                $file->size = filesize($fullPath);
                $file->url = $isDocument ? getFileIcon(pathinfo($path, PATHINFO_EXTENSION)) : asset('storage/' . $path);
            } else {
                $file->url = '';
                $file->size = 0;
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du fichier : ' . $e->getMessage());
            $file->url = '';
            $file->size = 0;
        }
    }
}
