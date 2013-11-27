<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	public function __construct()
	{
		parent::__construct();
	}
  //-1用户被冻结，0密码用户名不匹配，1登录成功，2用户已经登录，3长度不符合
	public function index(){
		Global $data;
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		$this->load->helper("date");
		
		if($this->form_validation->run()===TRUE){
			$info=$this->input->post('username',TRUE);
			$pass=$this->input->post('pa',TRUE);
			$login_time = $this->user_help->login_time($info);//用户五分钟之内登录次数
			//echo (strlen($info)>=4).(strlen($info)<=50).(strlen($pass)>=6).(strlen($pass)<=20).($defunct==0;)
			if($data['is_login']){//用户状态正常
				$result = array('result'=>2);//用户已经登录了返回数组2
				echo json_encode($result);
			}else if(strlen($info)>=4 && strlen($info)<=50 &&
			strlen($pass)>=6 && strlen($pass)<=20){//如果用户提交数据长度不符合返回3
				$userdata=NULL;
				if($login_time>=20){
						$this->oj_model->update_user(array('defunct'=>1),"name = ".$this->db->escape($info)." OR
						email= ".$this->db->escape($info)." ");
						$result = array('result'=>-1);//用户被冻结
						echo json_encode($result); 
				}else if(($userdata=$this->user_help->set_session($info,$pass))!=FALSE){
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
