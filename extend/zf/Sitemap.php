<?php
namespace zf;
/**
 * @Author: Eric-枫
 * @Date:   2019-08-27 09:42:59
 * @Last Modified by:   Eric-枫
 * @Last Modified time: 2019-08-27 09:43:33
 */
use think\Db;

class Sitemap
{

    static public function index(){
        makeXML();
    }
    

}
// 生成xml
if (!function_exists('makeXML')) {
  function makeXML(){
     $content='<?xml version="1.0" encoding="UTF-8"?>
     <urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
     ';
      $list =Db::name('post')->where(['status'=>1])->limit(50)->order('ctime desc')->select();
      foreach($list as $k=>$vo){
        $data_array[$k]['loc'] = 'http://'.$_SERVER['HTTP_HOST'].'/index/cate/detail/id/'.$vo['id'].'.html';
        $data_array[$k]['priority'] = '0.8';
        $data_array[$k]['lastmod'] = date('Y-m-d H:i:s',$vo['ctime']);
        $data_array[$k]['changefreq'] = 'changefreq';
      }
      if(isset($data_array)){
        foreach($data_array as $data){
          $content.=create_item($data);
        }
        $content.='</urlset>';
        $fp=fopen('sitemap.xml','w+');
        fwrite($fp,$content);
        fclose($fp);
      }
     
  }
}
if (!function_exists('create_item')) {
  function create_item($data){
    $item="<url>\n";
    $item.="<loc>".$data['loc']."</loc>\n";
    $item.="<priority>".$data['priority']."</priority>\n";
    $item.="<lastmod>".$data['lastmod']."</lastmod>\n";
    $item.="<changefreq>".$data['changefreq']."</changefreq>\n";
    $item.="</url>\n";
    return $item;
  }
}