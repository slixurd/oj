<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index($page = 1){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        if($page < 1 || !is_numeric($page)){
            $this->error->show_error("没有内容",array("页数错误,导致没有内容！"),$data);
            return;            
        } 
        $data['page_title']='题目列表';
        $this->load->model("user_model");
        $this->load->model("back/problem_edit","problem_edit");
        //$type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        //$type = $type['type'];
        //if($type != "admin"){
        //  $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //  return;
        //}
        $total = $this->problem_edit->get_count();
        $data['problem_list'] = $this->problem_edit->get_problem_list(($page-1)*10,10);

        $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = site_url("admin/problem/index");
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 4; 

        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';     
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';           
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';    
        $this->pagination->initialize($config);
        $data['pagination_block'] = $this->pagination->create_links();

        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/problem_list",$data);
        $this->load->view("common/admin_footer",$data);
    }
    public function del($problemId = NULL){
        Global $data;
        if($problemId === NULL||!is_numeric($problemId)||$problemId<=0){
            $result = array('status' => false , 'reason' => '错误的题目编号');
            echo json_encode($result);
            return;
        }
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/problem_edit","problem_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        if($type != "admin"){
            $result = array('status' => false , 'reason' => '无管理员权限');
            echo json_encode($result);
            return;
        }
        
        $this->problem_edit->del_problem($problemId);
        //这里需要增加状态判断，如果删除失败返回false，否则为true
        $result = array('status' => true);
        echo json_encode($result);
    }
    
    public function update_defunct($problemId = NULL,$defunct = NULL){
        Global $data;
        if($problemId == NULL || $defunct == NULL){
            $this->error->show_error("参数错误",array("请不要擅自构造url！"),$data);
            return;
        }
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/problem_edit","problem_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //     return;
        // }
        $this->problem_edit->update_problem($problemId,array('defunct'=>$defunct));
        $result = array('status' => true);
        echo json_encode($result);
    }
    
    public function add_problem(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/problem_edit","problem_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        if($type != "admin"){
            $this->error->show_error("对不起， 添加普通问题需要管理员权限",array("需要更改问题，请联系管理员"),$data);
            return;
        }
        $date_str="%Y-%m-%d %H:%i:%s";
        $this->load->helper('date');
        $now=strtotime("now");
        $title = stripslashes($_POST['title']);
        $description = stripslashes($_POST['description']);
        $input = stripslashes($_POST['input']);
        $output = stripslashes($_POST['output']);
        $sampleInput = stripslashes($_POST['sampleInput']);
        $sampleOutput = stripslashes($_POST['sampleOutput']);
        $inputData = stripslashes($_POST['input-test']);
        $outputData = stripslashes($_POST['output-test']);        
        $hint = stripslashes($_POST['hint']);
        $source = stripslashes($_POST['source']);;//stripslashes($_POST['source']);
        $inDate = $now;
        $timeLimit = stripslashes($_POST['time-limit']);
        $memoryLimit = stripslashes($_POST['memory-limit']);

        //这里漏了输入格式和输出格式，input和output应该是格式而不是最终匹配的测试数据，需要修改，增加inputData
        $problem_array = array('title'=>$title,'description'=>$description,'input'=>$input,
        'output'=>$output,'sampleInput'=>$sampleInput,'sampleOutput'=>$sampleOutput,'hint'=>$hint,
        'source'=>$source,'inDate'=>$inDate,'timeLimit'=>$timeLimit,'memoryLimit'=>$memoryLimit);
        $problemId = $this->problem_edit->add_problem($problem_array);
        
        $basedir = "/home/judge/data/".$problemId;
        mkdir($basedir,0755);
        $this->load->helper('file');
        write_file($basedir."/test.in", $inputData);
        write_file($basedir."/test.out", $outputData);
        write_file($basedir."/sample.in", $sampleInput);
        write_file($basedir."/sample.out", $sampleOutput);

        //添加完题目应跳转到添加成功页面或者直接跳转到problem detail页
    }
    
    public function add(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/problem_edit","problem_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $this->error->show_error("对不起， 添加普通问题需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //     return;
        // }
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/add_problem",$data);
        $this->load->view("common/admin_footer",$data);        
    }
}
