<?php
$sub_menu = '200730';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$beverage_cate			=	isset($_POST['beverage_cate']) ? strip_tags(clean_xss_attributes($_POST['beverage_cate'])) : '';
$beverage_cd			=	isset($_POST['beverage_cd']) ? strip_tags(clean_xss_attributes($_POST['beverage_cd'])) : '';
$beverage_kor_nm		=	isset($_POST['beverage_kor_nm']) ? strip_tags(clean_xss_attributes($_POST['beverage_kor_nm'])) : '';
$beverage_eng_nm		=	isset($_POST['beverage_eng_nm']) ? strip_tags(clean_xss_attributes($_POST['beverage_eng_nm'])) : '';
$beverage_price			=	isset($_POST['beverage_price']) ? $_POST['beverage_price'] : '0';
$beverage_display_fl	=	isset($_POST['beverage_display_fl']) ? strip_tags(clean_xss_attributes($_POST['beverage_display_fl'])) : 'F';
$beverage_best_icon		=	!empty($_POST['beverage_best_icon']) ? "T" : "F";
$beverage_new_icon		=	!empty($_POST['beverage_new_icon']) ? "T" : "F";


if (!$beverage_cd) { alert('푸드 코드는 반드시 입력하세요.'); }
if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $beverage_cd)) { alert('푸드코드는 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)'); }

if (!$beverage_kor_nm || !$beverage_eng_nm) { alert('푸드 이름을 입력하세요.'); }

if($beverage_price==0){ alert('푸드 가격은 0보다 커야 합니다'); }

echo $beverage_cate."<br>";
echo $beverage_cd."<br>";
echo $beverage_kor_nm."<br>";
echo $beverage_eng_nm."<br>";
echo $beverage_price."<br>";
echo $beverage_display_fl."<br>";
echo $beverage_best_icon."<br>";
echo $beverage_new_icon."<br>";

//선택옵션
sql_query(" delete from {$DM['BEVERAGE_OPTION_TABLE']} where beverage_op_type = '0' and beverage_code = '$beverage_cd' "); // 기존선택옵션삭제

$option_count = (isset($_POST['opt_id']) && is_array($_POST['opt_id'])) ? count($_POST['opt_id']) : array();
$beverage_option_subject = '';

if($option_count) {
    // 옵션명
    $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
    for($i=0; $i<$option_count; $i++) {
        $post_opt_id = isset($_POST['opt_id'][$i]) ? preg_replace(G5_OPTION_ID_FILTER, '', strip_tags($_POST['opt_id'][$i])) : '';

        $opt_val = explode(chr(30), $post_opt_id);
        if(isset($opt_val[0]) && $opt_val[0])
            $opt1_cnt++;
        if(isset($opt_val[1]) && $opt_val[1])
            $opt2_cnt++;
        if(isset($opt_val[2]) && $opt_val[2])
            $opt3_cnt++;
    }

    if($opt1_subject && $opt1_cnt) {
        $beverage_option_subject = $opt1_subject;
        if($opt2_subject && $opt2_cnt)
            $beverage_option_subject .= ','.$opt2_subject;
        if($opt3_subject && $opt3_cnt)
            $beverage_option_subject .= ','.$opt3_subject;
    }
}

// 추가옵션
sql_query(" delete from {$DM['BEVERAGE_OPTION_TABLE']} where beverage_op_type = '1' and beverage_code = '$beverage_cd' "); // 기존추가옵션삭제

$supply_count = (isset($_POST['spl_id']) && is_array($_POST['spl_id'])) ? count($_POST['spl_id']) : array();
if($supply_count) {
    // 추가옵션명
    $arr_spl = array();
    for($i=0; $i<$supply_count; $i++) {
        $post_spl_id = isset($_POST['spl_id'][$i]) ? preg_replace(G5_OPTION_ID_FILTER, '', strip_tags($_POST['spl_id'][$i])) : '';

        $spl_val = explode(chr(30), $post_spl_id);
        if(!in_array($spl_val[0], $arr_spl))
            $arr_spl[] = $spl_val[0];
    }

    $beverage_supply_subject = implode(',', $arr_spl);

	echo $beverage_supply_subject;
}

$beverage_path = G5_DATA_PATH.'/beverage';

// 게시판 디렉토리 생성
@mkdir($beverage_path, G5_DIR_PERMISSION);
@chmod($beverage_path, G5_DIR_PERMISSION);

$beverage_file = "";

