<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$games_cd				=	isset($_POST['games_cd']) ? clean_xss_attributes($_POST['games_cd']) : '';
$youtube_thumb_title	=	isset($_POST['youtube_thumb_title']) ? clean_xss_attributes($_POST['youtube_thumb_title']) : '';
$youtube_paly_min		=	isset($_POST['youtube_paly_min']) ? clean_xss_attributes($_POST['youtube_paly_min']) : '';
$youtube_paly_sec		=	isset($_POST['youtube_paly_sec']) ? clean_xss_attributes($_POST['youtube_paly_sec']) : '';
$youtube_setting_fl		=	isset($_POST['youtube_setting_fl']) ? clean_xss_attributes($_POST['youtube_setting_fl']) : '';




$youtube_path = G5_DATA_PATH.'/youtubemark';

// 게시판 디렉토리 생성
@mkdir($youtube_path, G5_DIR_PERMISSION);
@chmod($youtube_path, G5_DIR_PERMISSION);

$youtube_img_thumb = "";

if($w=="u"){

	$sql = " select youtube_img_thumb from {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} where uid='{$uid}'";

	$file = sql_fetch($sql);

	$youtube_img_thumb	=	$file['youtube_img_thumb'];

}

${'youtube_img_thumb_del'}	= !empty($_POST['youtube_img_thumb_del']) ? 1 : 0;

//파일 삭제
if ($youtube_img_thumb_del) {

	$file_img1 = $youtube_path.'/'.clean_relative_paths($youtube_img_thumb);
	@unlink($file_img1);
    delete_img_thumbnail(dirname($youtube_img_thumb), basename($youtube_img_thumb));
    $youtube_img_thumb = '';

}

// 이미지업로드
if ($_FILES['youtube_img_thumb']['name']) {
    
	if($w == 'u' && $youtube_img_thumb) {
        $file_img1 = $youtube_path.'/'.clean_relative_paths($youtube_img_thumb);
        @unlink($file_img1);
        delete_img_thumbnail(dirname($youtube_img_thumb), basename($youtube_img_thumb));
    }

    $youtube_img_thumb = youtube_img_upload($_FILES['youtube_img_thumb']['tmp_name'], $_FILES['youtube_img_thumb']['name'], $youtube_path ."/".$games_cd);

}



if($w==""){

	//등록
	$sql = " insert into {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} 
				set games_cd				= '{$games_cd}',
					youtube_thumb_title		= '{$youtube_thumb_title}',
					youtube_img_thumb		= '{$youtube_img_thumb}',
					youtube_paly_min		= '{$youtube_paly_min}',
					youtube_paly_sec		= '{$youtube_paly_sec}',
					youtube_setting_fl		= '{$youtube_setting_fl}',
					reg_dt					= '".G5_TIME_YMDHIS."'
	";

	sql_query($sql);

	$uid = sql_insert_id();

}else{

	//수정
	$sql = " update {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} 
				set youtube_thumb_title		= '{$youtube_thumb_title}',
					youtube_img_thumb		= '{$youtube_img_thumb}',
					youtube_paly_min		= '{$youtube_paly_min}',
					youtube_paly_sec		= '{$youtube_paly_sec}',
					youtube_setting_fl		= '{$youtube_setting_fl}'
				where uid = {$uid}";

	sql_query($sql);

}

goto_url("./pop_youtube_bookmark_write.php?w=u&amp;uid=".$uid."&amp;games_cd=".$games_cd);