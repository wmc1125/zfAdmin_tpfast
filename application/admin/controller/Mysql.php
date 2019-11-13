<?php
// +----------------------------------------------------------------------
// | 子枫后台管理系统(TpFast系列)[基于ThinkPHP5.1开发]
// +----------------------------------------------------------------------
// | Copyright (c)  http://v1.fast.zf.90ckm.com/
// | 子枫后台管理系统提供免费使用,可使用此框架进行二次开发
// +----------------------------------------------------------------------
// | Author: 子枫 <287851074@qq.com>
// +----------------------------------------------------------------------
// | github:https://github.com/wmc1125/zfAdmin_tpfast
// | 码云:  https://gitee.com/wmc1125/zfAdmin_tpfast
// | Mc技术论坛: http://bbs.wangmingchang.com/forum.php?mod=forumdisplay&fid=77
// +----------------------------------------------------------------------

namespace app\admin\controller;
use Wmc1125\Mctoolsdk\Dir;
use Wmc1125\Mctoolsdk\Database as dbOper;
use think\Db;
use Env;

class Mysql extends Admin
{
    /**
     * @Notes:初始化方法
     * @Interface initialize
     * @author: 子枫
     * @Time: 2019/11/13   10:57 下午
     */
    protected function initialize()
    {
        parent::initialize();
        // $this->backupPath = Env::get('root_path').'backup/'.trim(config('databases.backup_path'), '/').'/';
        $this->backupPath = Env::get('root_path').'backup/db/';
    }

    /**
     * @Notes:数据库管理
     * @Interface index
     * @param string $group
     * @return mixed|\think\response\Json
     * @author: 子枫
     * @Time: 2019/11/13   10:57 下午
     */
     public function index($group = 'export')
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if ($this->request->isAjax()) {

            $group = $this->request->param('group');
            $data = [];

            if ($group == 'export') {
                $tables = Db::query("SHOW TABLE STATUS");

                foreach ($tables as $k => &$v) {
                    $v['id'] = $v['Name'];
                }

                $data['data'] = $tables;
                $data['code'] = 0;

            }
            return json($data);
        }

        $tabData['current'] = url('?group='.$group);

