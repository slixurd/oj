<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
  }
  
	public function index(){
		Global $data;
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		
		if($this->form_validation->run()===TRUE){
			if($data['is_login']){
				//提示用户已经登录退回去
			}else{
				$info=$this->input->post('username',TRUE);
				$pass=$this->input->post('pa',TRUE);
				$userdata=NULL;
				if(($userdata=$this->user_help->set_session($info,$pass))!=FALSE){
					$data['user']=$userdata;
					redirect(site_url("problem"));
					//登录成功直接跳转到问题页面
				}else{
					//提示用户用户名或者密码不正确
				}
			}
		}
			
	}
	
}
