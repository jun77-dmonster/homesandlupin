<?php
$sub_menu = '100300';
include_once('./_common.php');

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택수정"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$item_cd = isset($_POST['item_cd'][$k]) ? clean_xss_tags($_POST['item_cd'][$k], 1, 1) : '';
		$item_nm = isset($_POST['item_nm'][$k]) ? clean_xss_tags($_POST['item_nm'][$k], 1, 1) : '';
		$item_order = isset($_POST['item_order'][$k]) ? clean_xss_tags($_POST['item_order'][$k], 1, 1) : '';
		$use_fl = isset($_POST['use_fl'][$k]) ? clean_xss_tags($_POST['use_fl'][$k], 1, 1) : '';

		$sql = " update {$DM['CODE_TABLE']} 
					set item_nm = '{$item_nm}',
						item_order = '{$item_order}',
						use_fl = '{$use_fl}'
					where item_cd = '{$item_cd}'";	

		sql_query($sql);

	}

}else if($act_button === "선택삭제"){


}

goto_url("./base_code_list.php?".$qstr);