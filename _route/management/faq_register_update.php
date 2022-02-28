<?php
$sub_menu = '200200';
include_once('./_common.php');

if ($w == 'u')
    check_demo();

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();


$category_cd	=	isset($_POST['category_cd']) ? trim($_POST['category_cd']) : '';
$branch_cd		=	isset($_POST['branch_cd']) ? trim($_POST['branch_cd']) : '';
$is_main		=	isset($_POST['is_main']) ? trim($_POST['is_main']) : '';

if (isset($_POST['subject'])) {
    $wr_subject = substr(trim($_POST['subject']),0,255);
    $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
}

if (isset($_POST['content'])) {
    $wr_content = substr(trim($_POST['content']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

if (isset($_POST['answer'])) {
    $wr_answer = substr(trim($_POST['answer']),0,65536);
    $wr_answer = preg_replace("#[\\\]+$#", "", $wr_answer);
}

// 090710
if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

if (substr_count($wr_answer, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

if($w==""){
	
	$sql = "insert into {$DM['FAQ_TABLE']} 
				set category_cd		=	'{$category_cd}',
					branch_cd		=	'{$branch_cd}',
					is_main			=	'{$is_main}',
					subject			=	'{$wr_subject}',
					content			=	'{$wr_content}',
					answer			=	'{$wr_answer}',
					reg_dt			=	'".G5_TIME_YMDHIS."'";

	sql_query($sql);

	$uid = sql_insert_id();

}else{

	$sql = "update {$DM['FAQ_TABLE']} 
				set category_cd		=	'{$category_cd}',
					branch_cd		=	'{$branch_cd}',
					is_main			=	'{$is_main}',
					subject			=	'{$wr_subject}',
					content			=	'{$wr_content}',
					answer			=	'{$wr_answer}'
				where uid			=	'{$uid}'";

	sql_query($sql);

}

goto_url('./faq_register.php?'.$qstr."&amp;w=u&amp;uid=".$uid);