<?php
namespace Wmc1125\TpFast;

class Category {

    //原始的分类数据
    private $rawList = array();
    //格式化后的分类
    private $formatList = array();
    //格式化的字符
    private $icon = array('┃', '┣┉┉┉', '┗┉┉');
    //字段映射，分类id，上级分类pid,分类名称title,格式化后分类名称fulltitle
    private $field = array();

    /*
      功能：构造函数；
      属性：public;
      参数： $field，字段映射，分类id，上级分类pid,分类名称title,格式化后分类名称fulltitle
      依次传递,例如在分类数据表中，分类id，字段名为cid,上级分类pid,字段名称name,希望格式化分类后输出cname,
      则，传递参数为,$field('cid','pid','name','cname');若为空，则采用默认值。
      返回：无
      作者：单骑闯天下 QQ:404352772;
      创建时间：2010-6-16;
      最后修改时间：
     */

    public function __construct($field = array()) {
        $this->field['id'] = isset($field['0']) ? $field['0'] : 'id';
        $this->field['pid'] = isset($field['1']) ? $field['1'] : 'pid';
        $this->field['name'] = isset($field['2']) ? $field['2'] : 'title';
        $this->field['fulltitle'] = isset($field['3']) ? $field['3'] : 'fulltitle';
    }

    /*
      功能：返回给定上级分类$pid的所有同一级子分类；
      属性：public;
      参数：上级分类$pid；
      返回：子分类，二维数组；
      作者：单骑闯天下 QQ:404352772;
      创建时间：2010-6-16;
      最后修改时间：
      备注:
     */

    public function getChild($pid, $data = array()) {
        $childs = array();
        if (empty($data)) {
            $data = $this->rawList;
        }
        foreach ($data as $Category) {
            if ($Category[$this->field['pid']] == $pid)
                $childs[] = $Category;
        }
        return $childs;
    }

    /*
      功能：得到递归格式化分类；
      属性：public;
      参数：$data，二维数组，起始分类id,默认$id=0；
      返回：递归格式化分类数组；
      作者：单骑闯天下 QQ:404352772;
      创建时间：2010-6-16;
      最后修改时间：2010-12-19
      备注:
     */

    public function getTree($data, $id = 0) {
        //数据为空，则返回
        if (empty($data))
            return false;

        $this->rawList = array();
        $this->formatList = array();
        $this->rawList = $data;
        $this->_searchList($id);
        return $this->formatList;
    }

    //获取当前分类的路径
    public function getPath($data, $id) {
        $this->rawList = $data;
        while (1) {
            $id = $this->_getPid($id);
            if ($id == 0) {
                break;
            }
        }
        return array_reverse($this->formatList);
    }

    /*
      功能：无限分类核心部分，递归格式化分类前的字符；
      属性：private;
      参数：分类id,前导空格；
      返回：无；
      作者：单骑闯天下 QQ:404352772;
      创建时间：2010-6-16;
      最后修改时间：
      备注:
     */

    private function _searchList($id = 0, $space = "") {
        //下级分类的数组
        $childs = $this->getChild($id);
        //如果没下级分类，结束递归
        if (!($n = count($childs)))
            return;
        $cnt = 1;
        //循环所有的下级分类
        for ($i = 0; $i < $n; $i++) {
            $pre = "";
            $pad = "";
            if ($n == $cnt) {
                $pre = $this->icon[2];
            } else {
                $pre = $this->icon[1];
                $pad = $space ? $this->icon[0] : "";
            }
            $childs[$i][$this->field['fulltitle']] = ($space ? $space . $pre : "") . $childs[$i][$this->field['name']];
            $this->formatList[] = $childs[$i];
            //递归下一级分类
            $this->_searchList($childs[$i][$this->field['id']], $space . $pad . "  ");
            $cnt++;
        }
    }

    //通过当前id获取pid
    private function _getPid($id) {
        foreach ($this->rawList as $key => $value) {

            if ($this->rawList[$key][$this->field['id']] == $id) {
                $this->formatList[] = $this->rawList[$key];
                return $this->rawList[$key][$this->field['pid']];
            }
        }
        return 0;
    }

}

?>