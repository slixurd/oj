<?php 

/**
 *所有oj model函数均在此类当中
 *get函数不特别强调都以数组返回，后缀list返回二维数字集，后缀item返回一维数组
 */

class Oj_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}

/**
 *get_problem_list()给定参数的问题列表
 *$is_search指名是否启用where查询，$column_array数组指明想要获取的problem列
 *$where_str为where处的条件字符串，如"problemId > 9999"用此参数时请先对相关数据用转义，再传进来
 *oder_by指示依据什么来排序，默认problem_id,$is_desc是否采用逆序，$limit取多少列
 *is_defunct指出是否取屏蔽题目
 */


	public function get_problem_list($column_array=array('problemId','title','source','accepted','submit'),
	$order_by="problemId",$is_desc=FALSE,$limit=NULL,$is_defunct=FALSE)
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
 *get_problem_list_where可以通过where_str写where给定条件
 *参数参考上面的函数多了where类似，多了一个where_str少了$defunct
 */

	public function get_problem_list_where($column_array=array('problemId','title','source','accepted','submit'), 
	$order_by="problemId",$is_desc=FALSE,$where_str="defunct = 0",$limit=NULL)
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
 *get_problem_item 按照id和指定列获取某个问题
 */


	public function get_problem_item($id,$column_array=array('problemId','title','source','accepted','submit'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM problem WHERE problemId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}

/**
 *add_problem
 *problem_array给出要插入的列和值
 * 返回problemId
 */

	public function add_problem($problem_array=array('title'=>"A+B",'defunct'=>0))
	{
		$this->db->insert('problem',$problem_array);
		$problemId=$this->db->insert_id();
		return $problemId;
	}

/**
 *get_user_item_name 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
 */
	public function get_user_item_id($id,$column_array=array('userId','name','email','password'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
		return $sql;
	}
	
	
/**
 *获取用户list通过where语句
 */
	public function get_user_list($user_array=array('userId','name','nick'),$state_array=array('solved','accepted'),
	$order_by="solved",$is_desc=FALSE,$limit = "no data")
	{
		for($i=0;$i<count($user_array);$i++){
			$user_array[$i]="user.".$user_array[$i];
		}
		for($i=0;$i<count($state_array);$i++){
			$state_array[$i]="state_array.".$state_array[$i];
		}
		$sql="SELECT ".implode(" , ",$user_array)." , ".implode(" , ",$state_array)." FROM user INNER JOIN user_state ON user.userId =
		 user_state.userId ORDER BY ".$this->db->escape($order_by)." ";
		if(is_numeric($limit)){
			$sql=$sql.$limit;
		}
	}
	
	
/**
 *获取用户list
 */
	public function get_user_list_where($user_array=array('userId','name','nick'),$state_array=array('solved','accepted'),
	$order_by="solved",$is_desc=FALSE,$where_str="defunct = 0",$limit = "no data")
	{
		for($i=0;$i<count($user_array);$i++){
			$user_array[$i]="user.".$user_array[$i];
		}
		for($i=0;$i<count($state_array);$i++){
			$state_array[$i]="state_array.".$state_array[$i];
		}
		$sql="SELECT ".implode(" , ",$user_array)." , ".implode(" , ",$state_array)." FROM user INNER JOIN user_state ON user.userId =
		 user_state.userId ORDER BY ".$this->db->escape($order_by)." WHERE ".$where." ";
		if(is_numeric($limit)){
			$sql=$sql.$limit;
		}
	}
			

/**
 *get_user_item_id 按照id获取指定用户基本信息不包含用户state(submmit，accept这类)信息
 */
	public function get_user_item_name($name,$column_array=array('userId','name','email','password'))
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM user WHERE name = ".$this->db->escape($name)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
		//return $sql;
	}

/**
 *get_user_state_item获取user_state信息函数通过id
 */

	public function get_user_state_item($id,$column_array=array('accessTime','submit','solved')){
		$sql="SELECT ".implode(" , ",$column_array)." FROM user_state WHERE userId = ".$this->db->escape($id)."";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}

/**
 *get_user_all_item获取user和user_state信息函数通过id
 */
	public function get_user_all_item($id,$user_column_array=array('userId','name','email','password'),$user_state_column_array=array('accessTime','submit','accepted'))
	{
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
 *add_user增加user和user_state
 *user_array给出要插入的user表的列和值
 *user_state_array给出要插入的user_state表的列和值
 *以事务的方式进行提交
 * 返回userId
 */


	public function add_user($user_array=array('name'=>"name",'email'=>"example@qq.com",'password'=>"123456"),$user_state_array=array('submit'=>0,'solved'=>0))
	{
		$this->db->trans_start();
		$this->db->insert('user',$user_array);
		$userId=$this->db->insert_id();
		$user_state_array['userId']=$userId;
		$this->db->insert('user_state',$user_state_array);
		$this->db->trans_complete();
		return $userId;
	}
	
/**
 * 根据所给的列数组更改user信息
 * 请先对where的相关数据进行转义
 */
	public function update_user($column_array=array('nick'=>"helloc",'school'=>"scut"),$where_str="userId = 1")
	{
		$sql=$this->db->update_string('user',$column_array,$where_str);
		$query=$this->db->query($sql);
	}
	
/**
 *根据所给的列信息和where字符串更爱user_state信息
 * 请先对where的相关数据进行转义
 */
	public function update_user_state($column_array=array('solved'=>0,'accepted'=>0),$where_str="userId = 1")
	{
		$sql=$this->db->update_string('user_state',$column_array,$where_str);
		$query=$this->db->query($sql);
	}
	
/**
 *删除指定id的user，由于破坏力太强大，现在只提供id删除
 */
 
	public function delete_user_id($id)
	{
		if(is_numeric($id)){
			$sql="DELETE FROM user WHERE userId = ".$this->db->escape($id)." ";
			$this->db->query($sql);
			$sql="DELETE FROM user_state WHERE userId = ".$this->db->escape($id)." ";
			$this->db->query($sql);
		}
	}
	
	
/**
 * 函数插入一条contest记录
 * column_array表示要插入的列名及其函数
 * 注意id不需要添加的
 * 返回插入的自增contestId
 */
 
	public function add_contest($column_array=array('title'=>"title",'defunct'=>0,'private'=>0,'language'=>"C++"))
	{
		$this->db->insert('contest',$column_array);
		$contestId=$this->db->insert_id();
		return $contestId;
	}
	
/**
 * 获取指定条件的contest数组
 * $column_array指定要获取的列，$where_str为where条件，传递where_str之前保证相关数据转义
 * 函数返回满足指定条件的二维数组
 */
	
	public function get_contest_list_where($column_array=array('contestId','title','startTime','endTime','defunct','private'),$where_str="(now() BETWEEN startTime AND endTime) AND defunct = 0")
	{
		$sql="SELECT ".implode(" , ",$column_array)." FROM contest WHERE ".$where_str." ";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
/**
 * 插入contest_problem
 * 无返回
 */
	
	public function add_contest_problem($column_array=array('contestId'=>1,'problemId'=>10026,'title'=>"title",'num'=>1))
	{
		$this->db->insert('contest_problem',$column_array);
	}
	
/**
 * 获取给定contestId的problem列表和contest_problem的序号
 * contestId表示为想要获取的contestId，$contest_problem_array和problem分别表示为想要获取的contest_problem和problem列
 * 函数返回二维数组
 */
 
	public function get_contest_problem_list($contestId="1000",$contest_problem_array=array('contestId','problemId','num'),$problem_array=array('problemId','title','source','accepted','submit'))
	{
		$sql="SELCET ";
		for($i=0;$i<count($contest_problem_array);$i++){
			$contest_problem_array[$i]="contest_problem.".$contest_problem_array[$i];
		}
		for($i=0;$i<count($problem_array);$i++){
			$problem_array[$i]="problem.".$problem_array[$i];
		}
		$sql="SELECT ".implode(" , ",$contest_problem_array)." , ".implode(" , ",$problem_array)." FROM contest_problem INNER JOIN problem ON contest_problem.problemId = problem.problemId WHERE contest_problem.contestId = ".$this->db->escape($contestId)." ";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
 

	
/**
 * 插入contest_privilege
 * 无返回
 */
 
	public function add_contest_privilege($column_array=array('contestId'=>1,'userId'=>1,'priType'=>"student"))
	{
		$this->db->insert('contest_privilege',$column_array);
	}
	
/**
 * get_contest_privilege获取指定id contest的权限列表
 */
 
	public function get_contest_privilege($contestId,$userId)
	{
		$sql="SELECT priType FROM contest_privilege WHERE contestId = ".$this->db->escape($constestId,$userId)." AND userId = ".$this->db->escape($userId)." ";
		$query=$this->db->query($sql);
		return $query->array_result();
	}
	
	
/**
 * 插入solution和solution_code作为事物提交
 * solution_array给出solution的列名和值code_array给出solution_code的
 * 返回刚刚插入的solutionId
 */

	public function add_solution($solution_array=array('problemId'=>10000,'userId'=>1,'runTime'=>0,'memory'=>0,'result'=>0,'programLan'=>"C++",'contestId'=>1,'unitId'=>1,'valid'=>0),$code_array=array('code'=>"it is a test"))
	{
		$this->db->trans_start();
		$this->db->insert('solution',$solution_array);
		$solutionId=$this->db->insert_id();
		$code_array['solutionId']=$solutionId;
		$this->db->insert('solution_code',$code_array);
		$this->db->trans_complete();	
		return $solutionId;
	}
		
}
