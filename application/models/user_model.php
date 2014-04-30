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
	public function get_user_item_id($id,$column_array=array('userId','name','email','password','type','programLan','regTime',
	'nick','school','defunct'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}
	
	/**
	*get_user_state_item获取user_state信息函数通过id,包括submit,ac数，最近登录时间，返回result数值参考如下
	*/

	public function get_user_state_item($id,$column_array=array('accessTime','submit','solved')){
		$sql="SELECT ".implode(" , ",$column_array)." FROM user_state WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}
	
	/*
	 * get_user_all_state获取用户所有的解题统计状况
	 * 返回所有的用户解题统计结果，但是没有出现的结果将不会返回
	 * OJ_WT0 0； OJ_WT1 1； OJ_CI 2； OJ_RI 3； OJ_AC 4； OJ_PE 5； OJ_WA 6；
	 * OJ_TL 7； OJ_ML 8； OJ_OL 9； OJ_RE 10；OJ_CE 11；OJ_CO 12；OJ_TR 13
	 */
	
	public function get_user_all_state($id)
	{
		$id = $this->db->escape($id);
		$sql = "select userId,result,count(result) as count from solution where userId = ".$id." group by result";
		$query = $this->db->query($sql);
		return $query->result_array();
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
	
	/*
	 * update_access_time更新用户登录时间
	 */
	 
	 public function update_access_time($id)
	 {
		$this->load->helper('date');
		$date_str="%Y-%m-%d %H:%i:%s";
		$update_array = array('accessTime'=>mdate($date_str));
		$sql = $this->db->update_string('user_state',$update_array,"userId = ".$this->db->escape($id));
		$this->db->query($sql);
	 }
	
	/*
	 * 获取用户的题目列表，会返回用户有解决的和没有解决的问题列表
	 * 返回4是解决的问题，其他值为没有解决
	 */
	
	public function get_user_solution_list($id)
	{
		$sql1 = "SELECT title,result,problem.problemId 
				FROM solution left join problem ON solution.problemId=problem.problemId 
				WHERE userId = ".$this->db->escape($id).
				" and result = 4 GROUP BY problemId";
		$sql2 = "SELECT title,result,problem.problemId 
				FROM solution left join problem ON solution.problemId=problem.problemId 
				WHERE userId = ".$this->db->escape($id)." and solution.problemId not in (SELECT problemId 
				FROM solution WHERE userId = ".$this->db->escape($id).
				" and result = 4 GROUP BY problemId) group by solution.problemId";
		$query1 = $this->db->query($sql1);
		$query2 = $this->db->query($sql2);
		$result1 = $query1->result_array();
		$result2 = $query2->result_array();
		return array_merge($result1,$result2);
	}
	
	/*
	 *获取用户登录记录，包括有成功的和没有成功的
	 */
	 
	public function get_login_log_list($name,$email)
	{
		$name = $this->db->escape($name);
		$email = $this->db->escape($email);
		$sql = "SELECT ip,time,result FROM login_log WHERE info = ".$name." OR info = ".$email;
		$query = $this->db->query($sql);
		return $query->result_array();
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

	private function get_email($name){
		$sql = "SELECT email FROM user
				WHERE name = ".$this->db->escape($name);
		$email = $this->db->query($sql);
		$email = $email->row_array(0);
		if(empty($email))
			return FALSE;
		return $email['email'];

	}	
	
	public function check_email($name,$email){
		$check = $this->get_email($name);
		if($check === FALSE)
			return FALSE;
		if($this->db->escape($check) === $this->db->escape($email)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function force_cpass($name,$new_pass)
	{
		$salt = $this->salt();
		$update_array = array('password'=>$this->encrypt->sha1($salt.$new_pass),'salt'=>$salt);
		$sql = $this->db->update_string('user',$update_array,"name = ".$this->db->escape($name));
		$this->db->query($sql);
		return true;
	}
	
}
