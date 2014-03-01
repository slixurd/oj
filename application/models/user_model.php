<?php

class User_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	*get_user_item_id 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
	* 返回一维数组，如果没有则返回空数组
	*/
	public function get_user_item_id($id,$column_array=array('userId','name','email','password'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}
	
	/**
	 * check_user_password_info 用来检查用户的密码是否正确,info是指有效登录凭证（用户名，email），$pass是密码，注意密码是未经sha1之前
	 * 如果用户不存在或者密码不正确，返回false，否则返回true
	 */
	 
	public function check_user_password_info($info,$pass)
	{
		$this->load->library('encrypt');
		$info = $this->db->escape($info);
		$sql = "SELECT salt,password FROM user WHERE email = ".$info." OR name = ".$info ;
		$query = $this->db->query($sql);
		$user_info = $query->row_array(0);
		if(empty($user_info))
			return false;
		$pass = $this->encrypt->sha1($user_info['salt'].$pass);
		if($pass == $user_info['password'])
			return true;
		return false;
	}
	
	/**
	 * check_user_password_id 用来检查用户的密码是否正确,id是指用户id，$pass是密码，注意密码是未经sha1之前
	 * 如果用户不存在或者密码不正确，返回false，否则返回true
	 */
	 
	public function check_user_password_id($id,$pass)
	{
		$this->load->library('encrypt');
		$id = $this->db->escape($id);
		$sql = "SELECT salt,password FROM user WHERE userId = ".$id ;
		$query = $this->db->query($sql);
		$user_info = $query->row_array(0);
		if(empty($user_info))
			return false;
		$pass = $this->encrypt->sha1($user_info['salt'].$pass);
		if($pass == $user_info['password'])
			return true;
		return false;
	}
	 
	/*
	 * update_user_password用来更改密码，id是用户id，new_pass为新密码，old_pass为旧的密码
	 * 更改成功返回true，更改失败返回false,注意请先调用check pass进行格式审核
	 */
	public function update_user_password($id,$new_pass,$old_pass)
	{
		if($this->check_user_password_id($id,$old_pass))
		{
			$salt = $this->salt();
			$update_array = array('password'=>$this->encrypt->sha1($salt.$new_pass),'salt'=>$salt);
			$sql = $this->db->update_string('user',$update_array,"userId = ".$this->db->escape($id));
			$this->db->query($sql);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	 * salt函数用户产生一个随机字符串，min指定最小长度，max指定最大长度
	 * 返回值为一个在最小长度到最大长度之间的随机长度的字符串
	 */
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
	
	/*
	 * check_pass对密码进行格式审核
	 * 返回值，1符合格式，0不符合格式
	 */
	
	public function check_pass($pass){//对密码或用户名进行检查
		$preg= preg_match("/^[a-zA-Z0-9_]+$/", $pass) ? 1:0; //1：符合格式，0不符合
		$len=strlen($pass);
		$rt=array('pass_preg'=>$preg,'pass_len'=>$len);
		return $rt;
	}
	
}
