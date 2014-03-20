<?php 

class Problem_edit extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * 给定问题信息，添加问题
	 * 函数返回插入后的问题id
	 */
	
	public function add_problem($problem_array = array('title'=>"A+B",'description'=>'','defunct'=>0)){
		$this->db->insert('problem',$problem_array);
		$problemId = $this->db->insert_id();
		return $problemId;
	}
	
	/*
	 * 获取问题列表
	 */
	 
	public function get_problem_list($limit_from=NULL,$limit_row=NULL)
	{
		$sql="SELECT problemId , title , inDate , defunct FROM problem ORDER BY problemId";
		$query=$this->db->query($sql);
		return $query->result_array();
	} 
	
	/*
	 * 获取问题个数
	 */
	 
	public function get_count(){
		$sql = "SELECT count(problemId) as count FROM problem";
		$query=$this->db->query($sql);
		return $query->row_array(0);
	}
	
	/*
	 * 用problemId删除问题
	 */
	public function del_problem($problemId){
		$problemId = $this->escape($problemId);
		$sql = "DELETE FROM problem WHERE problemId = ".$problemId;
		$this->db->query($sql);
	}
	
	/*
	 * 编辑问题
	 */
	 
	public function update_problem($problemId,$column_array = array('title'=>"hello")){
		$problemId = $this->db->escape($problemId);
		$where = "problemId = ".$problemId;
		$this->db->update('problem', $column_array, $where);
	}
}
