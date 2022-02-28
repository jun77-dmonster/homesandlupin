<?php
$sub_menu = '200100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$branch_cd = isset($_POST['branch_cd']) ? strip_tags(clean_xss_attributes($_POST['branch_cd'])) : '';

if (!$branch_cd) { alert('지점코드는 반드시 선택하세요.'); }

$posts = array();

$check_keys = array(
'branch_operation_guide_movie'
);

foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}


$brand_path = G5_DATA_PATH.'/branch';

// 게시판 디렉토리 생성
@mkdir($brand_path, G5_DIR_PERMISSION);
@chmod($brand_path, G5_DIR_PERMISSION);

if($w=="u"){

	$g1 = sql_fetch("select count(*) as cnt from {$DM['BASE_GUIDE_TABLE']} where branch_cd='{$branch_cd}'");

	if($g1['cnt']==0){
	
		$basic_order_img = $player2_img = $player3_img = $player4_img = $player5_img = $player6_img = $player7_img = $guide_file1 = $guide_file2 = "";

	}else{
	
		$sql = " select * from {$DM['BASE_GUIDE_TABLE']} where branch_cd='{$branch_cd}'";

		$file = sql_fetch($sql);

		$basic_order_img	=	$file['guide_basic_order_img'];
		$guide_file1		=	$file['guide_file1'];
		$guide_file2		=	$file['guide_file2'];
		$player2_img		=	$file['guide_player2_img'];
		$player3_img		=	$file['guide_player3_img'];
		$player4_img		=	$file['guide_player4_img'];
		$player5_img		=	$file['guide_player5_img'];
		$player6_img		=	$file['guide_player6_img'];
		$player7_img		=	$file['guide_player7_img'];

	}

}

for($i=2;$i<=7;$i++){
    ${'player'.$i.'_img_del'} = ! empty($_POST['player'.$i.'_img_del']) ? 1 : 0;
}

${'basic_order_img_del'}	= ! empty($_POST['basic_order_img_del']) ? 1 : 0;
${'guide_file1_del'}		= ! empty($_POST['guide_file1_del']) ? 1 : 0;
${'guide_file2_del'}		= ! empty($_POST['guide_file2_del']) ? 1 : 0;

//파일 삭제
if ($player2_img_del) {

	$file_img2 = $brand_path.'/'.clean_relative_paths($player2_img);
	@unlink($file_img2);
    delete_img_thumbnail(dirname($player2_img), basename($player2_img));
    $player2_img = '';

}

if ($player3_img_del) {

	$file_img3 = $brand_path.'/'.clean_relative_paths($player3_img);
	@unlink($file_img3);
    delete_img_thumbnail(dirname($player3_img), basename($player3_img));
    $player3_img = '';

}

if ($player4_img_del) {

	$file_img4 = $brand_path.'/'.clean_relative_paths($player4_img);
	@unlink($file_img4);
    delete_img_thumbnail(dirname($player4_img), basename($player4_img));
    $player4_img = '';

}

if ($player5_img_del) {

	$file_img5 = $brand_path.'/'.clean_relative_paths($player5_img);
	@unlink($file_img5);
    delete_img_thumbnail(dirname($player5_img), basename($player5_img));
    $player5_img = '';

}

if ($player6_img_del) {

	$file_img6 = $brand_path.'/'.clean_relative_paths($player6_img);
	@unlink($file_img6);
    delete_img_thumbnail(dirname($player6_img), basename($player6_img));
    $player6_img = '';

}

if ($player7_img_del) {

	$file_img7 = $brand_path.'/'.clean_relative_paths($player7_img);
	@unlink($file_img7);
    delete_img_thumbnail(dirname($player7_img), basename($player7_img));
    $player7_img = '';

}

if ($basic_order_img_del) {

	$file_img8 = $brand_path.'/'.clean_relative_paths($basic_order_img);
	@unlink($file_img8);
    delete_img_thumbnail(dirname($basic_order_img), basename($basic_order_img));
    $basic_order_img = '';

}

if ($guide_file1_del) {

	$file_img9 = $brand_path.'/'.clean_relative_paths($guide_file1);
	@unlink($file_img9);
    delete_img_thumbnail(dirname($guide_file1), basename($guide_file1));
    $guide_file1 = '';

}

if ($guide_file2_del) {

	$file_img10 = $brand_path.'/'.clean_relative_paths($guide_file2);
	@unlink($file_img10);
    delete_img_thumbnail(dirname($guide_file2), basename($guide_file2));
    $guide_file2 = '';

}

