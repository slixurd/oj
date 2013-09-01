<?php 

/**
所有oj model函数均在此类当中
*/

class Oj_model extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

/**
get_problem_list()给定参数的问题列表
$is_search指名是否启用where查询，$column_array数组指明想要获取的problem列
$where_str为where处的条件字符串，如"problemId > 9999"用此参数时请先对相关数据用转义，再传进来
*/


	public function get_problem_list($is_search=FALSE,$column_array=array('problemId','title','source','accepted','submit'),$where_str="defunct = 0")
	{
		//判断不是条件查询模式
		if($is_search == FALSE){
			$sql="SELECT ".implode(" , ",$column_array)." FROM problem";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		//判断启用where查询
		else{
			$sql="SELECT ".implode(" , ",$column_array)." FROM problem WHERE "."$where_str  ";//条件查询模式
			$query=$this->db->query($sql);
			return $query->result_array();
		}
	}

/**
get_problem_item 按照id和指定列获取某个问题
*/

	public function get_problem_item($id,$column_array=array('problemId','title','source','accepted','submit')){
		$sql="SELECT ".implode(" , ",$column_array)." FROM problem WHERE problemId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		//return $sql;
		return $query->row_array(0);
	}

/**
add_problem
problem_array给出要插入的列和值
*/

	public function add_problem($problem_array=array('title'=>"A+B",'defunct'=>0)){
		$sql=$this->db->insert_string('problem',$problem_array);
		$this->db->query($sql);
	}

/**
get_user_item 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
*/
	public function get_user_item($id,$column_array=array('userId','name','email','password')){
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
		//return $sql;
	}

/**
get_user_state_item获取user_state信息函数通过id
*/

	public function get_user_state_item($id,$column_array=array('accessTime','submit','solved')){
		$sql="SELECT ".implode(" , ",$column_array)." FROM user_state WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}

/**
get_user_all_item获取user和user_state信息函数通过id
*/
	public function get_user_all_item($id,$user_column_array=array('userId','name','email','password'),$user_state_column_array=array('accessTime','submit','accepted')){
		for($i=0 ; $i<count($user_column_array) ; $i++){
			$user_column_array[$i]="user.".$user_column_array[$i];
		}
		for($i=0 ; $i<count($user_state_column_array) ; $i++){
			$user_state_column_array[$i]="user_state.".$user_column_array[$i];
		}
		$sql="SELECT ".implode(" , ",$user_column_array)." , ".implode(" , ",$user_state_column_array)." FROM user INNER JOIN user_state ON user.userId = user_state.userId WHERE user.userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}

/**
add_user增加user和user_state
user_array给出要插入的user表的列和值
user_state_array给出要插入的user_state表的列和值
*/

/**
	public function add_user($user_array=array('name'=>"name",'email'=>"example@qq.com",'password'=>"123456"),$user_state_array=array('submit'=>0,'solved'=>0)){
		$user_sql = $this->db->insert_string('user', $user_array); 
		$user_state_sql = $this->db->insert_string('user_state', $user_state_array);
		$this->db->query($user_sql);
		$query=$this->db->query("SELECT userId FROM user WHERE name = ".$this->db->escape($user_array['name'])."");
		$row=$query->row_array(0);
		$user_state_array['userId']=$row['userId'];
		$this->db->query($user_state_sql);
	}
*/
}