        $this->assign('hisiTabType', 3);
        return $this->fetch($group);
    }

    /**
     * @Notes:备份列表
     * @Interface index2
     * @param string $group
     * @return mixed|\think\response\Json
     * @author: 子枫
     * @Time: 2019/11/13   10:57 下午
     */
    public function index2($group = 'import')
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if ($this->request->isAjax()) {

            $group = $this->request->param('group');
            $data = [];
            //列出备份文件列表
            if (!is_dir($this->backupPath)) {
                Dir::create($this->backupPath);
            }

            $flag = \FilesystemIterator::KEY_AS_FILENAME;
            $glob = new \FilesystemIterator($this->backupPath,  $flag);
            $dataList = [];
            foreach ($glob as $name => $file) {
                // $info['size'] = 0;
                if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {
                    $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
                    $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                    $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                    $part = $name[6];
                    $_time = "{$date} {$time}";
                    if(isset($dataList[$_time])) {
                        $info           = $dataList["{$date} {$time}"];
                        $info['part']   = max($info['part'], $part);
                        $info['size']   +=  $file->getSize();


                    } else {
                        $info['part']   = $part;
                        $info['size']   = $file->getSize();

                    }

                    $info['time']       = "{$date} {$time}";
                    $time               = strtotime("{$date} {$time}");
                    $extension          = strtoupper($file->getExtension());
                    $info['compress']   = ($extension === 'SQL') ? '无' : $extension;
                    $info['name']       = date('Ymd-His', $time);
                    $info['id']         = $time;

                    $dataList[$_time] = $info;
                }

            }

            $data['data'] = $dataList;
            $data['code'] = 0;

            return json($data);
        }

        $tabData['current'] = url('?group='.$group);

        $this->assign('hisiTabType', 3);
        return $this->fetch($group);
    }

    /**
     * @Notes:备份数据库
     * @Interface export
     * @param string $id
     * @param int $start
     * @author: 子枫
     * @Time: 2019/11/13   10:58 下午
     */
    public function export($id = '', $start = 0)
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if ($this->request->isPost()) {

            if (empty($id)) {
                return $this->error('请选择您要备份的数据表');
            }

            if (!is_array($id)) {
                $tables[] = $id;
            } else {
                $tables = $id;
            }

            //读取备份配置
            $config = array(
                'path'     => $this->backupPath,
                'part'     => config('databases.part_size'),
                'compress' => config('databases.compress'),
                'level'    => config('databases.compress_level'),
            );

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";

            if(is_file($lock)){
                return $this->error('检测到有一个备份任务正在执行，请稍后再试');
            } else {

                if (!is_dir($config['path'])) {
                    Dir::create($config['path'], 0755, true);
                }

                //创建锁文件
                file_put_contents($lock, $this->request->time());
            }

            //生成备份文件信息
            $file = [
                'name' => date('Ymd-His', $this->request->time()),
                'part' => 1,
            ];

            // 创建备份文件
            $database = new dbOper($file, $config);

            if($database->create() !== false) {

                // 备份指定表
                foreach ($tables as $table) {
                    $start = $database->backup($table, $start);
                    while (0 !== $start) {
                        if (false === $start) {
                            return $this->error('备份出错');
                        }
                        $start = $database->backup($table, $start[0]);
                    }
                }

                // 备份完成，删除锁定文件
                unlink($lock);
            }

            return $this->success('备份完成');
        }
        return $this->error('备份出错');
    }

    /**
     * @Notes:恢复数据库
     * @Interface import
     * @param string $id
     * @author: 子枫
     * @Time: 2019/11/13   10:58 下午
     */
    public function import($id = '')
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if (empty($id)) {
            return $this->error('请选择您要恢复的备份文件');
        }

        $name  = date('Ymd-His', $id) . '-*.sql*';
        $path  = $this->backupPath.$name;
        $files = glob($path);
        $list  = array();

        foreach($files as $name){
            $basename = basename($name);
            $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $name, $gz);
        }
        ksort($list);
        // 检测文件正确性
        $last = end($list);

        if(count($list) === $last[0]) {

            foreach ($list as $item) {

                $config = [
                    'path'     => $this->backupPath,
                    'compress' => $item[2]
                ];

                $database = new dbOper($item, $config);
                $start = $database->import(0);

                // 导入所有数据
                while (0 !== $start) {

                    if (false === $start) {
                        return $this->error('数据恢复出错');
                    }

                    $start = $database->import($start[0]);
                }
            }

            return $this->success('数据恢复完成');
        }

        return $this->error('备份文件可能已经损坏，请检查');
    }

    /**
     * @Notes:优化数据表
     * @Interface optimize
     * @param string $id
     * @author: 子枫
     * @Time: 2019/11/13   10:58 下午
     */
    public function optimize($id = '')
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if (empty($id)) {
            return $this->error('请选择您要优化的数据表');
        }

        if (!is_array($id)) {
            $table[] = $id;
        } else {
            $table = $id;
        }

        $tables = implode('`,`', $table);
        $res = Db::query("OPTIMIZE TABLE `{$tables}`");
        if ($res) {
            return $this->success('数据表优化完成');
        }

        return $this->error('数据表优化失败');
    }

    /**
     * @Notes:修复数据表
     * @Interface repair
     * @param string $id
     * @author: 子枫
     * @Time: 2019/11/13   10:58 下午
     */
    public function repair($id = '')
    {
        admin_role_check($this->z_role_list,$this->mca,1);
        if (empty($id)) {
            return $this->error('请选择您要修复的数据表');
        }

        if (!is_array($id)) {
            $table[] = $id;
        } else {
            $table = $id;
        }

        $tables = implode('`,`', $table);
        $res = Db::query("REPAIR TABLE `{$tables}`");

        if ($res) {
            return $this->success('数据表修复完成');
        }

        return $this->error('数据表修复失败');
    }

    /**
     * @Notes:删除备份
     * @Interface del
     * @param string $id
     * @author: 子枫
     * @Time: 2019/11/13   10:58 下午
     */
    public function del($id = '')
    {
        admin_role_check($this->z_role_list,$this->mca);
        if (empty($id)) {
            return $this->error('请选择您要删除的备份文件');
        }

        $name  = date('Ymd-His', $id) . '-*.sql*';
        $path = $this->backupPath.$name;
        array_map("unlink", glob($path));

        if(count(glob($path)) && glob($path)){
            return $this->error('备份文件删除失败，请检查权限');
        }
        
        return $this->success('备份文件删除成功');
    }






    
}