// 이미지업로드
if ($_FILES['player2_img']['name']) {
    
	if($w == 'u' && $player2_img) {
        $file_img2 = $brand_path.'/'.clean_relative_paths($player2_img);
        @unlink($file_img2);
        delete_img_thumbnail(dirname($player2_img), basename($player2_img));
    }

    $player2_img = branch_img_upload($_FILES['player2_img']['tmp_name'], $_FILES['player2_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['player3_img']['name']) {
    
	if($w == 'u' && $player3_img) {
        $file_img3 = $brand_path.'/'.clean_relative_paths($player3_img);
        @unlink($file_img3);
        delete_img_thumbnail(dirname($player3_img), basename($player3_img));
    }

    $player3_img = branch_img_upload($_FILES['player3_img']['tmp_name'], $_FILES['player3_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['player4_img']['name']) {
    
	if($w == 'u' && $player4_img) {
        $file_img4 = $brand_path.'/'.clean_relative_paths($player4_img);
        @unlink($file_img4);
        delete_img_thumbnail(dirname($player4_img), basename($player4_img));
    }

    $player4_img = branch_img_upload($_FILES['player4_img']['tmp_name'], $_FILES['player4_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['player5_img']['name']) {
    
	if($w == 'u' && $player5_img) {
        $file_img5 = $brand_path.'/'.clean_relative_paths($player5_img);
        @unlink($file_img5);
        delete_img_thumbnail(dirname($player5_img), basename($player5_img));
    }

    $player5_img = branch_img_upload($_FILES['player5_img']['tmp_name'], $_FILES['player5_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['player6_img']['name']) {
    
	if($w == 'u' && $player6_img) {
        $file_img6 = $brand_path.'/'.clean_relative_paths($player6_img);
        @unlink($file_img6);
        delete_img_thumbnail(dirname($player6_img), basename($player6_img));
    }

    $player6_img = branch_img_upload($_FILES['player6_img']['tmp_name'], $_FILES['player6_img']['name'], $brand_path."/".$branch_cd);

}


if ($_FILES['player7_img']['name']) {
    
	if($w == 'u' && $player7_img) {
        $file_img7 = $brand_path.'/'.clean_relative_paths($player7_img);
        @unlink($file_img7);
        delete_img_thumbnail(dirname($player7_img), basename($player7_img));
    }

    $player7_img = branch_img_upload($_FILES['player7_img']['tmp_name'], $_FILES['player7_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['basic_order_img']['name']) {
    
	if($w == 'u' && $basic_order_img) {
        $file_img8 = $brand_path.'/'.clean_relative_paths($basic_order_img);
        @unlink($file_img8);
        delete_img_thumbnail(dirname($basic_order_img), basename($basic_order_img));
    }

    $basic_order_img = branch_img_upload($_FILES['basic_order_img']['tmp_name'], $_FILES['basic_order_img']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['guide_file1']['name']) {
    
	if($w == 'u' && $guide_file1) {
        $file_img9 = $brand_path.'/'.clean_relative_paths($guide_file1);
        @unlink($file_img9);
        delete_img_thumbnail(dirname($guide_file1), basename($guide_file1));
    }

    $guide_file1 = branch_img_upload($_FILES['guide_file1']['tmp_name'], $_FILES['guide_file1']['name'], $brand_path."/".$branch_cd);

}

if ($_FILES['guide_file2']['name']) {
    
	if($w == 'u' && $guide_file2) {
        $file_img10 = $brand_path.'/'.clean_relative_paths($guide_file2);
        @unlink($file_img10);
        delete_img_thumbnail(dirname($guide_file2), basename($guide_file2));
    }

    $guide_file2 = branch_img_upload($_FILES['guide_file2']['tmp_name'], $_FILES['guide_file2']['name'], $brand_path."/".$branch_cd);

}


if($w==""){

	$guide_title = $branch_nm."({$branch_cd}) 지점 이용안내";
				
	$sql = " insert into {$DM['BASE_GUIDE_TABLE']} 
				set branch_cd						=	'{$branch_cd}',
					guide_title						=	'{$guide_title}',
					guide_file1						=	'{$guide_file1}',
					guide_file2						=	'{$guide_file2}',
					guide_player2_img				=	'{$player2_img}',
					guide_player3_img				=	'{$player3_img}',
					guide_player4_img				=	'{$player4_img}',
					guide_player5_img				=	'{$player5_img}',
					guide_player6_img				=	'{$player6_img}',
					guide_player7_img				=	'{$player7_img}',
					guide_basic_order_img			=	'{$basic_order_img}',
					guide_operation_guide_movie		=	'{$posts['branch_operation_guide_movie']}',
					guide_reg_dt					=	'".G5_TIME_YMDHIS."'";

	 sql_query($sql);

}else{

	//update
	$guide_title = $branch_nm."({$branch_cd}) 지점 이용안내";
	
	$sql = " update {$DM['BASE_GUIDE_TABLE']} 
				set guide_title						=	'{$guide_title}',
					guide_file1						=	'{$guide_file1}',
					guide_file2						=	'{$guide_file2}',
					guide_player2_img				=	'{$player2_img}',
					guide_player3_img				=	'{$player3_img}',
					guide_player4_img				=	'{$player4_img}',
					guide_player5_img				=	'{$player5_img}',
					guide_player6_img				=	'{$player6_img}',
					guide_player7_img				=	'{$player7_img}',
					guide_basic_order_img			=	'{$basic_order_img}',
					guide_operation_guide_movie		=	'{$posts['branch_operation_guide_movie']}',
					guide_mod_dt					=	'".G5_TIME_YMDHIS."'
				where branch_cd	 =	'{$branch_cd}'
			";

	 sql_query($sql);

}

goto_url("./base_guide_register.php?{$qstr}&amp;w=u&amp;branch_cd=".$branch_cd);