<?php
$sub_menu = '200610';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$games_cd					=	isset($_POST['games_cd']) ? clean_xss_attributes($_POST['games_cd']) : '';

if(!$games_cd){
	alert("게임코드가 없습니다. 올바른 방법으로 접근해 주세요");
}

$games_nm					=	isset($_POST['games_nm']) ? clean_xss_attributes($_POST['games_nm']) : '';

if(!$games_nm){
	alert("게임이름이 없습니다. 올바른 방법으로 접근해 주세요");
}

$games_level				=	isset($_POST['games_level']) ? clean_xss_attributes($_POST['games_level']) : '';
$post_count_chk				=	(isset($_POST['g_theme']) && is_array($_POST['g_theme'])) ? count($_POST['g_theme']) : 0;
$games_theme				=	(isset($_POST['g_theme']) && is_array($_POST['g_theme'])) ? $_POST['g_theme'] : array();

$games_theme2 = implode('|', $games_theme);

//$recommend_player_cnt		=	isset($_POST['recommend_player_cnt']) ? clean_xss_attributes($_POST['recommend_player_cnt']) : '';
$recommend_player_min_cnt		=	isset($_POST['recommend_player_min_cnt']) ? clean_xss_attributes($_POST['recommend_player_min_cnt']) : '0';
$recommend_player_max_cnt		=	isset($_POST['recommend_player_max_cnt']) ? clean_xss_attributes($_POST['recommend_player_max_cnt']) : '0';

//$search_filtering_play_cnt	=	dm_array_check($_POST['search_filtering_play_cnt']);
//$search_filtering_play_cnt	=	isset($_POST['search_filtering_play_cnt']) ? clean_xss_attributes($_POST['search_filtering_play_cnt']) : '';

//$player_cnt					=	isset($_POST['player_cnt']) ? clean_xss_attributes($_POST['player_cnt']) : '';
$player_min_cnt					=	isset($_POST['player_min_cnt']) ? clean_xss_attributes($_POST['player_min_cnt']) : '0';
$player_max_cnt					=	isset($_POST['player_max_cnt']) ? clean_xss_attributes($_POST['player_max_cnt']) : '0';

$play_time					=	isset($_POST['play_time']) ? clean_xss_attributes($_POST['play_time']) : '';
$staff_call					=	isset($_POST['staff_call']) ? clean_xss_attributes($_POST['staff_call']) : '';
$explain_time				=	isset($_POST['explain_time']) ? clean_xss_attributes($_POST['explain_time']) : '';

$best_icon					=	isset($_POST['best_icon']) ? clean_xss_attributes($_POST['best_icon']) : 'F';
$new_icon					=	isset($_POST['new_icon']) ? clean_xss_attributes($_POST['new_icon']) : 'F';

$games_hash_tag				=	isset($_POST['games_hash_tag']) ? clean_xss_attributes($_POST['games_hash_tag']) : '';

$games_youtube				=	isset($_POST['games_youtube']) ? clean_xss_attributes($_POST['games_youtube']) : '';
$games_content				=	isset($_POST['games_content']) ? clean_xss_attributes($_POST['games_content']) : '';


$wr_content = '';
if (isset($_POST['games_summaray'])) {
    $wr_content = substr(trim($_POST['games_summaray']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}



$games_path = G5_DATA_PATH.'/boardgames';

// 게시판 디렉토리 생성
@mkdir($games_path, G5_DIR_PERMISSION);
@chmod($games_path, G5_DIR_PERMISSION);

$game_file = "";

if($w=="u"){

	$sql = " select games_img_file from {$DM['BOARD_GAMES_TABLE']} where games_cd='{$games_cd}'";

	$file = sql_fetch($sql);

	$game_file	=	$file['games_img_file'];

}

${'game_file_del'}	= !empty($_POST['game_file_del']) ? 1 : 0;


//파일 삭제
if ($game_file_del) {

	$file_img1 = $games_path.'/'.clean_relative_paths($game_file);
	@unlink($file_img1);
    delete_img_thumbnail(dirname($game_file), basename($game_file));
    $game_file = '';

}

// 이미지업로드
if ($_FILES['game_file']['name']) {
    
	if($w == 'u' && $game_file) {
        $file_img1 = $games_path.'/'.clean_relative_paths($game_file);
        @unlink($file_img1);
        delete_img_thumbnail(dirname($game_file), basename($game_file));
    }

    $game_file = games_img_upload($_FILES['game_file']['tmp_name'], $_FILES['game_file']['name'], $games_path."/".$games_cd);

}

if($w==""){

	//신규

	$sql = " insert into {$DM['BOARD_GAMES_TABLE']} 
				set games_cd					=	'{$games_cd}',
					games_nm					=	'{$games_nm}',
					games_content				=	'{$games_content}',
					games_hash_tag				=	'{$games_hash_tag}',
					games_summaray				=	'{$games_summaray}',
					games_img_file				=	'{$game_file}',
					best_icon					=	'{$best_icon}',
					new_icon					=	'{$new_icon}',
					games_youtube				=	'{$games_youtube}',
					staff_call					=	'{$staff_call}',
					recommend_player_min_cnt	=	'{$recommend_player_min_cnt}',
					recommend_player_max_cnt	=	'{$recommend_player_max_cnt}',
					player_min_cnt				=	'{$player_min_cnt}',
					player_max_cnt				=	'{$player_max_cnt}',
					play_time					=	'{$play_time}',
					explain_time				=	'{$explain_time}',
					search_filtering_play_cnt	=	'{$search_filtering_play_cnt}',
					games_level					=	'{$games_level}',
					games_theme					=	'{$games_theme2}',
					games_reg_dt				=	'".G5_TIME_YMDHIS."'";

	sql_query($sql);

}else{

	//수정
	$sql = " update {$DM['BOARD_GAMES_TABLE']} 
				set games_nm					=	'{$games_nm}',
					games_content				=	'{$games_content}',
					games_hash_tag				=	'{$games_hash_tag}',
					games_summaray				=	'{$games_summaray}',
					games_img_file				=	'{$game_file}',
					best_icon					=	'{$best_icon}',
					new_icon					=	'{$new_icon}',
					games_youtube				=	'{$games_youtube}',
					staff_call					=	'{$staff_call}',
					recommend_player_min_cnt	=	'{$recommend_player_min_cnt}',
					recommend_player_max_cnt	=	'{$recommend_player_max_cnt}',
					player_min_cnt				=	'{$player_min_cnt}',
					player_max_cnt				=	'{$player_max_cnt}',
					play_time					=	'{$play_time}',
					explain_time				=	'{$explain_time}',
					search_filtering_play_cnt	=	'{$search_filtering_play_cnt}',
					games_level					=	'{$games_level}',
					games_theme					=	'{$games_theme2}',
					games_mod_dt				=	'".G5_TIME_YMDHIS."'
				where games_cd					=	'{$games_cd}'";

	sql_query($sql);

}

goto_url("./board_games_register.php?w=u&games_cd=".$games_cd);