<?php
include_once('./_common.php');

$ps_run = false;
$post_beverage_cd = isset($_POST['beverage_cd']) ? safe_replace_regex($_POST['beverage_cd'], 'beverage_cd') : '';

if(isset($row['beverage_cd']) && $row['beverage_cd']) {
    $sql = " select * from {$DM['BEVERAGE_OPTION_TABLE']} where beverage_op_type = '1' and beverage_code = '{$row['beverage_cd']}' order by beverage_op_no asc ";
    $result = sql_query($sql);
    if(sql_num_rows($result))
        $ps_run = true;
} else if(!empty($_POST)) {
    $subject_count = (isset($_POST['subject']) && is_array($_POST['subject'])) ? count($_POST['subject']) : 0;
    $supply_count = (isset($_POST['supply']) && is_array($_POST['supply'])) ? count($_POST['supply']) : 0;

    if(!$subject_count || !$supply_count) {
        echo '추가옵션명과 추가옵션항목을 입력해 주십시오.';
        exit;
    }

    $ps_run = true;
}
if($ps_run) {
?>
<div class="sit_option_frm_wrapper">
    <table>
    <caption>추가옵션 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="spl_chk_all" class="sound_only">전체 추가옵션</label>
            <input type="checkbox" name="spl_chk_all" value="1">
        </th>>
		<th scope="col">옵션명</th>
		<th scope="col">옵션명</th>
        <th scope="col">상품금액</th>
        <th scope="col">사용여부</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(isset($row['beverage_cd']) && $row['beverage_cd']) {
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $spl_id = $row['beverage_op_id'];
            $spl_val = explode(chr(30), $spl_id);
            $spl_subject = $spl_val[0];
            $spl = $spl_val[1];
            $spl_price = $row['beverage_op_price'];
            $spl_use = $row['beverage_op_use_fl'];
    ?>
    <tr>
        <td class="td_chk">
            <input type="hidden" name="spl_id[]" value="<?php echo $spl_id; ?>">
            <label for="spl_chk_<?php echo $i; ?>" class="sound_only"><?php echo $spl_subject.' '.$spl; ?></label>
            <input type="checkbox" name="spl_chk[]" id="spl_chk_<?php echo $i; ?>" value="1">
        </td>
        <td class="spl-subject-cell"><?php echo $spl_subject; ?></td>
        <td class="spl-cell"><?php echo $spl; ?></td>
        <td class="td_numsmall">
            <label for="spl_price_<?php echo $i; ?>" class="sound_only">상품금액</label>
            <input type="text" name="spl_price[]" value="<?php echo $spl_price; ?>" id="spl_price_<?php echo $i; ?>" class="frm_input" size="5">
        </td>
        <td class="td_mng">
            <label for="spl_use_<?php echo $i; ?>" class="sound_only">사용여부</label>
            <select name="spl_use[]" id="spl_use_<?php echo $i; ?>">
                <option value="1" <?php echo get_selected('1', $spl_use); ?>>사용함</option>
                <option value="0" <?php echo get_selected('0', $spl_use); ?>>사용안함</option>
            </select>
        </td>
    </tr>
    <?php
        } // for
    } else {
        for($i=0; $i<$subject_count; $i++) {
            $spl_subject = isset($_POST['subject'][$i]) ? preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['subject'][$i]))) : '';
            $spl_val = isset($_POST['supply'][$i]) ? explode(',', preg_replace(G5_OPTION_ID_FILTER, '', trim(stripslashes($_POST['supply'][$i])))) : '';
            $spl_count = count($spl_val);

            for($j=0; $j<$spl_count; $j++) {
                $spl = isset($spl_val[$j]) ? strip_tags(trim($spl_val[$j])) : '';
                if($spl_subject && strlen($spl)) {
                    $spl_id = $spl_subject.chr(30).$spl;
                    $spl_price = 0;
                    $spl_use = 1;

                    // 기존에 설정된 값이 있는지 체크
                    if(isset($_POST['w']) && $_POST['w'] === 'u') {
						 $sql = " select beverage_op_price, beverage_op_use_fl
                                    from {$DM['BEVERAGE_OPTION_TABLE']}
                                    where beverage_code = '{$post_beverage_cd}'
                                      and beverage_op_id = '$spl_id'
                                      and beverage_op_type = '1' ";
                        $row3 = sql_fetch($sql);

                        if($row3) {
                            $spl_price = (int)$row3['beverage_op_price'];
                            $spl_use = (int)$row3['beverage_op_use_fl'];
                        }
                    }
    ?>
    <tr>
        <td class="td_chk">
            <input type="hidden" name="spl_id[]" value="<?php echo $spl_id; ?>">
            <label for="spl_chk_<?php echo $i; ?>" class="sound_only"><?php echo $spl_subject.' '.$spl; ?></label>
            <input type="checkbox" name="spl_chk[]" id="spl_chk_<?php echo $i; ?>" value="1">
        </td>
        <td class="spl-subject-cell"><?php echo $spl_subject; ?></td>
        <td class="spl-cell"><?php echo $spl; ?></td>
        <td class="td_numsmall">
            <label for="spl_price_<?php echo $i; ?>" class="sound_only">상품금액</label>
            <input type="text" name="spl_price[]" value="<?php echo $spl_price; ?>" id="spl_price_<?php echo $i; ?>" class="frm_input" size="9">
        </td>
        <td class="td_mng">
            <label for="spl_use_<?php echo $i; ?>" class="sound_only">사용여부</label>
            <select name="spl_use[]" id="spl_use_<?php echo $i; ?>">
                <option value="1" <?php echo get_selected('1', $spl_use); ?>>사용함</option>
                <option value="0" <?php echo get_selected('0', $spl_use); ?>>사용안함</option>
            </select>
        </td>
    </tr>
    <?php
                } // if
            } // for
        } // for
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <button type="button" id="sel_supply_delete" class="btn btn_02">선택삭제</button>
</div>


<?php
}