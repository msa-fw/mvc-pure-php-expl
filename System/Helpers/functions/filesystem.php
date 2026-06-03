<?php

namespace filesystem;

function scan_callback($directory, callable $callback, $sorting_order = SCANDIR_SORT_ASCENDING, $context = null)
{
    if(is_dir($directory)){
        foreach(scandir($directory, $sorting_order, $context) as $file){
            if(in_array($file, ['.', '..'])){ continue; }

            $newPath = "{$directory}/{$file}";
            if(is_dir($newPath)){
                scan_callback($newPath, $callback, $sorting_order, $context);

                call_user_func($callback, $directory, $file, true);
            }else{
                call_user_func($callback, $directory, $file, false);
            }
        }
    }
    call_user_func($callback, $directory, '', true);
}