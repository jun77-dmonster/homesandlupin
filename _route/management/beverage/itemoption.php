<?php
include_once('./_common.php');

$po_run = false;

if(isset($row['beverage_cd']) && $row['beverage_cd']) {
    $opt_subject = explode(',', $row['beverage_option_subject']);
    $opt1_subject = isset($opt_subject[0]) ? $opt_subject[0] : '';
    //$opt2_subject = isset($opt_subject[1]) ? $opt_subject[1] : '';
    //$opt3_subject = isset($opt_subject[2]) ? $opt_subject[2] : '';

    $sql = " select * from {$DM['BEVERAGE_OPTION_TABLE']} where beverage_op_type = '0' and beverage_code = '{$row['beverage_cd']}' order by beverage_op_no asc ";

    $result = sql_query($sql);
    if(sql_num_rows($result))
        $po_run = true;
} else if(!empty($_POST)) {
    $opt1_subject = isset($_POST['opt1_subject']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt1_subject']))) : '';

    //$opt2_subject = isset($_POST['opt2_subject']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt2_subject']))) : '';
    //$opt3_subject = isset($_POST['opt3_subject']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt3_subject']))) : '';

    $opt1_val = isset($_POST['opt1']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt1']))) : '';	
	//$opt2_val = isset($_POST['opt2']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt2']))) : '';
    //$opt3_val = isset($_POST['opt3']) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['opt3']))) : '';

    if(!$opt1_subject || !$opt1_val) {
        echo '옵션1과 옵션1 항목을 입력해 주십시오.';
        exit;
    }

    $po_run = true;

    $opt1_count = $opt2_count = $opt3_count = 0;

    if($opt1_val) {
        $opt1 = explode(',', $opt1_val);
        $opt1_count = count($opt1);
    }

    /*
	if($opt2_val) {
        $opt2 = explode(',', $opt2_val);
        $opt2_count = count($opt2);
    }

    if($opt3_val) {
        $opt3 = explode(',', $opt3_val);
        $opt3_count = count($opt3);
    }
	*/
}

if($po_run) {
?>

<div class="sit_option_frm_wrapper">
    <table class="ncp_tbl">
    <caption>옵션 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="opt_chk_all" class="sound_only">전체 옵션</label>
            <input type="checkbox" name="opt_chk_all" value="1" id="opt_chk_all">
        </th>
        <th scope="col">옵션</th>
        <th scope="col">추가금액</th>
        <!--<th scope="col">재고수량</th>
        <th scope="col">통보수량</th>-->
        <th scope="col">사용여부</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(isset($row['beverage_cd']) && $row['beverage_cd']) {
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $opt_id = $row['beverage_op_id'];

			echo $opt_id;

            $opt_val = explode(chr(30), $opt_id);

            $opt_1 = $opt_val[0];
            $opt_2 = isset($opt_val[1]) ? $opt_val[1] : '';
            $opt_3 = isset($opt_val[2]) ? $opt_val[2] : '';

            $opt_2_len = strlen($opt_2);
            $opt_3_len = strlen($opt_3);
            $opt_price = $row['beverage_op_price'];
            $opt_use = $row['beverage_op_use_fl'];
    ?>
    <tr>
        <td class="td_chk">
            <input type="hidden" name="opt_id[]" value="<?php echo $opt_id; ?>">
            <label for="opt_chk_<?php echo $i; ?>" class="sound_only"></label>
            <input type="checkbox" name="opt_chk[]" id="opt_chk_<?php echo $i; ?>" value="1">
        </td>
        <td class="opt-cell"><?php echo $opt_1; if ($opt_2_len) echo ' <small>&gt;</small> '.$opt_2; if ($opt_3_len) echo ' <small>&gt;</small> '.$opt_3; ?></td>
        <td class="td_numsmall">
            <label for="opt_price_<?php echo $i; ?>" class="sound_only"></label>
            <input type="text" name="opt_price[]" value="<?php echo $opt_price; ?>" id="opt_price_<?php echo $i; ?>" class="frm_input" size="9">
        </td>
        <td class="td_mng">
            <label for="opt_use_<?php echo $i; ?>" class="sound_only"></label>
            <select name="opt_use[]" id="opt_use_<?php echo $i; ?>">
                <option value="T" <?php echo get_selected('T', $opt_use); ?>>사용함</option>
                <option value="F" <?php echo get_selected('F', $opt_use); ?>>사용안함</option>
            </select>
        </td>
    </tr>
    <?php
        } // for
    } else {
        
        $w = isset($_POST['w']) ? $_POST['w'] : '';
        $post_it_id = isset($_POST['beverage_cd']) ? safe_replace_regex($_POST['beverage_cd'], 'beverage_cd') : '';

        for($i=0; $i<$opt1_count; $i++) {
            $j = 0;
            do {
                $k = 0;
                do {
                    $opt_1 = isset($opt1[$i]) ? strip_tags(trim($opt1[$i])) : '';
                    $opt_2 = isset($opt2[$j]) ? strip_tags(trim($opt2[$j])) : '';
                    $opt_3 = isset($opt3[$k]) ? strip_tags(trim($opt3[$k])) : '';

                    $opt_2_len = strlen($opt_2);
                    $opt_3_len = strlen($opt_3);

                    $opt_id = $opt_1;
                    if($opt_2_len)
                        $opt_id .= chr(30).$opt_2;
                    if($opt_3_len)
                        $opt_id .= chr(30).$opt_3;
                    $opt_price = 0;
                    $opt_use = 1;

                    // 기존에 설정된 값이 있는지 체크
                    if($w === 'u') {
                        $sql = " select beverage_op_price, beverage_op_use_fl
                                    from {$DM['BEVERAGE_OPTION_TABLE']}
                                    where beverage_code = '{$post_it_id}'
                                      and beverage_op_id = '$opt_id'
                                      and beverage_op_type = '0' ";
                        $row = sql_fetch($sql);

                        if($row) {
                            $opt_price = (int)$row['beverage_op_price'];
                            $opt_use = (int)$row['beverage_op_use_fl'];
                        }
                    }
    ?>
    <tr>
        <td class="td_chk">
            <input type="hidden" name="opt_id[]" value="<?php echo $opt_id; ?>">
            <label for="opt_chk_<?php echo $i; ?>" class="sound_only"></label>
            <input type="checkbox" name="opt_chk[]" id="opt_chk_<?php echo $i; ?>" value="1">
        </td>
        <td class="opt-cell"><?php echo $opt_1; if ($opt_2_len) echo ' <small>&gt;</small> '.$opt_2; if ($opt_3_len) echo ' <small>&gt;</small> '.$opt_3; ?></td>
        <td class="td_numsmall">
            <label for="opt_price_<?php echo $i; ?>" class="sound_only"></label>
            <input type="text" name="opt_price[]" value="<?php echo $opt_price; ?>" id="opt_price_<?php echo $i; ?>" class="frm_input" size="9">
        </td>
        <td class="td_mng">
            <label for="opt_use_<?php echo $i; ?>" class="sound_only"></label>
            <select name="opt_use[]" id="opt_use_<?php echo $i; ?>">
                <option value="1" <?php echo get_selected('1', $opt_use); ?>>사용함</option>
                <option value="0" <?php echo get_selected('0', $opt_use); ?>>사용안함</option>
            </select>
        </td>
    </tr>
    <?php
                    $k++;
                } while($k < $opt3_count);

                $j++;
            } while($j < $opt2_count);
        } // for
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="button" value="선택삭제" id="sel_option_delete" class="btn btn_02">
</div>
<?php
}