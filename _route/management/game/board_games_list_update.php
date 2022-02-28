<?php
$sub_menu = '200610';
include_once('./_common.php');

check_demo();

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
		$games_cd = isset($_POST['games_cd'][$k]) ? clean_xss_tags($_POST['games_cd'][$k], 1, 1) : '';
		$branch_display_fl = isset($_POST['branch_display_fl'][$k]) ? clean_xss_tags($_POST['branch_display_fl'][$k], 1, 1) : '';

		$sql = " update {$DM['BOARD_GAMES_TABLE']} 
					set branch_display_fl = '{$branch_display_fl}'
					where games_cd = '{$games_cd}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("게임 수정에 실패 했습니다");
		}

	}



}else if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$games_cd = isset($_POST['games_cd'][$k]) ? clean_xss_tags($_POST['games_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BOARD_GAMES_TABLE']} 
					set games_delete_fl = 'T'
					where games_cd = '{$games_cd}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("게임 삭제에 실패 했습니다");
		}

	}

}else if($act_button === "선택다운로드"){

	auth_check_menu($auth, $sub_menu, 'w');
	
	if(! function_exists('column_char')) {
		function column_char($i) {
			return chr( 65 + $i );
		}
	}

	include_once(G5_LIB_PATH.'/PHPExcel.php');

	$headers = array('게임코드', '게임이름');
	$widths  = array(15, 85);
	$header_bgcolor = 'FFABCDEF';
	$last_char = column_char(count($headers) - 1);

	 for ($i=0; $i<$post_count_chk; $i++) {

		$k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$games_cd = isset($_POST['games_cd'][$k]) ? clean_xss_tags($_POST['games_cd'][$k], 1, 1) : '';
		$games_nm = isset($_POST['games_nm'][$k]) ? clean_xss_tags($_POST['games_nm'][$k], 1, 1) : '';

		 $rows[] = array($games_cd,$games_nm);

	 }

	 $data = array_merge(array($headers), $rows);

	$excel = new PHPExcel();
	$excel->setActiveSheetIndex(0)->getStyle( "A1:${last_char}1" )->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
	$excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
	foreach($widths as $i => $w) $excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);
	$excel->getActiveSheet()->fromArray($data,NULL,'A1');

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"games-".date("ymd", time()).".xls\"");
	header("Cache-Control: max-age=0");

	$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	$writer->save('php://output');

	exit;


}else{

	alert("비정상적으로 접근 했습니다");

}

goto_url("./board_games_list.php?$qstr");

