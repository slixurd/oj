<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index($page = 1){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $data['page_title']='课程';
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        //$type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        //$type = $type['type'];
        //if($type != "admin"){
        //  $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //  return;
        //}
        $total = $this->course_edit->get_course_count();
        $data['course_list'] = $this->course_edit->get_course_list(($page-1)*10,10);
        //var_dump($data['course_list']);
        
        
        $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = site_url("admin/course/index");
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 4;         
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';     
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';           
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';    
        $this->pagination->initialize($config);
        $data['pagination_block'] = $this->pagination->create_links();
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/course_list",$data);
        $this->load->view("common/admin_footer",$data);
    }

    /**
     * 删除课程
     * @param  int $cid
     * @return JSON
     */
    public function del($cid = NULL){
        Global $data;
        if($cid === NULL||!is_numeric($cid)){
            $result = array('status' => false , 'reason' => '错误的课程编号');
            echo json_encode($result);
            return;
        }
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $result = array('status' => false , 'reason' => '没有权限');
        //     echo json_encode($result);
        //     return;
        // }
        
        $this->course_edit->del_course($cid);
        //这里需要增加状态判断，如果删除失败返回false，否则为true
        $result = array('status' => true);
        echo json_encode($result);
    }

    public function add(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }

        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/course_add",$data);
        $this->load->view("common/admin_footer",$data);    
    }

    public function put_course(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }

        $title = $this->input->post('title',true);
        $teacher = $this->input->post('teacher',true);
        $acount = intval($this->input->post('assis_count',true));
        $stime = $this->input->post('stime',true);
        $etime = $this->input->post('etime',true);
        $private = $this->input->post('private',true) == "public"? 1 : 0 ;
        //$describe = $this->input->post('describe',true);
        $students = $this->input->post('students',true);


        $s = getTime($stime);
        $e = getTime($etime);
        //检测时间是否出错
        if($s === false || $e === false || $s > $e){
            $this->error->show_error("提交时间出错",array("重新检查"),$data);
            return;            
        }


        $this->load->model("back/course_edit",'cedit');
        $this->load->model("user_model",'umodel');

        if(!is_numeric($tid = $this->umodel->get_id_by_name($teacher)) || $tid == false ){
            $this->error->show_error("提交时间出错",array("重新检查"),$data);
            return;            
        }

        $cid = $this->cedit->add_course($tid,$title,$stime,$etime,$private,1);
        if (!is_numeric($cid)) {
             $this->error->show_error("提交出错",array("请重新提交"),$data);
            return;                
        }
        for ($i=0; $i < $acount; $i++) { 
            $assis = "assistant".$i;
            $assistant = $this->input->post($assis,true);
            $status = $this->cedit->add_assistant(913,$assistant);
            //status 为 -1是找不到用户.这里不检查直接跳过,添加后面的助教
        }

        redirect('/admin/course/unit_list/'.$cid, 'location', 301);

    }


    public function unit_list($cid = 0){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        if($cid === NULL||!is_numeric($cid)||$cid == 0){
            $this->error->show_error("对不起，没有这个课程",array("课程编号错误"),$data);
            return; 
        }      
        $data['cid'] = $cid;  
        $data['page_title']='课程';
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //     return;
        // }

        $problem_list = $this->course_edit->get_course_unit_list($cid);

        $data['plist'] = $problem_list;
        //var_dump($problem_list);
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/unit_list",$data);
        $this->load->view("common/admin_footer",$data);        

    }

    /**
     * 添加课程,需要判断权限
     * @POST title=%s&stime=datetime&etime=datetime
     * @return JSON
     */
    public function unit_add($cid){
        Global $data;
        $courseId = $cid;
        $title = $this->input->post('title',true);
        $startTime = $this->input->post('stime',true);
        $endTime = $this->input->post('etime',true);
        $s = getTime($startTime);
        $e = getTime($endTime);
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        if($cid === NULL||!is_numeric($cid)){
            $result = array('status' => false , 'reason' => '错误的课程编号');
            echo json_encode($result);
            return;
        }
        if($s === false || $e === false || $e - $s < 0){
            $result = array('status' => false, 'reason' => '时间出错');
            echo json_encode($result);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];

        // if($type != "admin"){
        //     $result = array('status' => false , 'reason' => '没有权限');
        //     echo json_encode($result);
        //     return;
        // }
        //需要先对CID进行判断
        $uid = $this->course_edit->add_unit($cid,$title,$startTime,$endTime);
        $return = array('status' => true,'uid' => $uid);
        echo json_encode($return);
        return;
    }
    /**
     * 删除单元
     * @param  int $uid
     * @return JSON
     */
    public function unit_del($uid = NULL){
        Global $data;
        if($uid === NULL||!is_numeric($uid)||$uid <= 0){
            $result = array('status' => false , 'reason' => '错误的单元编号');
            echo json_encode($result);
            return;
        }
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $result = array('status' => false , 'reason' => '没有权限');
        //     echo json_encode($result);
        //     return;
        // }
        
        $this->course_edit->del_unit($uid);
        //这里需要增加状态判断，如果删除失败返回false，否则为true
        $result = array('status' => true);
        echo json_encode($result);
    }        

    public function problem($uid,$page = 1){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        if($uid === NULL||!is_numeric($uid)||$uid == 0||$page < 1 || !is_numeric($page)){
            $this->error->show_error("对不起，地址错误",array("单元编号错误或者页数错误"),$data);
            return; 
        }
        $data['page_title']='课程';
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $this->load->model("back/problem_edit","problem_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];

        $plist = $this->course_edit->get_unit_problem_list($uid);
        $data['plist'] = $plist;
        $data['uid'] = $uid;
        //var_dump($plist);

        $total = $this->problem_edit->get_count();
        $data['problem_list'] = $this->problem_edit->get_problem_list(($page-1)*10,10);

        $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;

        $config['base_url'] = site_url("admin/course/problem").'/'.$uid.'/';
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 5; 
        //后缀,保证点击分页以后直接显示整个问题列表
        $config['suffix'] = "#problem";
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';     
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';           
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';    
        $this->pagination->initialize($config);
        $data['pagination_block'] = $this->pagination->create_links();


        
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/unit_problem_add",$data);
        $this->load->view("common/admin_footer",$data);     
    }

    public function problem_select($uid = 0){
        Global $data;
        $pid = $this->input->get('pid',true);
        $action = $this->input->get('add',true);

        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        if($uid <0 ||!is_numeric($uid)|| $pid <0 ||!is_numeric($pid)){
            $result = array('status' => false , 'reason' => '题目ID出错');
            echo json_encode($result);
            return;
        }
        if($action==='1'||$action==='0'){
            $this->load->model("user_model");
            $this->load->model("back/course_edit","course_edit");
            $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
            $type = $type['type'];

            // if($type != "admin"){
            //     $result = array('status' => false , 'reason' => '没有权限');
            //     echo json_encode($result);
            //     return;
            // }
            
            // “1”表示选择. 0 表示删除
            if ($action === '1') {
                $status = $this->course_edit->add_unit_problem($uid,$pid);
            }else if ($action === '0') {
                $status = $this->course_edit->del_unit_problem($uid,$pid);
                
            }
            if($status != false)
                $return = array('status' => true);
            else 
                $return = array('status' => false,'reason'=>'执行失败');

            echo json_encode($return);
            return;            
        }else{
            $result = array('status' => false , 'reason' => '执行方式出错');
            echo json_encode($result);
            return;                       
        }


    }

}
