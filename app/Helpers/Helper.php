<?php
if (!function_exists('upload'))
{
    function upload($file , $folder = '')
    {
//        if ($request->hasFile('image')) {
//            $file = upload('image');
//
//            if (isset($file['name'])) {
//                $data['image'] = $file['name'];
//            }
//        }
        $baseFilename = public_path() . '/uploads/' . $_FILES[$file]['name'];
        $info = new SplFileInfo($baseFilename);
        $text = strtolower($info->getExtension());
        $nameFile = trim(str_replace('.'.$text,'',strtolower($info->getFilename())));
        $filename = date('Y-m-d__').str_slug($nameFile) .time() . '.' . $text;

        $path = public_path().'/uploads/'.date('Y/m/d/');
        if ($folder)
        {
            $path = public_path().'/uploads/'.$folder.'/'.date('Y/m/d/');

        }
        if ( !\File::exists($path))
        {
            mkdir($path,0777,true);
        }

        move_uploaded_file($_FILES[$file]['tmp_name'], $path. $filename);

        return [
            'name' => $filename,
            'path_img' => 'uploads/'. date('Y/m/d/') .$filename,
        ];
    }
}

if (!function_exists('url_file')) {
    function url_file($image,$folder = '')
    {
        $explode = explode('__', $image);
        if (isset($explode[0])) {
            $time = str_replace('_', '/', $explode[0]);

            return '/uploads/'.$folder.'/' . date('Y/m/d', strtotime($time)) . '/' . $image;
        }
    }
}

