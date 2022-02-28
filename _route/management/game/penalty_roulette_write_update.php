<?php
$sub_menu = '200620';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');


$gubun_apply				=	isset($_POST['gubun_apply']) ? clean_xss_attributes($_POST['gubun_apply']) : '';
$penalty_main_display_fl	=	isset($_POST['penalty_main_display_fl']) ? clean_xss_attributes($_POST['penalty_main_display_fl']) : '';
$penalty_order				=	isset($_POST['penalty_order']) ? clean_xss_attributes($_POST['penalty_order']) : '';

$penalty_title = '';
if (isset($_POST['penalty_title'])) {
    $penalty_title = substr(trim($_POST['penalty_title']),0,65536);
    $penalty_title = preg_replace("#[\\\]+$#", "", $penalty_title);
}

if (substr_count($penalty_title, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

$penalty_content = '';
if (isset($_POST['penalty_content'])) {
    $penalty_content = substr(trim($_POST['penalty_content']),0,65536);
    $penalty_content = preg_replace("#[\\\]+$#", "", $penalty_content);
}

if (substr_count($penalty_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

//파일이미지
$penalty_path = G5_DATA_PATH.'/penalty';

// 게시판 디렉토리 생성
@mkdir($penalty_path, G5_DIR_PERMISSION);
@chmod($penalty_path, G5_DIR_PERMISSION);

$penalty_img = "";

if($w=="u"){

	$sql = " select penalty_img from {$DM['GAMES_PENALTY_TABLE']} where uid='{$uid}'";

	$file = sql_fetch($sql);

	$penalty_img	=	$file['penalty_img'];

}

${'penalty_img_del'}	= !empty($_POST['penalty_img_del']) ? 1 : 0;

//파일 삭제
if ($penalty_img_del) {

	$file_img1 = $penalty_path.'/'.clean_relative_paths($penalty_img);
	@unlink($file_img1);
    delete_img_thumbnail(dirname($penalty_img), basename($penalty_img));
    $penalty_img = '';

}

// 이미지업로드
if ($_FILES['penalty_img']['name']) {
    
	if($w == 'u' && $penalty_img) {
        $file_img1 = $youtube_path.'/'.clean_relative_paths($penalty_img);
        @unlink($file_img1);
        delete_img_thumbnail(dirname($penalty_img), basename($penalty_img));
    }

    $penalty_img = penalty_img_upload($_FILES['penalty_img']['tmp_name'], $_FILES['penalty_img']['name'], $penalty_path ."/".$uid);

}




if($w==""){

	$sql = " insert into {$DM['GAMES_PENALTY_TABLE']} 
				set gubun_apply					=	'{$gubun_apply}',
					penalty_title				=	'{$penalty_title}',
					penalty_content				=	'{$penalty_content}',
					penalty_main_display_fl		=	'{$penalty_main_display_fl}',
					penalty_order				=	'{$penalty_order}',
					penalty_img					=	'{$penalty_img}',
					penalty_reg_dt				=	'".G5_TIME_YMDHIS."'";	

	sql_query($sql);

	$uid = sql_insert_id();

}else{

	$sql = " update {$DM['GAMES_PENALTY_TABLE']} 
				set gubun_apply					=	'{$gubun_apply}',
					penalty_title				=	'{$penalty_title}',
					penalty_content				=	'{$penalty_content}',
					penalty_main_display_fl		=	'{$penalty_main_display_fl}',
					penalty_order				=	'{$penalty_order}',
					penalty_img					=	'{$penalty_img}',
					penalty_mod_dt				=	'".G5_TIME_YMDHIS."'
				where uid='{$uid}'";	

	sql_query($sql);

}

goto_url("./penalty_roulette_write.php?w=u&amp;uid=".$uid);