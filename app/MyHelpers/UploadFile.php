<?php


namespace App\MyHelpers;


use Intervention\Image\Facades\Image;

class UploadFile
{
    public static function upload($file, $path,$water = null): ?string
    {
        if (!$file) {
            return null;
        }
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $data_name = md5($name.microtime());
        $data = $data_name.'.'.$extension;

        $img = Image::make($file->getRealPath());

        /* insert watermark at bottom-right corner with 10px offset */
        if($water) {
            $watermark = Image::make('storage/watermark.png');
            $img->insert($watermark, 'bottom-right', 10, 10);
        }
        $res = $img->save($path.$data);
        if (!$res) {
            return null;
        }
        return $data;
    }
}
