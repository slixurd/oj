<?php

class Course_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	
	/*
	 * 获取课程列表
	 * 这里limit_from 表示从第几行开始选取，limit_row 表示取几行，主要是分页可能会用到这个参数
	 * 返回二维数组
	 */
	 
	public function get_course_list($limit_from,$limit_row)
	{
		$limit_from = $this->db->escape($limit_from);
		$limit_row = $this->db->escape($limit_row);
		$sql = "SELECT courseId , course.userId , course.name as courseName ,begainTime ,endTime,private, course.programLan ,
			user.name FROM course LEFT JOIN user ON course.userId = user.userId LIMIT ".$limit_from." , ".$limit_row;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
	 * 获取课程单元列表
	 * 参数为课程id
	 * 返回值为二维数组
	 */
	
	public function get_course_unit_list($courseId)
	{
		$courseId = $this->db->escape($courseId);
		$sql = "SELECT unitId , courseId , title FROM course_unit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
	 * 获取课程基本信息
	 * 返回值为一维数组，由于课程的name和user的name列名相同，课程name被as为coursename
	 */
	public function get_course_item($courseId)
	{
		$courseId = $this->db->escape($courseId);
		$sql = "SELECT courseId , course.userId , course.name as courseName ,begainTime ,endTime,private, course.programLan, 
			user.name FROM course LEFT JOIN user ON course.userId = user.userId WHERE courseId = ".$courseId;
		$query = $this->db->query($sql);
		return $query->row_array(0);
	}
	
	/*
	 * 获取用户课程权限列表
	 * 返回值为二维数组返回用户对改题目持有的所有权限
	 */
	 
	public function get_course_privilege($courseId,$userId)
	{
		$userId = $this->db->escape($userId);
		$coursetId = $this->db->escape($courseId);
		$sql = "SELECT * FROM privilege_common WHERE common = 'course' AND userId = ".$userId." AND commonId = ".$courseId;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
}
