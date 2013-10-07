<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	var $data;

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
    $this->load->helper('url');
    $this->load->helper('form');
	$this->load->library('form_validation');
  }
  
	public function index()
	{
		 $data['is_login']=FALSE;
		 $data['user']=NULL;
         if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
			$this->load->view('common/header',$data);
			$this->load->view('user_info_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			//退回刚才的页面或者提示
		}
	}
  
	public function register()
	{
		 $data['page_title']='注册';
		 $data['is_login']=FALSE;
		 $data['user']=NULL;
         if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
		}
		$this->load->view('common/header',$data);
		$this->load->view('register_view',$data);
		$this->load->view('common/footer',$data);
	}
	
/**
 * 注册提交地址以post的方式注册
 */
	
	public function register_submit()
	{
		$this->load->helper('date');
		$date_str="%Y-%m-%d %H:%i:%s";
		$this->load->library('encrypt');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		$this->form_validation->set_rules('email');
		$salt=$this->user_help->salt(25,35);
		if($this->form_validation->run() === TRUE ){
			$user=array(
				'name'=>$this->input->post('username',TRUE),
				'password'=>$this->input->post('pa',TRUE),
				'email'=>$this->input->post('email',TRUE),
				'defunct'=>0
			);
			$user['password']=$this->encrypt->sha1($salt.$user['password']);
			$user['salt']=$salt;
			$user['regTime']=mdate($date_str);
			$this->oj_model->add_user($user);
			if(($data['user']=$this->user_help->set_session($user['name'],$this->input->post('pa',TRUE)))!=FALSE){
					redirect(site_url("problem"));
				}else{
					$this->index();
				}
			
		}
		else{
			$this->index();
		}
	}
	
}
