<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index($page=1){
		Global $data;
		GLOBAL $lan;
		Global $compile_status;
	
		$data['page_title']='提交状态';
		if($data['is_login']===FALSE){
			$this->error->show_error("你还没有登录",array("此页面需要登录，请先登录","点击右上角登录"),$data);
			return;
		}
		$this->load->model("status_model","status");
		$total = $this->status->get_status_count();
		$data['lan'] = $lan;
		$data['status'] = $compile_status;
		if($page>=1 && is_numeric($page) && (($page-1)*10<=$total)){
			$column_array=array('*');
			$data['status_list']=$this->status->get_status_list(($page-1)*10,10);

			$this->load->library('pagination');
			$config['first_link'] = TRUE;
			$config['last_link'] = TRUE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url("status/index");
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
			$this->load->view('status/all',$data);
			$this->load->view('common/footer',$data);
		}else{
			$this->error->show_error("url错误",array("没有找到你要的页面","可能是你的url不对啊，请检查"),$data);
		}
	}
	
	public function contest_status(){
	}
	
	public function course_status(){
	}

	public function personal(){
		Global $data;
		$data['page_title']='提交状态';
		if($data['is_login']===FALSE){
			$this->error->show_error("你还没有登录",array("此页面需要登录，请先登录","点击右上角登录"),$data);
			return;
		}

		$this->load->model("status_model","status");
		$result = $this->status->get_most_recent($data['user']['userId']);
		$this->load->view('common/header',$data);
		$this->load->view('status/personal',$data);
		$this->load->view('common/footer',$data);

	}

	public function update_result(){
		Global $data;
		Global $compile_status;
		$data['page_title']='提交状态';
		if($data['is_login']===FALSE){
			$this->error->show_error("你还没有登录",array("此页面需要登录，请先登录","点击右上角登录"),$data);
			return;
		}

		$this->load->model("status_model","status");
		$result = $this->status->get_most_recent($data['user']['userId']);
		$result = $this->status->get_solution_result($result['solutionId']);
		$return_value = array('status' => $compile_status[$result],'code' => $result);
		echo json_encode($return_value);
	}
	
}
