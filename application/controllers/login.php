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
		$date_str="%Y-%m-%d %H:%i:%s";
		$now=strtotime("now");
		$befor=$now-60*5;//5分钟前的unix时间撮
		$befor=mdate($date_str,$befor);
		
		if($this->form_validation->run()===TRUE){
			$defunct=0;
			$info=$this->input->post('username',TRUE);
			
			if($this->oj_model->get_row("user","userid","defunct = 1 AND
					name = ".$this->db->escape($info)."  OR email = ".$this->db->escape($info)."")>0){
				if($this->oj_model->get_row("login_log","info","result = 0 AND
					time > ".$this->db->escape($befor)."  AND info = ".$this->db->escape($info)."")>=0 && $defunct==0){
						$result = array('result'=>-1);//用户被冻结
						$defunct=1;
						echo json_encode($result); 
				}else{
					$this->oj_model->update_user(array('defunct'=>0),"name = ".$this->db->escape($info)." OR
						email= ".$this->db->escape($info)." ");
				}

			}
			if($data['is_login'] && $defunct==0){//用户状态正常
				$result = array('result'=>2);//用户已经登录了返回数组2
				echo json_encode($result);
			}else if(strlen($info>=4) && strlen($info<=50) &&
			strlen($pass)>=6 && strlen($pass)<=20 && $defunct==0){//如果用户提交数据长度不符合返回3
				$info=$this->input->post('username',TRUE);
				$pass=$this->input->post('pa',TRUE);
				$userdata=NULL;
				if(($userdata=$this->user_help->set_session($info,$pass))!=FALSE){
					$data['user']=$userdata;
					$data['is_login']=TRUE;
					$result = array('result'=>1);
					echo json_encode($result);//用户登录成功返回数组1
				}else{
					if($this->oj_model->get_row("login_log","info","result = 0 AND
					time > ".$this->db->escape($befor)."  AND info = ".$this->db->escape($info)."")>20){
						$this->oj_model->update_user(array('defunct'=>1),"name = ".$this->db->escape($info)." OR
						email= ".$this->db->escape($info)." ");
						$result = array('result'=>-1);//用户被冻结
						echo json_encode($result); 
					}else{
						$result = array('result'=>0);//用户正常登录失败返回数组0
						echo json_encode($result);
					}
				}
			}else if($defunct==0){
				$result = array('result'=>3);//长度不符合echo3
				echo json_encode($result);
			}
		}
		
			
	}
	
	
	
	
}
