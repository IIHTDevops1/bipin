<?php
class excelController extends Controller {
    function __construct(){
        parent::__construct();
        error_reporting(E_ALL);
        header('Content-Type:text/html;charset=utf-8');
        include APP_LIB_PATH.'/Classes/PHPExcel.php';
        //var_dump($aa);
        $this->dir = $_SERVER['DOCUMENT_ROOT']."/view/templets_c/";
    }
    /**
     * 加载系统配置
     */
    public function index($Action='',$file='') {
       $DataDir = $this->dir;
        MkFolder($DataDir);
        @mkdir($DataDir);
        if (!empty($Action)) {
                       
            if ($Action == 'Del') {
                if (@unlink($DataDir . $file)) {
                    $this->assign("mess", '已删除');
                } else {
                    $this->error('删除失败！');
                }
            }
            if ($Action == 'download') {
                function DownloadFile($fileName) {
                    ob_end_clean();
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Length: ' . filesize($fileName));
                    header('Content-Disposition: attachment; filename=' . basename($fileName));
                    readfile($fileName);
                }
                DownloadFile($DataDir . $file);
                exit();
            }
        }
        $test = $this->MyScandir('/backup/');
        $lists=$this->dir_size($DataDir);
        $this->assign("url","/index.php/wxy/excel/index/Action");
        $this->assign("lists", $lists);
        $this->display('index.html');
    }
    public function del_all(){
        $ids=$_POST['ids'];
        if ($ids != "") {
            $ids = explode(',', $ids, -1);
            foreach ($ids as $m) {
                //echo $this->dir . $m;
                $re=@unlink($this->dir . $m);
            }
        }
        echo $re;

    }

    public function demotest(){
        //实例化
        $excel = new PHPExcel();
        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H','I','J','K');
        //表头数组
        $tableheader = array('编号','打卡状态','打卡时间','打卡机','学校','班级','姓名','性别','年龄'); 

        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }
        //表格数组
        $data=$this->M->get_all("SELECT * from `lx_child_send` order by `id` desc");
        foreach ($data as $key => &$v) {
            $v['school']=$this->M->get_one("SELECT `school_name` from `lx_school` where `id`='".$v['school_id']."'");
            $v['school']=$v['school']['school_name'];
            $v['class']=$this->M->get_one("SELECT `class_name` from `lx_class` where `id`='".$v['class_id']."'");
            $v['class_name']=$v['class']['class_name'];

            $v['child']=$this->M->get_one("SELECT `child_name`,`child_age`,`child_sex` from `lx_child_infor` where `id`='".$v['child_id']."'");
            switch ($v['child']['child_sex']) {
                case '1':
                    $v['child_sex']='男';
                    break;
                case '2':
                    $v['child_sex']='女';
                    break;
            }
            switch ($v['status']) {
                case '2':
                    $v['status']='进园';
                    break;
                case '3':
                    $v['status']='离园';
                    break;
            }
            $v['child_age']=$v['child']['child_age'];
            $v['child']=$v['child']['child_name'];
            
            $v['send_time']=date('Y-m-d H:i:s', $v['send_time']);
            
            unset($v['class']);
            unset($v['school_id']);
            unset($v['class_id']);
            unset($v['child_id']);
        }
        unset($v);

        
       // p($data);exit;
                //填充表格信息
        for ($i = 2;$i < count($data) + 1;$i++) {
            $j = 0;
            foreach ($data[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        //创建Excel输入对象
        $write = new PHPExcel_Writer_Excel5($excel);
        $filename=date('Y-m-d H:i:s')."打卡记录.xls";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');

    }
    private function MyScandir($FilePath = '/', $Order = 0) {
        $path=$FilePath;

        $FilePath = opendir($_SERVER['DOCUMENT_ROOT'] .$FilePath);
        while (false !== ($filename = readdir($FilePath))) {
            $FileAndFolderAyy[] = $filename;
            
        }
        //$Order == 0 ? sort($FileAndFolderAyy) : rsort($FileAndFolderAyy);
        return $FileAndFolderAyy;
    }

    public function dir_size($dir,$url=''){
     $dh = @opendir($dir);             //打开目录，返回一个目录流
     $return = array();
      $i = 0;
          while($file = @readdir($dh)){     //循环读取目录下的文件
             if($file!='.' and $file!='..'){
              $path = $dir.'/'.$file;     //设置目录，用于含有子目录的情况
              if(is_dir($path)){
              }elseif(is_file($path)){
                  //$filesize[] =  round((filesize($path)/1024),2);//获取文件大小
                 // $filename[] = $path;//获取文件名称                     
                  $filetime[] = date("Y-m-d H:i:s",filemtime($path));//获取文件最近修改日期
                 // $return[] =  $url.'/'.$file;
                  //$return[] =  $file;
                  $return[$i]['name']=$file;
                  $return[$i]['size']=$this->byteFormat(filesize($this->dir.$file));
                  $return[$i]['time']=date('Y-m-d H:i:s',filemtime($this->dir.$file));
                  $i++;
               }
            }
        }  
          @closedir($dh);             //关闭目录流
          // array_multisort($filesize,SORT_DESC,SORT_NUMERIC, $return);//按大小排序
          // array_multisort($filename,SORT_DESC,SORT_STRING, $files);//按名字排序
          @array_multisort($filetime,SORT_DESC,SORT_STRING, $return);//按时间排序
          return $return;               //返回文件
     }

    function byteFormat($bytes, $unit = "", $decimals = 2) {
        $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
        $value = 0;
        if ($bytes > 0) {
            if (!array_key_exists($unit, $units)) {
                $pow = floor(log($bytes)/log(1024));
                $unit = array_search($pow, $units);
            }
            $value = ($bytes/pow(1024,floor($units[$unit])));
        }
        if (!is_numeric($decimals) || $decimals < 0) {
            $decimals = 2;
        }
        return sprintf('%.' . $decimals . 'f '.$unit, $value);
    }

}

?>