<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_submit extends CI_Controller {

	 
	public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
    $this->load->helper('url');
  }
  
  public function index($problemId=10000){
	  $data['is_login']=FALSE;
		if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
		}else{
			redirect(site_url("problem"));//下面可以提示用户登录
		}
		
		$data['problem']=$this->oj_model->get_problem_item($problemId,array('problemId'));
	    $this->load->view('common/header',$data);
	    $this->load->view('student/problem_submit_view',$data);
	    $this->load->view('common/footer',$data);
  }
}
