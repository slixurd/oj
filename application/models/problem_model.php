<?php 

class Problem_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * 给定问题信息，添加问题
	 * 函数返回插入后的问题id
	 */
	
	public function add_problem($problem_array = array('title'=>"A+B",'defunct'=>0)){
		$this->db->insert('problem',$problem_array);
		$problemId = $this->db->insert_id();
		return $problemId;
	}
	
	
	/**
	* update_problem 根据数组$probelm_array给定的参数，where_str参数
	*/
	
	public function update_problem($problem_array=array('title'=>"hello"),$where_str="problemId < 10000")
	{
		$this->db->update_string('problem',$problem_array,$where_str);
		$this->db->query($sql);
	}
	
}
