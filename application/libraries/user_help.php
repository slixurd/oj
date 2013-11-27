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
		$CI->load->library('encrypt');
		$user=NULL;
		$CI->load->helper('date');
		$date_str="%Y-%m-%d %H:%i:%s";
		if(($user=$CI->oj_model->get_user_item($info,array('userId','name','email','salt','password')))===FALSE){
			//用户名不正确
			$ip=$CI->session->userdata('ip_address');
			$CI->oj_model->add_login_log(array('info'=>$info,'password'=>$CI->encrypt->sha1($user['salt'].$pass),'ip'=>$ip,
			'time'=>mdate($date_str),'result'=>0));
			return FALSE;
		}else{
			if($user['password']==$CI->encrypt->sha1($user['salt'].$pass)){
				$ip=$CI->session->userdata('ip_address');
				$CI->oj_model->add_login_log(array('info'=>$info,'password'=>$user['password'],'ip'=>$ip,
				'time'=>mdate($date_str),'result'=>1));
				$user=array('userId'=>$user['userId'],'name'=>$user['name']);
				$CI->session->set_userdata($user);
				//成功登录
				return $CI->session->all_userdata();
			}else{
				$ip=$CI->session->userdata('ip_address');
				$CI->oj_model->add_login_log(array('info'=>$info,'password'=>$CI->encrypt->sha1($user['salt'].$pass),'ip'=>$ip,
				'time'=>mdate($date_str),'result'=>0));
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
	
	public function salt($min=25,$max=35){
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
	
	public function check_name($name){//对密码或用户名进行检查
		$preg= preg_match("/^[a-zA-Z0-9_]+$/", $name) ? 1:0; //1：符合格式，0不符合
		$len=strlen($name);
		$rt=array('name_preg'=>$preg,'name_len'=>$len);
		return $rt;
	}
	
	
	public function check_pass($pass){//对密码或用户名进行检查
		$preg= preg_match("/^[a-zA-Z0-9_]+$/", $pass) ? 1:0; //1：符合格式，0不符合
		$len=strlen($pass);
		$rt=array('pass_preg'=>$preg,'pass_len'=>$len);
		return $rt;
	}
	
	public function check_email_preg($email){
		$reg_str='/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
		$preg = preg_match($reg_str,$email)?1:0;
		$rt = array('email_preg'=>$preg);
		return $rt;
	}
	
	public function login_time($info){//获取给定用户名或者邮箱的5分钟内登录次数，如果不存在的话自动设置为1，redis类型为string
		$CI =& get_instance();
		$login_time = 0;
		$login_key = "login_time_".$info;
		if($CI->redis->exists($login_key)==0){
			$CI->redis->set($login_key,1);
			$CI->redis->expire($login_key,300);
			return 1;
		}else{
			//$this->redis->hset('login_log',$info,1);
			$login_time = $CI->redis->get($login_key);
			$CI->redis->incrby($login_key,1);
			$CI->redis->expire($login_key,300);
			return $login_time;
		}
	}
}
