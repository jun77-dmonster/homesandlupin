<?php
$sub_menu = '100100';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$site_nm = isset($_POST['site_nm']) ? strip_tags(clean_xss_attributes($_POST['site_nm'])) : '';

$posts = array();

$check_keys = array('site_nm','com_nm', 'ceo_nm', 'biz_addr_zip', 'biz_addr_basic', 'biz_addr_detail', 'biz_addr_road_basic', 'biz_addr_road_detail', 'cscenter_number', 'cscenter_email', 'cscenter_time', 'app_version', 'sc_admin', 'sc_possible_ip', 'sc_intercept_ip', 'sc_image_extension', 'sc_filter', 'sc_prohibit_id', 'sc_prohibit_email');

foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}

$sql = " update {$DM['SITE_CONFIG_TABLE']} 
			set site_nm					=	'{$posts['site_nm']}',
				com_nm					=	'{$posts['com_nm']}',
				ceo_nm					=	'{$posts['ceo_nm']}',
				biz_addr_zip			=	'{$posts['biz_addr_zip']}',
				biz_addr_basic			=	'{$posts['biz_addr_basic']}',
				biz_addr_detail			=	'{$posts['biz_addr_detail']}',
				biz_addr_road_basic		=	'{$posts['biz_addr_road_basic']}',
				biz_addr_road_detail	=	'{$posts['biz_addr_road_detail']}',
				cscenter_number			=	'{$posts['cscenter_number']}',
				cscenter_email			=	'{$posts['cscenter_email']}',
				cscenter_time			=	'{$posts['cscenter_time']}',
				app_version				=	'{$posts['app_version']}',
				sc_admin				=	'{$posts['sc_admin']}',
				sc_possible_ip			=	'{$posts['sc_possible_ip']}',
				sc_intercept_ip			=	'{$posts['sc_intercept_ip']}',
				sc_image_extension		=	'{$posts['sc_image_extension']}',
				sc_filter				=	'{$posts['sc_filter']}',
				sc_prohibit_id			=	'{$posts['sc_prohibit_id']}',
				sc_prohibit_email		=	'{$posts['sc_prohibit_email']}'
			where site_id = '{$DM['SITE_ID']}'";

echo $sql;


$r1 = sql_query($sql);

if($r1==1){
	goto_url("./basic_info.php",false);
}else{
	alert("기본 환경 설정 업데이트 실패");
}