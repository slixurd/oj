<?php 

class Contest_edit extends CI_Model 
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
	
	public function get_contest_count()
	{
		$sql = "SELECT COUNT(contestId) as num
				FROM contest LEFT JOIN user ON contest.userId = user.userId";
		$query = $this->db->query($sql);
		$q = $query->row_array();
		return $q['num'];
	}
	
	public function get_contest_list($limit_from,$limit_row)
	{
		$limit_from = $this->db->escape($limit_from);
		$limit_row = $this->db->escape($limit_row);
		$sql = "SELECT  contestId , contest.userId , contest.title as contestTitle,startTime ,endTime,private, user.name 
				FROM contest LEFT JOIN user ON contest.userId = user.userId 
				LIMIT ".$limit_from." , ".$limit_row;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(empty($result))
			return false;
		return $result;
	}
	
	function add_contest($userId,$title,$startTime,$endTime,$private,$defunct = 0){
		Global $pri;
		$column_array = array('userId'=>$userId,'title'=>$title,'startTime'=>$startTime,'endTime'=>$endTime,'private'=>$private,'defunct'=>$defunct);
		$this->db->insert("contest",$column_array);
		$affect = $affect = $this->db->affected_rows();
		if($affect <= 0)
			return false;
		$contestId = $this->db->insert_id();
		$privilege_array = array('userId'=>$userId,'commonId'=>$contestId,'common'=>"contest");
		foreach($pri as $pri_type){
			$privilege_array['privilege'] = $pri_type;
			$this->db->insert('privilege_common',$privilege_array);
		}
		return $contestId;
	}
	
	public function add_contest_problem($contestId,$problemId)
	{
		echo "hello";
		$sql = "SELECT count(problemId) as count FROM problem WHERE problemId = ".$this->db->escape($problemId);
		$query = $this->db->query($sql);
		$count = $query->row_array(0);
		echo "hello";
		if($count['count'] <= 0 || empty($count))
			return false;
		$column_array = array('contestId'=>$contestId,'problemId'=>$problemId);
		$this->db->insert('contest_problem',$column_array);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	} 
	
	public function add_contest_privilege($contestId,$userId,$kind){
		$contestId = $this->db->escape($contestId);
		$userId = $this->db->escape($userId);
		$kind = $this->db->escape($kind);
		$common = "contest";
		$common = $this->db->escape($common);
		$sql = "INSERT INTO privilege_common(common,userId,commonId,privilege) 
		 VALUES(".$common.",".$userId.",".$contestId.",".$kind.")";
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function del_contest($contestId){
		$contestId = $this->db->escape($contestId);
		$sql = "DELETE FROM privilege_common WHERE common = 'contest' AND commonId = ".$contestId;
		$this->db->query($sql);
		$sql = "DELETE FROM contest WHERE contestId = ".$contestId;
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function del_contest_problem($contestId,$problemId){
		$contestId = $this->db->escape($contestId);
		$problemId = $this->db->escape($problemId);
		$sql = "DELETE FROM contest_problem WHERE contestId = ".$contestId." AND problemId = ".$problemId;
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function get_contest_problem_list($contestId)
	{
		$contestId = $this->db->escape($contestId);
		$sql = "SELECT contestId , contest_problem.problemId , problem.title , problem.accepted , problem.submit 
				FROM contest_problem LEFT JOIN problem ON contest_problem.problemId = problem.problemId 
				WHERE contest_problem.contestId =  ".$contestId;
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		if(empty($result))
			return false;
		return $result;
	}
	
	public function get_user_contest_list($userId,$limit_from,$limit_row){
		$userId = $this->db->escape($userId);
		$sql = "SELECT type FROM user WHERE userId = ".$userId;
		$query=$this->db->query($sql);
		$type = $query->row_array(0);
		$type = $type['type'];
		//echo $type;
		if($type == "admin"){
			return $this->get_contest_list($limit_from,$limit_row);
		}else{
			$sql = "SELECT contestId , contest.userId , contest.title as contestName,startTime ,endTime,private, user.name 
				FROM contest LEFT JOIN user ON contest.userId = user.userId WHERE contestId  IN
				(SELECT distinct(commonId) FROM privilege_common WHERE userId =  ".$userId." AND common = 'contest' AND privilege = 'edit') 
				LIMIT ".$limit_from." , ".$limit_row;
				//echo $sql;
			$query = $this->db->query($sql);
			$result =  $query->result_array();
			if(empty($result))
				return false;
			return $result;
		}
		return false;
	}
}
