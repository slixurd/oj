<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_admin extends CI_Controller {

	 
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
		$this->load->model("user_model");
		$this->load->model("back/problem_edit","problem_edit");
		$type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
		$type = $type['type'];
		if($type != "admin"){
			$this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
			return;
		}
		$total = $this->problem_edit->get_count();
		$data['problem_list'] = $this->problem_edit->get_problem_list(($page-1)*10,10);
		echo var_dump($data['problem_list']);
		
		
		$this->load->library('pagination');
		$config['first_link'] = TRUE;
		$config['last_link'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url("problem_add");
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
	}
	
	public function del($problemId = NULL){
		Global $data;
		if($problemId === NULL){
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
		if($type != "admin"){
			$this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
			return;
		}
		
		$this->problem_edit->del_problem($problemId);
		echo "hello";
		//这里载入相关的页面即可
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
		if($type != "admin"){
			$this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
			return;
		}
		$this->problem_edit->update_problem($problemId,array('defunct'=>$defunct));
		$return = 1;
		echo json_encode($return);
	}
	
}
