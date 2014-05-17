<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("back/contest_edit","contest_edit");
        $this->load->model("back/user_edit","user_edit");
    }
    
    public function index($page = 1){
		Global $data;
		
		if(!is_numeric($page) || $page< 1){
			 $this->error->show_error("对不起，地址错误",array("页面编号错误"),$data);
            return; 
		}
       
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $data['page_title']='竞赛';
        
        //进行后台身份权限审查
        
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        
        $total = $this->contest_edit->get_contest_count();
        $data['contest_list'] = $this->contest_edit->get_contest_list(($page-1)*10,10);
        //echo var_dump($data);
        
        $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = site_url("admin/contest/index");
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 4;         
        $config['num_tag_close'] = '</li>';
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
        //$this->load->view("admin/contest_list",$data);
        $this->load->view("common/admin_footer",$data);
    }
    
    public function problem($contestId = 0,$page = 1){
		Global $data;
		
		if(!is_numeric($contestId)||$contestId <= 0||$page < 1 || !is_numeric($page)){
            $this->error->show_error("对不起，地址错误",array("单元编号错误或者页数错误"),$data);
            return; 
        }
		
		 if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
		$data['page_title']='竞赛';
        
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        
        $this->load->model("back/problem_edit","problem_edit");

		$plist = $this->contest_edit->get_contest_problem_list($contestId);
        $data['plist'] = $plist;
        $data['contestId'] = $contestId;
		
		$total = $this->problem_edit->get_count();
		$data['problem_list'] = $this->problem_edit->get_problem_list(($page-1)*10,10);
		
		 $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;

        $config['base_url'] = site_url("admin/contest/problem").'/'.$contestId.'/';
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 5; 
        //后缀,保证点击分页以后直接显示整个问题列表
        $config['suffix'] = "#problem";
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
        //$this->load->view("admin/contest_problem_add",$data);
        $this->load->view("common/admin_footer",$data);     
    }
    
    public function add(){
		Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }

        $this->load->view("common/admin_header",$data);
        //$this->load->view("admin/contest_add",$data);
        $this->load->view("common/admin_footer",$data);    
    }
    
    public function add_up(){
		Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }

        $title = $this->input->post('title',true);
        $stime = $this->input->post('stime',true);
        $etime = $this->input->post('etime',true);
        $private = $this->input->post('private',true) == "public"? 1 : 0 ;
        $describe = $this->input->post('describe',true);
        $students = $this->input->post('students',true);
        $userId = $data['user']['userId'];
        
        if(strtotime($stime)>strtotime($time)){
			 $this->error->show_error("结束时间必须大于开始时间",array("重新检查"),$data);
            return;      
		}
		
		$cid = $this->contest_edit->add_contest($userId,$title,$stime,$etime,$private);
		if($cid == false || !is_numeric($cid)){
			 $this->error->show_error("提交出错",array("请重新提交"),$data);
            return;        
		}
		
		//批量插入学生
		$stu_nums = preg_split('/\r\n/',$students);
		foreach($stu_nums as $stu_num){
			if($this->user_help->check_name($user['name']) == 1){
				//echo "student: ".$name."<br>";
				$this->contest_edit->add_contest_user($stu_num,$stu_num,$cid);
			}
		}
		
		 redirect('/admin/contest/problem/'.$cid, 'location', 301);
		 
	}
	
	public function del_up($contestId = NULL){
		Global $data;
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        
        //这里可以先判断是否是管理员之类的
        if(!$this->user_edit->get_user_privilege("contest",$contestId,$data['user']['userId'],"del")){
			$result = array('status' => false , 'reason' => '没权限');
            echo json_encode($result);
            return;
		}
		
		if($this->contest_edit->del_contest($contestId)){
			$result = array('status' => true);
		}else
			$result = array('status' => false);
		echo json_encode($result);
	}
	
	public function problem_select($contestId,$problemId){
		Global $data;
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        
        $action = $this->input->get('action',true);
        
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        
        //这里可以先判断是否是管理员之类的
        if(!$this->user_edit->get_user_privilege("contest",$contestId,$data['user']['userId'],"edit")){
			$result = array('status' => false , 'reason' => '没权限');
            echo json_encode($result);
            return;
		}
		
		if(($action == 1) && $this->contest_edit->add_contest_problem($contestId,$problemId)){
			//这里如果用户如果传入非法id，因为外键约束是不能添加成功的
			$result = array('status' => true);
		}else if(($action == 0 && $this->contest_edit->del_contest_problem($contestId,$problemId))){
			$result = array('status' => true);
		}else
			$result = array('status' => false);
		echo json_encode($result);
	}
	
}
