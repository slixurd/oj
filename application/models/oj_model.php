<?php 

/**
所有oj model函数均在此类当中
*/

class Oj_model extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

/**
get_problem_list()给定参数的问题列表
$is_search指名是否启用where查询，$column_array数组指明想要获取的problem列
$where_str为where处的条件字符串，如"problemId > 9999"用此参数时请先对相关数据用转义，再传进来
*/


	public function get_problem_list($is_search=FALSE,$column_array=array('problemId','title','source','accepted','submit'),$where_str="defunct = 0")
	{
		//判断不是条件查询模式
		if($is_search == FALSE){
			$sql="SELECT ".implode(" , ",$column_array)." FROM problem";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		//判断启用where查询
		else{
			$sql="SELECT ".implode(" , ",$column_array)." FROM problem WHERE "."$where_str  ";//条件查询模式
			$query=$this->db->query($sql);
			return $query->result_array();
		}
	}
}