<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index($page=1){
		if($data['is_login']===FALSE){
			//请先登录
		}
		Global $data;
		$by_id=FALSE;
		$data['page_title']='提交状态';
		$total=0;
		$data['status_list']=array();
		$s_str="";
		
		if(isset($_POST['s_id'])){
			//判断是否是id搜索
			$s_id=$_POST['s_id'];
			$by_id=TRUE;
			$s_str="userId = ".$this->db->escape($data['user']['userId'])." AND problemId = ".$this->db->escape($s_id)." ";
		}else{
			$s_str="userId = ".$this->db->escape($data['user']['userId'])." ";
		}
		$total = $this->oj_model->get_row("solution","solutionId",$s_str);
		
		if(isset($_POST['s_id'])){
				$limit_from=0;
				$limit_row=$total;
				$is_search=TRUE;
			}else{
				$is_search=FALSE;
				$limit_from=($page-1)*10;
				$limit_row=10;
			}//判断是否是搜索模式是的话下面就不分页
			
			
		if($page>=1 && is_numeric($page) && (($page-1)*10<=$total)){
			$column_array=array('*');
			$data['status_list']=$this->oj_model->get_list_where("solution",$column_array,"solutionId",TRUE,$s_str,$limit_from,$limit_row);
			
			$this->load->library('pagination');
			$config['first_link'] = TRUE;
			$config['last_link'] = TRUE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url("status");
			$config['total_rows'] = $total;
			if($is_search==TRUE){
				$config['per_page'] =$total;
			}else
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
			$this->load->view('status_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			show_404();//找不到地址
		}
	}
	
	public function contest_status(){
	}
	
	public function course_status(){
	}
	
}
