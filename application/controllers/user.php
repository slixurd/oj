<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	var $data;

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
  }
  
	public function index()
	{
		Global $data;
         if($data['is_login']){
			$this->load->view('common/header',$data);
			$this->load->view('user_info_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			//退回刚才的页面或者提示
		}
	}
  
	public function register()
	{
		Global $data;
		$data['page_title']='注册';
		if($data['is_login']){
			$this->load->view('common/header',$data);
			$this->load->view('register_nonavailable_view',$data);
			$this->load->view('common/footer',$data);
		}else {
			$this->load->view('common/header',$data);
			$this->load->view('register_view',$data);
			$this->load->view('common/footer',$data);
		}
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
			$u_email=$this->oj_model->unique_email($user['email']);
			$u_name=$this->oj_model->unique_user($user['name']);
			if($u_email==1 && $u_name==1){
				$this->oj_model->add_user($user);
			}else{
				$this->load->view('common/header',$data);
				$this->load->view('register_fail_view',$data);
				$this->load->view('common/footer',$data);
			}
			if(($data['user']=$this->user_help->set_session($user['name'],$this->input->post('pa',TRUE)))!=FALSE){
					$this->load->view('common/header',$data);
					$this->load->view('register_success_view',$data);
					$this->load->view('common/footer',$data);
				}else{
					$this->index();
				}
			
		}
		else{
			$this->index();
		}
	}

	public function check_unique_email(){
		$email_to_check = $this->input->post('email',TRUE);
		$unique = array('email' => $this->oj_model->unique_email($email_to_check) ); 
		echo json_encode($unique);
	}

	public function check_unique_username(){
		$name_to_check = $this->input->post('username',TRUE);
		$unique = array('username' => $this->oj_model->unique_user($name_to_check) ); 
		echo json_encode($unique);
	}
	
}
