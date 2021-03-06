<?php 

class Course_edit extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
		Global $pri ;
		$pri['read'] = "read";
		$pri['submit'] = "submit";
		$pri['edit'] = "edit";
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
		$result = $query->result_array();
		if(empty($result))
			return false;
		return $result;
	}
	
	public function del_course($courseId){
		$courseId = $this->db->escape($courseId);
		$sql = "DELETE FROM privilege_common WHERE common = 'course' AND commonId = ".$courseId;
		$this->db->query($sql);
		$sql = "DELETE FROM course WHERE courseId = ".$courseId;
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function update_course($courseId,$course_array){
		$this->db->where('courseId', $courseId);
		$this->db->update('course', $course_array); 
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function update_unit($unitId,$unit_array){
		$unitId = $this->db->escape($unitId);
		//where的第一个字符一定不能为空格,否则会生成 WHERE ` unitId = 'xxx';这样的错误
		$where = "unitId = ".$unitId;
		$this->db->update('course_unit', $unit_array, $where); 
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function update_course_teacher($courseId,$userId){
		$courseId = $this->db->escape($courseId);
		$userId = $this->db->escape($userId);
		$sql ="SELECT userId FROM course WHERE courseId = ".$courseId;
		$query = $this->db->query($sql);
		$old_user = $query->row_array(0);
		$old_user = $old_user['userId'];
		$course_array = array('userId'=>$userId);
		$this->db->update('course', $course_array,'courseId = '.$courseId); 
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0){
			$sql ="DELETE FROM privilege_common WHERE common = 'course' AND commonId = ".$courseId." AND userId = ".$old_user;
			$this->db->query($sql);
			Global $pri;
			foreach($pri as $privilege)
				$this->db->insert("privilege_common",array('userId'=>$userId,'common'=>"course",'commonId'=>$courseId,'privilege'=>$privilege));
		}else
			return false;
		return true;
	}
	
	public function get_course_unit_list($courseId)
	{
		$courseId = $this->db->escape($courseId);
		$sql = "SELECT unitId , courseId , title ,startTime , endTime FROM course_unit
				WHERE courseId = ".$courseId;
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		if(empty($result))
			return false;
		return $result;
	}
	
	 
	public function get_unit_problem_list($unitId)
	{
		$unitId = $this->db->escape($unitId);
		$sql = "SELECT unitId , unit_problem.problemId , problem.title , problem.accepted , problem.submit 
				FROM unit_problem LEFT JOIN problem ON unit_problem.problemId = problem.problemId 
				WHERE unit_problem.unitId =  ".$unitId;
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		if(empty($result))
			return false;
		return $result;
	}
	
	/*
	 * add_course函数插入课程和课程权限,$private 0为私有，1为公开，一般设为私有就好
	 * 返回插入的课程id
	 */
	 
	public function add_course($userId,$title,$description,$startTime,$endTime,$private,$programLan)
	{
		Global $pri;
		$defunct = 0;
		$column_array = array('userId'=>$userId,'name'=>$title,'startTime'=>$startTime,'endTime'=>$endTime,'private'=>$private,
		'defunct'=>$defunct,'programLan'=>$programLan, 'description'=>$description);
		$userId = $column_array['userId'];
		$this->db->insert('course',$column_array);
		$courseId = $this->db->insert_id();
		$privilege_array = array('userId'=>$userId,'commonId'=>$courseId,'common'=>"course");
		foreach($pri as $pri_type){
			$privilege_array['privilege'] = $pri_type;
			$this->db->insert('privilege_common',$privilege_array);
		}
		if (!is_numeric($courseId)) {
			return false;
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
		$sql = "SELECT count(problemId) as count FROM problem WHERE problemId = ".$this->db->escape($problemId);
		$query = $this->db->query($sql);
		$count = $query->row_array(0);
		if($count['count'] <= 0 || empty($count))
			return false;
		$column_array = array('unitId'=>$unitId,'problemId'=>$problemId);
		$this->db->insert('unit_problem',$column_array);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	} 
	
	public function add_course_user($stu_num,$pass,$courseId){
		$CI = &get_instance();
		$CI->load->model("back/user_edit","user_edit");
		$CI->load->library('encrypt');
		$salt = $CI->user_edit->salt();
		$pass = $this->encrypt->sha1($salt.$pass);
		$user_array=array('name'=>$stu_num,'email'=>$stu_num."@example.com",'password'=>$pass,'salt'=>$salt);
		
		if($CI->user_edit->unique_user($user_array['name']) && $CI->user_edit->unique_email($user_array['email']))
			$id = $CI->user_edit->add_user($user_array);
		else
			$id = $CI->user_edit->get_id_by_name($stu_num);
			
		echo "hehe";

		$this->add_course_privilege($courseId,$id,"read");
		$this->add_course_privilege($courseId,$id,"submit");
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function del_course_privilege($courseId,$userId){
		$courseId = $this->db->escape($courseId);
		$userId = $this->db->escape($userId);
		$sql =  "DELETE FROM privilege_common WHERE common = 'course'  AND commonId = ".$courseId." AND userId = ".$userId;
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
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
		$common = "course";
		$common = $this->db->escape($common);
		$sql = "INSERT INTO privilege_common(common,userId,commonId,privilege) 
		 VALUES(".$common.",".$userId.",".$courseId.",".$kind.")";
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function del_unit($unitId){
		$unitId = $this->db->escape($unitId);
		$sql1= "DELETE FROM course_unit WHERE unitId =  ".$unitId;
		$sql2 = "DELETE FROM unit_problem WHERE unitId = ".$unitId;
		$this->db->trans_start();//事务开始
		$this->db->query($sql2);
		$this->db->query($sql1);
		$this->db->trans_complete();//事务结束
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function del_unit_problem($unitId,$problemId){
		$unitId = $this->db->escape($unitId);
		$problemId = $this->db->escape($problemId);
		$sql = "DELETE FROM unit_problem WHERE unitId = ".$unitId." AND problemId = ".$problemId;
		$this->db->query($sql);
		$affect = $this->db->affected_rows();
		if(is_numeric($affect) && $affect > 0)
			return true;
		return false;
	}
	
	public function get_user_course_list($userId,$limit_from,$limit_row){
		$userId = $this->db->escape($userId);
		$sql = "SELECT type FROM user WHERE userId = ".$userId;
		$query=$this->db->query($sql);
		$type = $query->row_array(0);
		$type = $type['type'];
		if($type == "admin"){
			return $this->get_course_list($limit_from,$limit_row);
		}
		else if($type == "teacher"){
			$sql = "SELECT courseId , course.userId , course.name as courseName,startTime ,endTime,private, user.name 
				FROM course LEFT JOIN user ON course.userId = user.userId WHERE user.userId = ".$userId.
				" LIMIT ".$limit_from." , ".$limit_row;
			$query = $this->db->query($sql);
			$result =  $query->result_array();
			if(empty($result))
				return false;
			return $result;
		}
		else if($type == "assistant"){
			$sql = "SELECT courseId , course.userId , course.name as courseName,startTime ,endTime,private, user.name 
				FROM course LEFT JOIN user ON course.userId = user.userId WHERE courseId  IN
				(SELECT distinct(commonId) FROM privilege_common WHERE userId =  ".$userId." AND common = 'course' AND privilege = 'edit') 
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
	
	public function add_assistant($courseId,$name_email){
		$courseId = $this->db->escape($courseId);
		$name_email = $this->db->escape($name_email);
		$sql = "SELECT userId ,type FROM user WHERE  name = ".$name_email." OR email = ".$name_email;
		$query=$this->db->query($sql);
		$user = $query->row_array(0);
		if(empty($user))
			return -1;//找不到用户
		$userId = $user['userId'];
		if($user['type'] == "student" || $user['type'] == "assistant" || $user['type'] == null){
			$sql = "UPDATE user SET type = 'assistant' WHERE userId = ".$userId;
			$this->db->query($sql);
		}
		$privilege_array = array("read","submit","edit");
		$affect = 0;
		for($i = 0;$i<3;$i++){
			$sql = "INSERT INTO privilege_common(common,commonId,userId,privilege) VALUES('course',".$courseId.",".$userId.",'".$privilege_array[$i]."')";
			$this->db->query($sql);
			$affect = $this->db->affected_rows();
		}
		return 1;//返回受影响行数
	}

	
}
