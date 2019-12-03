<?php
namespace Wmc1125\TpFast;

class Download
{
     /**
      * 将服务器的文件下载到本地
      * @Author   子枫
      * @Email    287851074@qq.com
      * @DateTime 2019-11-12T15:29:43+0800
      * @version  v1.0
      * @param    [type]                   $filename [文件路径]
      * @param    [type]                   $title    [文件名]
      */
    static public function output_file_download($filename, $title){
        $file  =  fopen($filename, "rb");
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Content-Disposition:  attachment;  filename= $title");
        while (!feof($file)) {
            echo fread($file, 8192);
            ob_flush();
            flush();
        }
        fclose($file);
    }
    
}
