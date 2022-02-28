<?php
$sub_menu = '100300';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");


$item_cd = isset($_POST['item_cd']) ? clean_xss_attributes($_POST['item_cd']) : '';

$item_nm = isset($_POST['item_nm']) ? clean_xss_attributes($_POST['item_nm']) : '';

$category_group_cd = substr($item_cd,0,2);
$group_cd = substr($item_cd,0,5);

if($w==""){

	//카테고리 체크
	$item = get_code($item_cd);

	if (isset($item['item_cd']) && $item['item_cd'])
        alert('이미 사용중인 카테고리코드입니다.\\n CODE : '.$item['item_cd'].'\\n항목명 : '.$item['item_nm']);

	
	$sql = " insert into {$DM['CODE_TABLE']} 
				set category_group_cd	= '{$category_group_cd}',
					group_cd			= '{$group_cd}',
					item_cd				= '{$item_cd}',
					item_nm				= '{$item_nm}'";

	sql_query($sql);

}else if($w=="u"){

}else{

	alert('제대로 된 값이 넘어오지 않았습니다.');

}


goto_url('./base_code_list.php?'.$qstr.'&amp;w=u&amp;categoryGroupCd='.$category_group_cd."&amp;groupCd=".$group_cd, false);