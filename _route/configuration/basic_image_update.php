<?php
$sub_menu = '100100';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

$upload_max_filesize = ini_get('upload_max_filesize');

if (empty($_POST)) {
    alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=".$upload_max_filesize."\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");
}

@mkdir(G5_DATA_PATH."/basic", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/basic", G5_DIR_PERMISSION);

$player2_file = $player3_file = $player4_file = $player5_file = $player6_file = $player7_file = $order_basic = $guide_basic = $wife_basic = '';

// 파일정보

$sql = " select sc_recommend_player2_img, sc_recommend_player3_img, sc_recommend_player4_img, sc_recommend_player5_img, sc_recommend_player6_img, sc_recommend_player7_img, sc_basic_order_img,  sc_basic_guide_img, sc_basic_wife_img
			from {$DM['SITE_CONFIG_TABLE']} 
			where site_id = '{$DM['SITE_ID']}' ";
$file = sql_fetch($sql);

$player2_file	= $file['sc_recommend_player2_img'];
$player3_file	= $file['sc_recommend_player3_img'];
$player4_file	= $file['sc_recommend_player4_img'];
$player5_file	= $file['sc_recommend_player5_img'];
$player6_file	= $file['sc_recommend_player6_img'];
$player7_file	= $file['sc_recommend_player7_img'];
$order_basic	= $file['sc_basic_order_img'];
$guide_basic	= $file['sc_basic_guide_img'];
$wife_basic		= $file['sc_basic_wife_img'];



$it_img_dir = G5_DATA_PATH.'/basic';

for($i=2;$i<=7;$i++){
    ${'player'.$i.'_file_del'} = ! empty($_POST['player'.$i.'_file_del']) ? 1 : 0;
}

${'order_basic_del'} = !empty($_POST['order_basic_del']) ? 1 : 0;
${'guide_img_del'} = !empty($_POST['guide_basic_del']) ? 1 : 0;
${'wife_img_del'} = !empty($_POST['wife_basic_del']) ? 1 : 0;

// 파일삭제
if ($player2_file_del) {
    $file_img2 = $it_img_dir.'/'.clean_relative_paths($player2_file);
    @unlink($file_img1);
    delete_basic_thumbnail(dirname($file_img2), basename($file_img2));
    $player2_file = '';
}

if ($player3_file_del) {
    $file_img3 = $it_img_dir.'/'.clean_relative_paths($player3_file);
    @unlink($file_img3);
    delete_basic_thumbnail(dirname($file_img3), basename($file_img3));
    $player3_file = '';
}

if ($player4_file_del) {
    $file_img4 = $it_img_dir.'/'.clean_relative_paths($player4_file);
    @unlink($file_img3);
    delete_basic_thumbnail(dirname($file_img4), basename($file_img4));
    $player4_file = '';
}

if ($player5_file_del) {
    $file_img5 = $it_img_dir.'/'.clean_relative_paths($player5_file);
    @unlink($file_img5);
    delete_basic_thumbnail(dirname($file_img5), basename($file_img5));
    $player5_file = '';
}

if ($player6_file_del) {
    $file_img6 = $it_img_dir.'/'.clean_relative_paths($player6_file);
    @unlink($file_img6);
    delete_basic_thumbnail(dirname($file_img6), basename($file_img6));
    $player6_file = '';
}

if ($player7_file_del) {
    $file_img7 = $it_img_dir.'/'.clean_relative_paths($player7_file);
    @unlink($file_img7);
    delete_basic_thumbnail(dirname($file_img7), basename($file_img7));
    $player7_file = '';
}

if ($order_basic_del) {
    $file_img8 = $it_img_dir.'/'.clean_relative_paths($order_basic_del);
    @unlink($file_img8);
    delete_basic_thumbnail(dirname($file_img8), basename($file_img8));
    $order_basic_del = '';
}


if ($guide_img_del) {
    $file_img9 = $it_img_dir.'/'.clean_relative_paths($guide_img_del);
    @unlink($file_img9);
    delete_basic_thumbnail(dirname($file_img9), basename($file_img9));
    $guide_img_del = '';
}


if ($wife_img_del) {
    $file_img10 = $it_img_dir.'/'.clean_relative_paths($wife_img_del);
    @unlink($file_img10);
    delete_basic_thumbnail(dirname($file_img10), basename($file_img10));
    $wife_img_del = '';
}

// 이미지업로드
if ($_FILES['player2_file']['name']) {
    if($w == 'u' && $player2_file) {
        $file_img2 = $it_img_dir.'/'.clean_relative_paths($player2_file);
        @unlink($file_img2);
        delete_basic_thumbnail(dirname($file_img2), basename($file_img2));
    }
    $player2_file = basic_img_upload($_FILES['player2_file']['tmp_name'], $_FILES['player2_file']['name'], $it_img_dir);
}

if ($_FILES['player3_file']['name']) {
    if($w == 'u' && $player3_file) {
        $file_img3 = $it_img_dir.'/'.clean_relative_paths($player3_file);
        @unlink($file_img3);
        delete_basic_thumbnail(dirname($file_img3), basename($file_img3));
    }
    $player3_file = basic_img_upload($_FILES['player3_file']['tmp_name'], $_FILES['player3_file']['name'], $it_img_dir);
}

if ($_FILES['player4_file']['name']) {
    if($w == 'u' && $player4_file) {
        $file_img4 = $it_img_dir.'/'.clean_relative_paths($player4_file);
        @unlink($file_img4);
        delete_basic_thumbnail(dirname($file_img4), basename($file_img4));
    }
    $player4_file = basic_img_upload($_FILES['player4_file']['tmp_name'], $_FILES['player4_file']['name'], $it_img_dir);
}

if ($_FILES['player5_file']['name']) {
    if($w == 'u' && $player5_file) {
        $file_img5 = $it_img_dir.'/'.clean_relative_paths($player5_file);
        @unlink($file_img5);
        delete_basic_thumbnail(dirname($file_img5), basename($file_img5));
    }
    $player5_file = basic_img_upload($_FILES['player5_file']['tmp_name'], $_FILES['player5_file']['name'], $it_img_dir);
}

if ($_FILES['player6_file']['name']) {
    if($w == 'u' && $player6_file) {
        $file_img6 = $it_img_dir.'/'.clean_relative_paths($player6_file);
        @unlink($file_img6);
        delete_basic_thumbnail(dirname($file_img6), basename($file_img6));
    }
    $player6_file = basic_img_upload($_FILES['player6_file']['tmp_name'], $_FILES['player6_file']['name'], $it_img_dir);
}

if ($_FILES['player7_file']['name']) {
    if($w == 'u' && $player7_file) {
        $file_img7 = $it_img_dir.'/'.clean_relative_paths($player7_file);
        @unlink($file_img7);
        delete_basic_thumbnail(dirname($file_img7), basename($file_img7));
    }
    $player7_file = basic_img_upload($_FILES['player7_file']['tmp_name'], $_FILES['player7_file']['name'], $it_img_dir);
}

if ($_FILES['order_basic']['name']) {
    if($w == 'u' && $order_basic) {
        $file_img8 = $it_img_dir.'/'.clean_relative_paths($order_basic);
        @unlink($file_img8);
        delete_basic_thumbnail(dirname($file_img8), basename($file_img8));
    }
    $order_basic = basic_img_upload($_FILES['order_basic']['tmp_name'], $_FILES['order_basic']['name'], $it_img_dir);
}

if ($_FILES['guide_basic']['name']) {
    if($w == 'u' && $guide_basic) {
        $file_img9 = $it_img_dir.'/'.clean_relative_paths($guide_basic);
        @unlink($file_img9);
        delete_basic_thumbnail(dirname($file_img9), basename($file_img9));
    }
    $guide_basic = basic_img_upload($_FILES['guide_basic']['tmp_name'], $_FILES['guide_basic']['name'], $it_img_dir);
}
if ($_FILES['wife_basic']['name']) {
    if($w == 'u' && $wife_basic) {
        $file_img10 = $it_img_dir.'/'.clean_relative_paths($wife_basic);
        @unlink($file_img10);
        delete_basic_thumbnail(dirname($file_img10), basename($file_img10));
    }
    $wife_basic = basic_img_upload($_FILES['wife_basic']['tmp_name'], $_FILES['wife_basic']['name'], $it_img_dir);
}


$sql = " update {$DM['SITE_CONFIG_TABLE']}  
			set sc_recommend_player2_img	= '{$player2_file}',
				sc_recommend_player3_img	= '{$player3_file}',
				sc_recommend_player4_img	= '{$player4_file}',
				sc_recommend_player5_img	= '{$player5_file}',
				sc_recommend_player6_img	= '{$player6_file}',
				sc_recommend_player7_img	= '{$player7_file}',
				sc_basic_order_img			= '{$order_basic}',
				sc_basic_guide_img			= '{$guide_basic}',
				sc_basic_wife_img			= '{$wife_basic}',
				sc_faq_text					= '{$sc_faq_text}',
				sc_operation_guide_movie	= '{$sc_operation_guide_movie}'
			where site_id = '{$DM['SITE_ID']}'"; 

$r1=sql_query($sql);

goto_url("./basic_image.php");