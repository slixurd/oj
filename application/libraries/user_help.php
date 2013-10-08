<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_help {

/**
 * 此类自动装载，函数在使用前请先声明Global $data
 */
	public function __construct(){
		 Global $data;
		 $data['is_login']=FALSE;
		 $data['user']=array();
         if($this->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->get_session();
		}
	}
	
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
		if(($user=$CI->oj_model->get_user_item($info,array('userId','name','email','salt','password')))===FALSE){
			//用户名不正确
			return FALSE;
		}else{
			if($user['password']==$CI->encrypt->sha1($user['salt'].$pass)){
				$CI->session->set_userdata($user);
				//成功登录
				return $CI->session->all_userdata();
			}else{
				//密码不正确
				return FALSE;
			}
		}
		
	}
	
	
/*
 * 此函数查询是否已经存在用户，如果用户名已经存在返回1,email已经存在返回2,不存在返回0
 */
	public function is_user($name,$email){
		$CI->load->model('oj_model');
		return $this->oj_model->is_user($name,$email);
	}
	
	public function get_session(){
		$CI =& get_instance();
		return $CI->session->all_userdata();
	}
	
	public function salt($min,$max){
		if(is_numeric($min) && is_numeric($max) && ($max>=$min)){
			$salt_str="";
			$lenth=rand($min,$max);
			for($j=0;$j<$lenth;$j++){
				$i=rand(0,2);
				switch($i){
					case 0 :
						$salt_str=$salt_str.mt_rand(0,9);
						break;
					case 1:
						$salt_str=$salt_str.chr(mt_rand(65,90));
						break;
					case 2:
						$salt_str=$salt_str.chr(mt_rand(97,122));
						break;
					}
				}
				return $salt_str;
		}else{
			return FALSE;
		}
	}
	
}
