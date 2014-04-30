<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

	 
	public function __construct()
	{
		parent::__construct();
	}

	public function index($page=1){
		Global $data;

		$data['page_title']='课程';
		$this->load->model('course_model','course');
		//取总课程数
		$total = $this->course->get_course_count();
		if($total==0){
			$data['is_empty']=TRUE;
			$data['contest_list']=array();
		}

		//根据分页选取需要的数据
		if(is_numeric($page) && $page>=1 && (($page-1)*10<=$total)){
			$list = $this->course->get_course_list(($page-1)*10,10);
		}
		//var_dump($list);
		$data['list']=$list;

		$this->load->library('pagination');
		$config['first_link'] = TRUE;
		$config['last_link'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url("course/index");
		$config['total_rows'] = $total;
		$config['per_page'] =10;
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['num_tag_open'] = '<li>';
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



		$this->load->view('common/header',$data);
		$this->load->view('course/all');
		$this->load->view('common/footer');
		
	}
	
	public function detail($id){
		Global $data;
		$data['page_title']='课程';
		$this->load->model('course_model','course');
		if(!is_numeric($id)){
			//用户可能进行非法操作
			$this->error->show_error("没有此课程",array("找不到对应的课程"),$data);
			return;
		}
		$units = $this->course->get_course_unit_list($id);
		$data['units'] = $units;
		//var_dump($units);
		$data['permission']="no";

		$this->load->view('common/header',$data);
		$this->load->view('course/list',$data);
		$this->load->view('common/footer',$data);
		

	}

	public function unit($cid,$uid){
		Global $data;
		$data['page_title']='课程';
		$this->load->model('course_model','course');
		if(!is_numeric($cid)||!is_numeric($uid)){
			//用户可能进行非法操作
			$this->error->show_error("没有此课程",array("找不到对应的课程"),$data);
			return;
		}
		$pri = FALSE;
		//判断是否拥有读取的权限
		if($data['is_login'])
			$pri = $this->course->get_course_privilege($cid,$data['user']['userId'],'read');
		//var_dump($pri);
		//对没有登陆以及没有登陆的用户作ERROR提示处理
		if($data['is_login'] == FALSE || $pri == FALSE){
			$this->error->show_error("没有权限查看该单元",array("你需要先行登陆","如果登陆后依然无法查看","请与老师联系添加权限"),$data);
			return;	
		}
		$data["list"] = $this->course->get_unit_problem_list($uid);

		$this->load->view('common/header',$data);
		$this->load->view('course/unit',$data);
		$this->load->view('common/footer',$data);		

	}
}
