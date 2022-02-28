<?php
$sub_menu = '400200';
include_once('./_common.php');

if ($w == 'u')
    check_demo();

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

if (isset($_POST['answer_title'])) {
    $wr_subject = substr(trim($_POST['answer_title']),0,255);
    $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
}

if (isset($_POST['answer_content'])) {
    $wr_content = substr(trim($_POST['answer_content']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

// 090710
if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

if (substr_count($wr_subject, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

$sql = " update {$DM['QNA_TABLE']} 
			set qna_status			=	'A',
				answer_title		=	'{$answer_title}',
				answer_content		=	'{$answer_content}',
				answer_wr_id		=	'{$manager['manager_id']}'
			where uid = '{$uid}'";

sql_query($sql);

goto_url("./branch_questions_view.php?uid=".$uid);