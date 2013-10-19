<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error {
	
	public function show_error($error_title,$error_inform=array()){
		$CI =& get_instance();
		$data['error_inform_title'] = $error_title;
		$data['error_inform']= $error_inform;
		$CI->load->view('common/header',$data);
		$CI->load->view('notice/common_error_view');
		$CI->load->view('common/footer');
	}
}
