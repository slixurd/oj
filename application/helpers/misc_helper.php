<?php

function getTime($date){  
    $unixTime = strtotime($date);  
    return $unixTime;  
} 

function get_pri_type($pri){
    if (!is_numeric($pri) || $pri >3 || $pri <0) 
        return false;
    $pri_type = array('0' => 'admin','1' => 'teacher', '2'=>'assistant','3'=>'student');
    return $pri_type[$pri];
}

function get_pri_key($value){
    $pri_type = array('0' => 'admin','1' => 'teacher', '2'=>'assistant','3'=>'student');
    $key = array_search($value, $pri_type);
    return $key;
}