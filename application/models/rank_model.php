<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function rank_compare($rank_a,$rank_b){
		if($rank_a["solved"] > $rank_b["solved"]){
			return -1;
		}else if($rank_a["solved"] == $rank_b["solved"]){
			if($rank_a["total"] < $rank_b["total"]){
				return -1;
			}
		}
		return 1;
	}

class Rank_model extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
        Global $user_rank ;//最终排序数组
        Global $count ;//计数
    }
	
	public function get_count_user(){
		$sql = "SELECT count(userId)  as count FROM user ";
		$query = $this->db->query($sql);
		$count =  $query->row_array(0);
		return $count['count'];
	}
	
	public function rank_list($from,$row){
		$from = $this->db->escape($from);
		$row = $this->db->escape($row);
		$sql = "SELECT name , user.userId , submit , solved FROM user JOIN user_state using(userId) 
		ORDER BY solved DESC , submit LIMIT ".$from.",".$row;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	public function contest_rank($cid){
		Global $user_rank;
		Global $count;
		
		//获取竞赛开始时间
		$sql = "SELECT startTime FROM contest WHERE contestId = ".$cid;
		$query = $this->db->query($sql);
		$startTime = $query->row_array(0);
		if(empty($startTime)){
			return false;
		}
		$startTime  = $startTime['startTime'];
		
		if(strtotime($startTime) > time()){
			return false;
		}
		
		//获取竞赛问题列表
		$cid = $this->db->escape($cid);
		$sql = "SELECT distinct(problemId) FROM contest_problem WHERE contestId = ".$cid." ORDER BY problemId";
		$query = $this->db->query($sql);
		$problem_list = $query->result_array();
		
		//获取解题用户列表
		$sql = "SELECT distinct(solution.userId),user.name FROM solution JOIN user ON user.userId = solution.userId  WHERE contestId = ".$cid;
		$query = $this->db->query($sql);
		$user_list = $query->result_array();
		
		$count = -1;//用户下标
		$user_rank = array();//最终排序数组
		foreach($user_list as $user){
			$user_rank[++$count]['userId'] = $user['userId'];
			$user_rank[$count]['name'] = $user['name'];
			foreach($problem_list as $problem){
				$user_rank[$count]["problem"][$problem["problemId"]]["result"] = 0;//每个用户都没有解开本题目
				$user_rank[$count]["problem"][$problem["problemId"]]["time"] = 0;//设置每个用户本道题目用时为0
				$user_rank[$count]["problem"][$problem["problemId"]]["error"] = 0;//设置每个用户本道题目错误次数，第一次提交正确之后的都不再被计算
			}
			$user_rank[$count]["solved"] = 0;//设置用户初始解题数为0
			$user_rank[$count]["total"] = 0;//设置用户初始解题总用时为0,包括惩罚用时在内
		}
		
		$sql = "SELECT userId,problemId,result,inDate FROM solution WHERE contestId = ".$cid." ORDER BY inDate, result";
		$query = $this->db->query($sql);
		$solution_list = $query->result_array();
		
		$punish_time = 20*60;//加罚时间
		
		foreach($solution_list as $solution){
			$this->add($solution['userId'],$solution['problemId'],$solution['inDate'],$solution['result'],$punish_time,$startTime);
		}
		
		usort($user_rank,"rank_compare");//使用rank_compare为比较依据进行排序
		
		return $user_rank;
	}
	
	public function unit_rank($uid){
		Global $user_rank;
		Global $count;
		
		//获取竞赛开始时间
		$sql = "SELECT startTime FROM course_unit WHERE unitId = ".$uid;
		$query = $this->db->query($sql);
		$startTime = $query->row_array(0);
		$startTime  = $startTime['startTime'];
		if(empty($startTime)){
			return false;
		}
		$startTime  = $startTime['startTime'];
		
		if(strtotime($startTime) > time()){
			return false;
		}
		
		//获取竞赛问题列表
		$cid = $this->db->escape($cid);
		$sql = "SELECT distinct(problemId) FROM unit_problem WHERE unitId = ".$cid." ORDER BY problemId ";
		$query = $this->db->query($sql);
		$problem_list = $query->result_array();
		
		//获取解题用户列表
		$sql = "SELECT distinct(solution.userId),user.name FROM solution JOIN user ON user.userId = solution.userId  WHERE unitId = ".$uid;
		$query = $this->db->query($sql);
		$user_list = $query->result_array();
		
		$count = -1;//用户下标
		$user_rank = array();//最终排序数组
		foreach($user_list as $user){
			$user_rank[++$count]['userId'] = $user['userId'];
			$user_rank[$count]['name'] = $user['name'];
			foreach($problem_list as $problem){
				$user_rank[$count]["problem"][$problem["problemId"]]["result"] = 0;//每个用户都没有解开本题目
				$user_rank[$count]["problem"][$problem["problemId"]]["time"] = 0;//设置每个用户本道题目用时为0
				$user_rank[$count]["problem"][$problem["problemId"]]["error"] = 0;//设置每个用户本道题目错误次数，第一次提交正确之后的都不再被计算
			}
			$user_rank[$count]["solved"] = 0;//设置用户初始解题数为0
			$user_rank[$count]["total"] = 0;//设置用户初始解题总用时为0,包括惩罚用时在内
		}
		
		$sql = "SELECT userId,problemId,result,inDate FROM solution WHERE unitId = ".$cid." ORDER BY inDate, result";
		$query = $this->db->query($sql);
		$solution_list = $query->result_array();
		
		$punish_time = 20*60;//加罚时间
		
		foreach($solution_list as $solution){
			$this->add($solution['userId'],$solution['problemId'],$solution['inDate'],$solution['result'],$punish_time,$startTime);
		}
		
		usort($user_rank,"rank_compare");//使用rank_compare为比较依据进行排序
		
		foreach($user_rank as $hehe){
			echo var_dump($hehe)."<BR><BR>";
		}
		
		return $user_rank;
	}
	
	//本函数调用必须在列表按照result和,inDate按照升序排序好的数组
	private function add($userId,$problemId,$inDate,$result,$punish_time,$startTime){
		Global $user_rank;
		Global $count;
		for($i = 0;$i<= $count;$i++){
			if($user_rank[$i]["userId"] == $userId){
				if($result != 4){
					$user_rank[$i]["problem"][$problemId]["time"] += $punish_time;
					$user_rank[$i]["problem"][$problemId]["error"] ++;
				}else{
					if($user_rank[$i]["problem"][$problemId]["result"] == 0){
						$user_rank[$i]["solved"]++;
						$user_rank[$i]["problem"][$problemId]["time"] += (strtotime($inDate) - strtotime($startTime));
						$user_rank[$i]["problem"][$problemId]["result"] = 1;
						$user_rank[$i]["total"] += $user_rank[$i]["problem"][$problemId]["time"];
					}
				}
			}
		}
	}
}