if($w=="u"){

	$sql = " select beverage_file from {$DM['BEVERAGE_TABLE']} where beverage_cd='{$beverage_cd}'";

	$file = sql_fetch($sql);

	$game_file	=	$file['beverage_file'];

}

${'beverage_file_del'}	= !empty($_POST['beverage_file_del']) ? 1 : 0;


//파일 삭제
if ($beverage_file_del) {

	$file_img1 = $beverage_path.'/'.clean_relative_paths($beverage_file);
	@unlink($file_img1);
    delete_img_thumbnail(dirname($beverage_file), basename($beverage_file));
    $beverage_file = '';

}

// 이미지업로드
if ($_FILES['beverage_file']['name']) {
    
	if($w == 'u' && $beverage_file) {
        $file_img1 = $$beverage_path.'/'.clean_relative_paths($beverage_file);
        @unlink($file_img1);
        delete_img_thumbnail(dirname($beverage_file), basename($beverage_file));
    }

    $beverage_file = beverage_img_upload($_FILES['beverage_file']['tmp_name'], $_FILES['beverage_file']['name'], $beverage_path."/".$beverage_cd);

}


//등록
$sql_common = " beverage_cate			= '{$beverage_cate}',
				beverage_kor_nm			= '{$beverage_kor_nm}',
				beverage_eng_nm			= '{$beverage_eng_nm}',
				beverage_price			= '{$beverage_price}',
				beverage_file			= '{$beverage_file}',
				beverage_display_fl		= '{$beverage_display_fl}',
				beverage_option_subject = '{$beverage_option_subject}',
				beverage_best_icon		= '{$beverage_best_icon}',
				beverage_new_icon		= '{$beverage_new_icon}'";

if($w==""){

	$sql_common .= " , beverage_reg_dt = '".G5_TIME_YMDHIS."' ";
    $sql_common .= " , beverage_mod_dt = '".G5_TIME_YMDHIS."' ";

	$sql = " insert {$DM['BEVERAGE_TABLE']}
                set beverage_cd = '$beverage_cd',
					$sql_common	";
    sql_query($sql);

}else{

	//수정
	$sql_common .= " , beverage_mod_dt = '".G5_TIME_YMDHIS."' ";
    $sql = " update {$DM['BEVERAGE_TABLE']}
                set $sql_common
              where beverage_cd = '$beverage_cd' ";
    sql_query($sql);

}

// 선택옵션등록
if($option_count) {
    $comma = '';
    $sql = " INSERT INTO {$DM['BEVERAGE_OPTION_TABLE']}
                    ( `beverage_op_id`, `beverage_op_type`, `beverage_code`, `beverage_op_price`, `beverage_op_use_fl` )
                VALUES ";
    for($i=0; $i<$option_count; $i++) {
        $sql .= $comma . " ( '{$_POST['opt_id'][$i]}', '0', '$beverage_cd', '{$_POST['opt_price'][$i]}', '{$_POST['opt_use'][$i]}' )";
        $comma = ' , ';
    }

    sql_query($sql);
}

// 추가옵션등록
if($supply_count) {
    $comma = '';
    $sql = " INSERT INTO {$DM['BEVERAGE_OPTION_TABLE']}
                    ( `beverage_op_id`, `beverage_op_type`, `beverage_code`, `beverage_op_price`, `beverage_op_use_fl` )
                VALUES ";
    for($i=0; $i<$supply_count; $i++) {
        $sql .= $comma . " ( '{$_POST['spl_id'][$i]}', '1', '$beverage_cd', '{$_POST['spl_price'][$i]}', '{$_POST['spl_use'][$i]}' )";
        $comma = ' , ';
    }

    sql_query($sql);
}

$qstr = "$qstr&amp;sca=$sca&amp;page=$page";

if ($w == "u") {
    goto_url("./food_register.php?w=u&amp;beverage_cd=$beverage_cd&amp;$qstr");
} else if ($w == "d")  {
    $qstr = "beverage_cate=$beverage_cate&amp;sfl=$sfl&amp;sca=$sca&amp;page=$page&amp;stx=".urlencode($stx)."&amp;save_stx=".urlencode($save_stx);
    goto_url("./food_list.php?$qstr");
}

echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
?>
<script>
    if (confirm("계속 입력하시겠습니까?"))
        location.href = "<?php echo "./food_register.php?".str_replace('&amp;', '&', $qstr); ?>";
    else
        location.href = "<?php echo "./food_list.php?".str_replace('&amp;', '&', $qstr); ?>";
</script>