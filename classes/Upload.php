<?php
Class Upload
{
    public static function validUpload($image)
    {
        $new_name = '';
        if (!empty($image["name"]) && $image["error"] == 0) 
        {
            $ext = strtolower(end(explode('.', $image['name'])));
            $new_name = PATH_FILE."/".date("YmdHis") .".". $ext;
            $full_path = PATH_INDEX."/".$new_name;                
            move_uploaded_file($image['tmp_name'], $full_path); 
        }
        
        return $new_name;
    }
} 