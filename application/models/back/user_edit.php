<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_edit extends CI_Controller {
	
	public function add_user($user_array=array('name'=>"name",'email'=>"example@qq.com",'password'=>"123456",'salt'=>""),$user_state_array=array('submit'=>0,'solved'=>0))
	{
		$this->db->trans_start();
		$this->db->insert('user',$user_array);
		$userId=$this->db->insert_id();
		$user_state_array['userId']=$userId;
		$this->db->insert('user_state',$user_state_array);
		$this->db->trans_complete();
		return $userId;
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
	
	public function unique_user($name){
		$sql="SELECT name FROM user WHERE name = ".$this->db->escape($name)." ";
		$query=$this->db->query($sql);
		$name=$query->row_array();
		if(count($name)>0)
			return false;
		else 
			return true;
	}
	public function unique_email($email){
		$sql="SELECT email FROM user WHERE email = ".$this->db->escape($email)." ";
		$query=$this->db->query($sql);
		$email=$query->row_array();
		if(count($email)>0)
			return false;
		else 
			return true;
	}
	
	public function get_id_by_name($info){
		$info = $this->db->escape($info);
		$sql = "SELECT userId FROM user WHERE email = ".$info." OR name = ".$info ;
		$query = $this->db->query($sql);
		$user_info = $query->row_array(0);
		if(!empty($user_info['userId']))
			return $user_info['userId'];
		return false;		
	}
	
}
