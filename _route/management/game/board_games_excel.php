<?php
$sub_menu = '200610';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql  = "select games_cd, games_nm from {$DM['BOARD_GAMES_TABLE']} where games_delete_fl='F' order by games_nm asc  ";


$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if (!$cnt)
	alert("출력할 내역이 없습니다.");

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

 for($i=1; $row=sql_fetch_array($result); $i++) {

	 $rows[] = array($row['games_cd'],$row['games_nm']);

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




?>

