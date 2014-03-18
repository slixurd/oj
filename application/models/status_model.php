<?php 

class Status_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	/*
	 * 获取所有solution个数，返回count 数字
	 */
	public function get_status_count(){
		$sql = "SELECT count(solutionId) as count FROM solution";
		$query = $this->db->query($sql);
		$column_array = $query->row_array(0);
		return $column_array['count'];
	}
	
	/*
	 * 获取status列表
	 */
	 
	public function get_status_list($limit_from,$limit_row){
		$this->db->escape($limit_from);
		$this->db->escape($limit_row);
		$sql = "SELECT inDate,user.name,solutionId , solution.userId , problemId , result, memory ,runTime , solution.programLan , codeLen
				FROM solution LEFT JOIN user ON user.userId = solution.userId 
				ORDER BY inDate desc LIMIT ".$limit_from." , ".$limit_row;
		$query = $this->db->query($sql);
		$column_array = $query->result_array();
		return $column_array;
	}
	
	/*
	 * 获取用户status列表
	 */
	 
	public function get_status_user($userId){
		$userId = $this->db->escape($userId);
		$sql = "SELECT solutionId , problemId , result, memory ,runTime , programLan , codeLen
				FROM solution  WHERE userId = ".$userId." ORDER BY inDate desc";
		$query = $this->db->query($sql);
		$column_array = $query->result_array();
		return $column_array;
	}
	
	/*
	 * 获取答案的答案通过solutionId，可以用户ajax,返回-2代表没有找到
	 */
	public function get_most_recent($userId){
		$userId = $this->db->escape($userId);
		$sql = "SELECT solutionId
				FROM solution  WHERE userId = ".$userId." ORDER BY inDate desc limit 1";
		$query = $this->db->query($sql);
		$column_array = $query->row_array(0);
		return $column_array;
	}	 
	
	public function get_solution_result($solutionId){
		$solutionId = $this->db->escape($solutionId);
		$sql = "SELECT result , runTime , judgeTime FROM solution WHERE solutionId = ".$solutionId;
		$query = $this->db->query($sql);
		$result = -2;
		$column_array = $query->row_array(0);
		if(!empty($column_array))
			$result = $column_array['result'];
		return $result;
	}
}
	 
