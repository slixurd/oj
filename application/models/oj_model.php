<?php 

/**
所有oj model函数均在此类当中
get函数不特别强调都以数组返回，后缀list返回二维数字集，后缀item返回一维数组
*/

class Oj_model extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

/**
get_problem_list()给定参数的问题列表
$is_search指名是否启用where查询，$column_array数组指明想要获取的problem列
$where_str为where处的条件字符串，如"problemId > 9999"用此参数时请先对相关数据用转义，再传进来
oder_by指示依据什么来排序，默认problem_id,$is_desc是否采用逆序，$limit取多少列
is_defunct指出是否取屏蔽题目
*/


	public function get_problem_list($column_array=array('problemId','title','source','accepted','submit'),$order_by="problemId",$is_desc=FALSE,$limit=NULL,$is_defunct=FALSE)
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM problem ";
		if($is_defunct == FALSE){
			$sql=$sql."WHERE defunct = 0 ";
		}
		else{
			$sql=$sql."WHERE defunct = 1 ";
		}
		if($is_desc == FALSE){
			$sql=$sql."ORDER BY ".$this->db->escape($order_by)." ";
		}
		else{
			$sql=$sql."ORDER BY ".$this->db->escape($order_by)." DESC ";
		}
		if(is_numeric($limit) && ($limit >= 0)){
			$sql=$sql."LIMIT ".$this->db->escape($limit)."";
		}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
		/**
get_problem_list_where可以通过where_str写where给定条件
参数参考上面的函数多了where类似，多了一个where_str少了$defunct
*/

	public function get_problem_list_where($column_array=array('problemId','title','source','accepted','submit'), $order_by="problemId",$is_desc=FALSE,$where_str="defunct = 0",$limit=NULL)
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM problem ";
		$sql=$sql.$where_str;
		if($is_desc == FALSE){
			$sql=$sql."ORDER BY ".$this->db->escape($order_by)." ";
		}
		else{
			$sql=$sql."ORDER BY ".$this->db->escape($order_by)." ";
		}
		if(is_numeric($limit) && ($limit >= 0)){
			$sql=$sql."LIMIT ".$this->db->escape($limit)."";
		}
		$query=$this->db->query($sql);
		return $query->result_array();
	}


/**
get_problem_item 按照id和指定列获取某个问题
*/


	public function get_problem_item($id,$column_array=array('problemId','title','source','accepted','submit'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM problem WHERE problemId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}

/**
add_problem
problem_array给出要插入的列和值
*/

	public function add_problem($problem_array=array('title'=>"A+B",'defunct'=>0))
	{
		$this->db->insert('problem',$problem_array);
	}

/**
get_user_item_name 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
*/
	public function get_user_item_id($id,$column_array=array('userId','name','email','password'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
		return $sql;
	}

/**
get_user_item_id 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
*/
	public function get_user_item_name($name,$column_array=array('userId','name','email','password'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE name = ".$this->db->escape($name)."";
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
以事务的方式进行提交
*/


	public function add_user($user_array=array('name'=>"name",'email'=>"example@qq.com",'password'=>"123456"),$user_state_array=array('submit'=>0,'solved'=>0)){
		$this->db->trans_start();
		$this->db->insert('user',$user_array);
		$query=$this->db->query("SELECT userId FROM user WHERE name = ".$this->db->escape($user_array['name'])."");
		$row=$query->row_array(0);
		$user_state_array['userId']=$row['userId'];
		$this->db->insert('user_state',$user_state_array);
		$this->db->trans_complete();
	}



}