<?php

class Contest_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		Global $pri ;
		$pri['read'] = "read";
		$pri['submit'] = "submit";
		$pri['add'] = "add";
		$pri['edit'] = "edit";
		$pri['del'] = "del";
		//用之前请先声明Global $pri
	}
	
	/*
	 * 获知禁赛是否私有，true私有，false公开
	 */
	 public function is_private($contestId){
		$contestId = $this->db->escape($contestId);
		$sql = "SELECT * FROM contest WHERE contestId = ".$contestId." AND private = 1 ";
		$query = $this->db->query($sql);
		if(empty($query->result_array()))
			return FALSE;
		return TRUE;
	 }
	
	/*
	 * 获取竞赛问题是否存在
	 */
	public function is_contest_problem($contestId,$problemId){
		$contestId = $this->db->escape($contestId);
		$problemId = $this->db->escape($problemId);
		$sql = "SELECT * FROM contest_problem WHERE contestId = ".$contestId." AND problemId = ".$problemId;
		$query = $this->db->query($sql);
		if(empty($query->result_array()))
			return FALSE;
		return TRUE;
	}
	
	/*
	 * 获取用户是否具有相关权限
	 */
	public function get_contest_privilege($contestId,$userId,$kind){
		$userId = $this->db->escape($userId);
		$coursetId = $this->db->escape($contestId);
		$kind = $this->db->escape($kind);
		$sql = "SELECT * FROM privilege_common 
				WHERE common = 'contest' AND userId = ".$userId." AND commonId = ".$contestId.
				" AND privilege = ".$kind;
		$query = $this->db->query($sql);
		if(empty($query->result_array()))
				return FALSE;
		return TRUE;
	}
	
	/*
	 * 获取用户相关竞赛权限列表
	 */
	 
	public function get_contest_privilege_list($contestId,$userId)
	{
		$userId = $this->db->escape($userId);
		$contestId = $this->db->escape($contestId);
		$sql = "select * from privilege_common where common = 'contest' and userId = ".$userId." and commonId = ".$contestId;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	* 获取给定contestId的problem列表和contest_problem的序号
	* contestId表示为想要获取的contestId，$contest_problem_array和problem分别表示为想要获取的contest_problem和problem列
	* 函数返回二维数组
	*/
	public function get_contest_problem_list($contestId=1000,$contest_problem_array=array('contestId','problemId','num'),
	$problem_array=array('problemId','title','source','accepted','submit'),$order_by="contest_problem.num",$is_desc=FALSE,
	$limit_from=0,$limit_row=10)
	{
		for($i=0;$i<count($contest_problem_array);$i++){
			$contest_problem_array[$i]="contest_problem.".$contest_problem_array[$i];
		}
		for($i=0;$i<count($problem_array);$i++){
			$problem_array[$i]="problem.".$problem_array[$i];
		}
		$sql="SELECT ".implode(" , ",$contest_problem_array)." , ".implode(" , ",$problem_array).
		" FROM contest_problem INNER JOIN problem ON contest_problem.problemId = problem.problemId WHERE 
		contest_problem.contestId = ".$this->db->escape($contestId)." ";
		$sql=$sql." ORDER BY ".$order_by." ";
		if($is_desc===TRUE)
		$sql=$sql." DESC ";
		$sql=$sql." LIMIT ".$limit_from." , ".$limit_row." ";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
}
