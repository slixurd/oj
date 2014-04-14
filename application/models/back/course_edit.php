<?php 

class Course_edit extends CI_Model 
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
	
	public function get_course_count()
	{
		$sql = "SELECT COUNT(courseId) as num
				FROM course LEFT JOIN user ON course.userId = user.userId";
		$query = $this->db->query($sql);
		$q = $query->row_array();
		return $q['num'];
	}
	
	public function get_course_list($limit_from,$limit_row)
	{
		$limit_from = $this->db->escape($limit_from);
		$limit_row = $this->db->escape($limit_row);
		$sql = "SELECT courseId , course.userId , course.name as courseName,startTime ,endTime,private, user.name 
				FROM course LEFT JOIN user ON course.userId = user.userId 
				LIMIT ".$limit_from." , ".$limit_row;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function del_course($courseId){
		$courseId = $this->db->escape($courseId);
		$sql = "DELETE FROM course WHERE courseId = ".$courseId;
		$this->db->query($sql);
	}
	
	public function get_course_unit_list($courseId)
	{
		$courseId = $this->db->escape($courseId);
		$sql = "SELECT unitId , courseId , title ,startTime , endTime FROM course_unit
				WHERE courseId = ".$courseId;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	 
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
	
	public function add_unit($courseId,$title,$startTime,$endTime){
		$courseId = $this->db->escape($courseId);
		$startTime = $this->db->escape($startTime);
		$endTime = $this->db->escape($endTime);
		$title = $this->db->escape($title);
		$sql = "INSERT INTO course_unit(courseId,title,startTime,endTime) VALUES(".$courseId.",".$title.",".$startTime.",".$endTime.")";
		$this->db->query($sql);
		$unitId = $this->db->insert_id();
		return $unitId;
	}
	
	/*
	 * 添加单元问题
	 */
	 
	public function add_unit_problem($unitId,$problemId)
	{
		$column_array = array('unitId'=>$unitId,'problemId'=>$problemId);
		$this->db->insert('unit_problem',$column_array);
	} 
	
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
	
	public function add_course_privilege($courseId,$userId,$kind){
		$courseId = $this->db->escape($courseId);
		$userId = $this->db->escape($userId);
		$kind = $this->db->escape($kind);
		$common = "common";
		$sql = "INSERT INTO privilege_common(common,userId,commonId,privilege) 
		 VALUES(".$common.",".$userId.",".$courseId.",".$kind.")";
		$this->db->query($sql);
	}
	
}
