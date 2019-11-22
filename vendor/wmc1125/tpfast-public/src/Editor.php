<?php
namespace Wmc1125\TpFast;
class Editor{
   
   
    public static function test($position='0'){
        switch ($position) {
            // 根目录
            case '0':
                $public_dir = '/vendor/wmc1125/mctoolsdk/';
                break;
            //其他目录
            default:
                if(intval($position)>0){
                    ;
                    $public_dir = str_repeat('../',intval($position)).'vendor/wmc1125/mctoolsdk/';
                }else{
                    return 'position 参数为整数';die;
                }
                break;
        }

        
        
        echo $public_dir;
        return '';
    }

    
   
    
}
    

    
    
    
?>