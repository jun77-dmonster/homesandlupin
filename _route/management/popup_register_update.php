<?php
$sub_menu = '200400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$nw_id = isset($_REQUEST['nw_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['nw_id']) : 0;

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$nw_subject = isset($_POST['nw_subject']) ? strip_tags(clean_xss_attributes($_POST['nw_subject'])) : '';
$posts = array();

$check_keys = array(
'branch_cd'=>'str',
'nw_begin_time'=>'str',
'nw_end_time'=>'str',
'nw_disable_hours'=>'int',
'nw_height'=>'int',
'nw_width'=>'int',
'nw_content'=>'text',
'nw_content_html'=>'text',
);

foreach($check_keys as $key=>$val){
    if($val === 'int'){
        $posts[$key] = isset($_POST[$key]) ? (int) $_POST[$key] : 0;
    } else if ($val === 'str') {
        $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : 0;
    } else {
        $posts[$key] = isset($_POST[$key]) ? trim($_POST[$key]) : 0;
    }
}

$sql_common = " nw_display	  = '{$posts['branch_cd']}',
				nw_begin_time = '{$posts['nw_begin_time']}',
                nw_end_time = '{$posts['nw_end_time']}',
                nw_disable_hours = '{$posts['nw_disable_hours']}',
                nw_height = '{$posts['nw_height']}',
                nw_width = '{$posts['nw_width']}',
                nw_title = '{$nw_subject}',
                nw_content = '{$posts['nw_content']}',
                nw_content_html = '{$posts['nw_content_html']}' ";

if($w == "")
{
    $sql_common .= ", nw_reg_dt = '".G5_TIME_YMDHIS."'";
	
	$sql = " insert {$DM['POPUP_TABLE']} set $sql_common  ";

	sql_query($sql);

    $nw_id = sql_insert_id();
}
else if ($w == "u")
{
    $sql = " update {$DM['POPUP_TABLE']} set $sql_common where nw_id = '$nw_id' ";
    sql_query($sql);
}
else if ($w == "d")
{
    $sql = " delete from {$DM['POPUP_TABLE']} where nw_id = '$nw_id' ";
    sql_query($sql);
}

if ($w == "d")
{
   goto_url('./popup_list.php');
}
else
{
   goto_url("./popup_register.php?w=u&amp;nw_id=$nw_id");
}