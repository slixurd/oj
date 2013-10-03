<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_help {


	
/**
 * 查看session是否存在，返回FALSE或者TRUE
 */
    public function is_session(){
		$CI =& get_instance();
		$CI->load->model('oj_model');
		$CI->load->library('session');
		if($CI->session->all_userdata()){
			if($CI->session->userdata('userId')===FALSE){
				//用户未登录
				return FALSE;
			}
			if($CI->oj_model->is_session($CI->session->userdata('session_id'))){
				//用户已经登录了
				return true;
			}
		}else{
			//用户非法修改cookie
			return false;
		}
		
	}
	
/**
 * 验证用户是否正确，存在的话就写入session，不存在的话就返回FALSE
 */
	
	public function set_session($info,$pass){
		$CI =& get_instance();
		$CI->load->model('oj_model');
		$CI->load->library('encrypt');
		$CI->load->library('session');
		$user=NULL;
		if(($user=$CI->oj_model->get_user_item($info,array('userId','name','email')))===FALSE){
			//用户名不正确
			return FALSE;
		}else{
			if($CI->encrypt->decode($user['password'])==$pass){
				$CI->session->set_userdata($user);
				//成功登录
				return $CI->session->all_userdata();
			}else{
				//密码不正确
				return FALSE;
			}
		}
		
	}
	
	public function get_session(){
		$CI =& get_instance();
		return $CI->session->all_userdata();
	}
	
}
