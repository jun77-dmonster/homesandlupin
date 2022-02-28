<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$template_gubun		=	isset($_POST['template_gubun']) ? strip_tags(clean_xss_attributes($_POST['template_gubun'])) : '';
$template_code		=	isset($_POST['template_code']) ? strip_tags(clean_xss_attributes($_POST['template_code'])) : '';
$template_title		=	isset($_POST['template_title']) ? strip_tags(clean_xss_attributes($_POST['template_title'])) : '';
$template_use_fl	= 	isset($_POST['template_use_fl']) ? strip_tags(clean_xss_attributes($_POST['template_use_fl'])) : '';

if($w==""){

	$sql = " insert into {$DM['B_TEMPLATE_TABLE']} 
				set template_gubun		=	'{$template_gubun}',
					template_code		=	'{$template_code}',
					template_title		=	'{$template_title}',
					template_use_fl		=	'{$template_use_fl}'";

	sql_query($sql);

	$uid = sql_insert_id();;

}else{

	$sql = " update {$DM['B_TEMPLATE_TABLE']} 
				set template_gubun		=	'{$template_gubun}',
					template_title		=	'{$template_title}',
					template_use_fl		=	'{$template_use_fl}'
				where uid	= '{$uid}'";

	sql_query($sql);

}

goto_url("./branch_template_write.php?w=u&amp;uid=".$uid);