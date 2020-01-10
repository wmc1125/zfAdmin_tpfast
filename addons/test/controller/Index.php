<?php
namespace addons\test\controller;

class Index
{
    // http://tpfast:8888/addons/test.index/index.html
    public function index(){
        return view();
    }
    public function link()
    {
        echo 'hello link';
//        return view();
    }


}