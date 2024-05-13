<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Services\ReportServices;

class UploadServices {
/**
   * @param $file
   * @param $element
   * @param $direction
   * @param string $prefix
   * @param null $fileDelete
   * @return string
   */
  static function saveFile($file, $element, $direction, $prefix = '', $fileDelete = null): null|string
  {
      try {
        $path = null;
        if($file->file($element)){
            $archivo = $file->file($element);
            $nombreArchivo = $prefix.time().'.'.$archivo->getClientOriginalExtension();
            $path = $direction.'/'.$nombreArchivo;
            $save = $archivo->storeAs($direction ,$nombreArchivo);
            if ($save) {
                if ($fileDelete) {
                    File::delete(public_path('app/'.$fileDelete));
                }
            }
        }
        return $path;
      } catch (\Throwable $th) {
        ReportServices::reportError($th, __CLASS__, __FUNCTION__);
        return null;
      }
  }
}