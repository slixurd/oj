<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends CI_Controller {

	 
	public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
  }

	public function index($page=1){
		$data['is_login']=FALSE;
		if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
		}//这里用来表示用户是否登录传递到view页面
		$total=$this->oj_model->get_row("contest","contestId","defunct = 0");//contest总行数
		if($total==0){
			//没有竞赛
		}
		if(is_numeric($page) && $page>=1 && (($page-1)*10<$total)){
			$column_array=array('contestId','title','startTime','endTime','defunct','private');
			$data['contest_list']=$this->oj_model->get_contest_list_where($column_array,
			"contestId",TRUE,"defunct = 0",($page-1)*10,10);
			
			$this->load->library('pagination');
			$config['first_link'] = TRUE;
			$config['last_link'] = TRUE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = 'http://localhost/scutoj/index.php/contest/index/';
			$config['total_rows'] = $total;
			$config['per_page'] = 10;

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
			$this->load->view('contest_list_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			$this->index();//页面没找到
			//show(404);
		}
		
	}
}
