<?php

namespace Utils;

class DebugLog{

    /**
     * Log function
     *
     * @param mixed $val - Value to log in the file
     * @param string $title - Title of a single record
     * @param string|null $fileName - Name of the log file. Optionally
     * @return void
     */
    public static function log($val, string $title, string $fileName = null) 
    {
        $statusLog = 1;
        if($statusLog > 0){
            $file = $fileName != null ? $fileName : 'test.txt';
            if(@file_exists($file)){
                $size = @filesize($file);
                if($size > 2500*1024){
                    @unlink($file);
                }
            }
            $date = date('Y-m-d H:i:s');
            $result = PHP_EOL . "[$title ($date)]" . PHP_EOL . print_r($val, true);
            file_put_contents($file, $result."\n##########################################\n", FILE_APPEND);
        }
    }
}
