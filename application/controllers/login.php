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
				$result = array('result'=>2);//用户已经登录了返回数组2
				echo json_encode($result);
			}else if(strlen($info=$this->input->post('username',TRUE))>=4 &&
			strlen($pass=$this->input->post('pa',TRUE))>=6){//如果用户提交数据长度不符合返回3
				$info=$this->input->post('username',TRUE);
				$pass=$this->input->post('pa',TRUE);
				$userdata=NULL;
				if(($userdata=$this->user_help->set_session($info,$pass))!=FALSE){
					$data['user']=$userdata;
					$data['is_login']=TRUE;
					$result = array('result'=>1);
					echo json_encode($result);//用户登录成功返回数组1
				}else{
					$result = array('result'=>0);//用户正常登录失败返回数组0
					echo json_encode($result);
				}
			}else{
				$result = array('result'=>3);//长度不符合echo3
				echo json_encode($result);
			}
		}
		
			
	}
	
	
	
	
}
