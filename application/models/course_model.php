<?php

class Course_model extends CI_Model
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
	 * 获取课程数量方便分页
	 * 返回一个整数
	 */

	public function get_course_count()
	{
		$sql = "SELECT COUNT(courseId) as num
				FROM course LEFT JOIN user ON course.userId = user.userId";
		$query = $this->db->query($sql);
		$q = $query->row_array();
		return $q['num'];
	}
	
	/*
	 * 获知课程是否私有，true私有，false公开
	 */
	 public function is_private($courseId){
		$courseId = $this->db->escape($courseId);
		$sql = "SELECT * FROM course WHERE courseId = ".$courseId." AND private = 1 ";
		$query = $this->db->query($sql);
		$column_array = $query->row_array(0);
		if(isset($column_array['private'])&&($column_array['private']== 0))
			return FALSE; 
		return TRUE;
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
		$sql = "SELECT courseId , course.userId , course.name as courseName ,
					startTime ,endTime,private, course.programLan ,	user.name 
				FROM course LEFT JOIN user ON course.userId = user.userId 
				LIMIT ".$limit_from." , ".$limit_row;
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
		$sql = "SELECT unitId , courseId , title ,startTime , endTime FROM course_unit
				WHERE courseId = ".$courseId;
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
		$sql = "SELECT courseId , course.userId , course.name as courseName ,
					startTime ,endTime,private, course.programLan, user.name 
				FROM course LEFT JOIN user ON course.userId = user.userId 
				WHERE courseId = ".$courseId;
		$query = $this->db->query($sql);
		return $query->row_array(0);
	}
	
	/*
	 * 获取用户课程权限列表
	 * 返回值为二维数组返回用户对改题目持有的所有权限
	 */
	 
	public function get_course_privilege($courseId,$userId,$kind)
	{
		$userId = $this->db->escape($userId);
		$coursetId = $this->db->escape($courseId);
		$sql = "SELECT * FROM privilege_common 
				WHERE common = 'course' AND userId = ".$userId." AND commonId = ".$courseId;
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $pri_type) {
			if($kind == $pri_type['privilege'])
				return TRUE;
		}
		return FALSE;
	}
	
	
	/*
	 * add_course函数插入课程和课程权限,$private 0为私有，1为公开，一般设为私有就好
	 * 返回插入的课程id
	 */
	 
	public function add_course($userId,$name,$startTime,$endTime,$private,$programLan)
	{
		Global $pri;
		$defunct = 0;
		$column_array = array('userId'=>$userId,'name'=>$userId,'startTime'=>$startTime,'endTime'=>$endTime,'private'=>$private,
		'defunct'=>$defunct,'programLan'=>$programLan);
		$userId = $column_array['userId'];
		$this->db->insert('course',$column_array);
		$courseId = $this->db->insert_id();
		$privilege_array = array('userId'=>$userId,'commonId'=>$courseId,'common'=>"course");
		foreach($pri as $pri_type){
			$privilege_array['privilege'] = $pri_type;
			$this->db->insert('privilege_common',$privilege_array);
		}
		return $courseId;
	}
	
	/*
	 * add_course_unit添加课程单元,请注意检查用户权限
	 * 返回unitId
	 */
	 
	public function add_course_unit($courseId,$title)
	{
		$column_array = array('courseId'=>$courseId,'title'=>$title);
		$this->db->insert('course_unit',$column_array);
		return $this->db->insert_id();
	}
	
	/*
	 * 添加单元问题
	 */
	 
	public function add_unit_problem($unitId,$problemId)
	{
		$column_array = array('unitId'=>$unitId,'problemId'=>$problemId);
		$this->db->insert('unit_problem',$column_array);
	}
	
	/*
	 * 获取单元课程列表
	 */
	 
	public function get_unit_problem_list($unitId)
	{
		$unitId = $this->db->escape($unitId);
		$sql = "SELECT unitId , unit_problem.problemId , problem.title , problem.accepted , problem.submit 
				FROM unit_problem LEFT JOIN problem ON unit_problem.problemId = problem.problemId 
				WHERE unit_problem.unitId =  ".$unitId;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
	 * 获取单元id对应的课程id,返回-1代表没找到对应关系
	 */
	public function get_unit_course_id($unitId)
	{
		$unitId = $this->db->escape($unitId);
		$sql = "SELECT course_unit.courseId FROM course_unit LEFT JOIN unit_problem
				ON course_unit.unitId = unit_problem.unitId WHERE course_unit.unitId = ".$unitId;
		$query = $this->db->query($sql);
		$course_array = $query->row_array(0);
		if(!isset($course_array['courseId'])||!is_numeric($course_array['courseId']))
			return -1;
		else
			return $course_array['courseId'];
	}
	
}
