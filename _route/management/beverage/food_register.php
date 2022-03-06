<?php
$sub_menu = '200730';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
	$row = sql_fetch("select * from {$DM['BEVERAGE_TABLE']} where beverage_cd='{$beverage_cd}'");
}

//푸드카테고리
$beverage_cate = '';
$beverage_cate_code = '02002';
$sql = " select * from {$DM['CODE_TABLE']} where group_cd ='{$beverage_cate_code}' and length(item_cd)='8' ";
$r1 = sql_query($sql);

for ($i=0; $c1=sql_fetch_array($r1); $i++)
{
    $beverage_cate .= "<option value=\"{$c1['item_cd']}\">$nbsp{$c1['item_nm']}</option>\n";
}

$g5['title'] = '푸드 '.$title;
include_once ('../../admin.head.php');
?>

<form name="frmBeverageGame" method="post" action="./food_register_update.php" onsubmit="return frmBeverageGameChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">

	<div class="view-title">
		푸드 기본 정보
	</div>

	<div class="box-cont">
		
		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>식음료카테고리</th>
			<td>
				<div class="inputbox-wrap">
					<select name="beverage_cate" style="width:400px;">
						<option value="">카테고리를 선택하세요</option>
						<?php echo conv_selected_option2($beverage_cate, $row['beverage_cate']); ?>
					</select>					
				</div>
			</td>
			<th>푸드 코드</th>
			<td>
				<div class="inputbox-wrap">
				<?php if($w==""){?>
				<input type="text" name="beverage_cd" class="frm_input" value="<?php echo get_beverage_uniqid()?>" style="width:400px;" readonly placeholder="자동생성">
				<?php }else{?>
				<input type="text" name="beverage_cd" class="frm_input" value="<?php echo $row['beverage_cd']?>" style="width:400px;" readonly placeholder="자동생성">
				<?php }?>
				</div>
			</td>
		</tr>
		<tr>
			<th>푸드 이름(한글)</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="beverage_kor_nm" class="frm_input" value="<?php echo $row['beverage_kor_nm']?>" style='width:400px;' placeholder="한글, 숫자만 입력 가능합니다(20자내외)" maxlength="20">
				</div>
			</td>
			<th>푸드 이름(영문)</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="beverage_eng_nm" class="frm_input" value="<?php echo $row['beverage_eng_nm']?>" style='width:400px;' placeholder="영문, 숫자만 입력 가능합니다(30자내외)" maxlength="30">
				</div>
			</td>
		</tr>
		<tr>
			<th>가격</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="beverage_price" class="frm_input" value="<?php echo $row['beverage_price']?>" style='width:400px;' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="숫자만 입력 가능합니다">
				</div>
			</td>
			<th>노출여부</th>
			<td>
				<div class="inputbox-wrap">
				<select name="beverage_display_fl">
					<option value="T" <?php echo ($row['beverage_display_fl']=="T")?"selected":""?>>노출</option>
					<option value="F" <?php echo ($row['beverage_display_fl']=="F")?"selected":""?>>미노출</option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>상품유형</th>
			<td colspan="3">
				<div class="inputbox-wrap">
					<span class="checkbox_item marR10">
						<input type="checkbox" name="beverage_best_icon"  value="T" id="beverage_best_icon" <?php echo ($row['beverage_best_icon']=="T" || $w=="")?"checked":""?>>
							<label for="beverage_best_icon" >베스트</label>
					</span>

					<span class="checkbox_item marR10">
						<input type="checkbox" name="beverage_new_icon"  value="T" id="beverage_new_icon" <?php echo ($row['beverage_new_icon']=="T")?"checked":""?>>
							<label for="beverage_new_icon" >신상</label>
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<th>상품이미지</th>
			<td>
				<div class="inputbox-wrap">
				<input type="file" name="beverage_file" id="beverage_file" class="frm_input" value="<?php echo $row['beverage_file']?>" style='width:390px;'>
				<?php if($w==="u" && $row['beverage_file']){?>
				<label for="beverage_file_del"><span class="sound_only">푸드이미지 </span>파일삭제</label>
				<input type="checkbox" name="beverage_file_del" id="beverage_file_del" value="1">
				<?php }?>
				</div>
			</td>
			<td colspan="2">
				<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

					<div class="banner-preview slick-initialized slick-slider">

						<div class="slide-item" style="width: 100%; display: inline-block;">
							<?
							$beverage_file = G5_DATA_PATH."/beverage/".$row['beverage_file'];	
							?>
							<div class="img_banner_wrap">
							<?php if($w==="u" && $row['beverage_file'] ){?>
							<img src="<?php echo G5_DATA_URL?>/beverage/<?php echo $row['beverage_file']?>" id="banner_img">
							<?php }else{?>
							<img src="<?php echo G5_ROUTE_URL?>/img/img_slide_sample01.png" id="banner_img">
							<?php }?>
							</div>

						</div>

					</div>

				</div>
			</td>
		</tr>
		</table>

	</div>

	<div class="view-title">
		푸드 옵션정보
	</div>

	<div class="box-cont">
		<?php
        $opt_subject = explode(',', $row['beverage_option_subject']);
        ?>
		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>선택옵션</th>
			<td>
				<div class="sit_option tbl_frm01">
					<?php echo help('옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다. 음료를 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : 스몰,레귤러,라지] , [옵션2 : 샷추가 , 옵션2 항목 : +1,+2,+3]<br><strong>옵션명과 옵션항목에 따옴표(\', ")는 입력할 수 없습니다.</strong>'); ?>

					<table>
					<caption>푸드선택옵션 입력</caption>
					<colgroup>
                        <col class="grid_4">
                        <col>
                    </colgroup>
					<tbody>
                    <tr>
                        <th scope="row">
                            <label for="opt1_subject">옵션1</label>
                            <input type="text" name="opt1_subject" value="<?php echo isset($opt_subject[0]) ? $opt_subject[0] : ''; ?>" id="opt1_subject" class="frm_input" size="15">
                        </th>
                        <td>
                            <label for="opt1"><b>옵션1 항목</b></label>
                            <input type="text" name="opt1" value="" id="opt1" class="frm_input" size="50">
                        </td>
                    </tr>
                    <!--
					<tr>
                        <th scope="row">
                            <label for="opt2_subject">옵션2</label>
                            <input type="text" name="opt2_subject" value="<?php echo isset($opt_subject[1]) ? $opt_subject[1] : ''; ?>" id="opt2_subject" class="frm_input" size="15">
                        </th>
                        <td>
                            <label for="opt2"><b>옵션2 항목</b></label>
                            <input type="text" name="opt2" value="" id="opt2" class="frm_input" size="50">
                        </td>
                    </tr>
                     <tr>
                        <th scope="row">
                            <label for="opt3_subject">옵션3</label>
                            <input type="text" name="opt3_subject" value="<?php echo isset($opt_subject[2]) ? $opt_subject[2] : ''; ?>" id="opt3_subject" class="frm_input" size="15">
                        </th>
                        <td>
                            <label for="opt3"><b>옵션3 항목</b></label>
                            <input type="text" name="opt3" value="" id="opt3" class="frm_input" size="50">
                        </td>
                    </tr>
					-->
                    </tbody>
                    </table>
                    <div class="btn_confirm02 btn_confirm">
                        <button type="button" id="option_table_create" class="btn_frmline">옵션목록생성</button>
                    </div>
				
				</div>
				<div id="sit_option_frm"><?php include_once(G5_ROUTE_PATH.'/management/beverage/itemoption.php'); ?></div>

				<script>
                $(function() {
                    <?php if($beverage_cd && $po_run) { ?>
                    //옵션항목설정
                    var arr_opt1 = new Array();
                    //var arr_opt2 = new Array();
                    //var arr_opt3 = new Array();
                    //var opt1 = opt2 = opt3 = '';
					var opt1 = '';
                    var opt_val;

                    $(".opt-cell").each(function() {
                        opt_val = $(this).text().split(" > ");

                        opt1 = opt_val[0];
                        //opt2 = opt_val[1];
                        //opt3 = opt_val[2];

                        if(opt1 && $.inArray(opt1, arr_opt1) == -1)
                            arr_opt1.push(opt1);

                        /*
						if(opt2 && $.inArray(opt2, arr_opt2) == -1)
                            arr_opt2.push(opt2);

                        if(opt3 && $.inArray(opt3, arr_opt3) == -1)
                            arr_opt3.push(opt3);
						*/
                    });


                    $("input[name=opt1]").val(arr_opt1.join());
                    //$("input[name=opt2]").val(arr_opt2.join());
                    //$("input[name=opt3]").val(arr_opt3.join());
                    <?php } ?>
                    // 옵션목록생성
                    $("#option_table_create").click(function() {
                        var beverage_cd = $.trim($("input[name=beverage_cd]").val());
                        var opt1_subject = $.trim($("#opt1_subject").val());
                        //var opt2_subject = $.trim($("#opt2_subject").val());
                        //var opt3_subject = $.trim($("#opt3_subject").val());
                        var opt1 = $.trim($("#opt1").val());
                        //var opt2 = $.trim($("#opt2").val());
                        //var opt3 = $.trim($("#opt3").val());
                        var $option_table = $("#sit_option_frm");

                        if(!opt1_subject || !opt1) {
                            alert("옵션명과 옵션항목을 입력해 주십시오.");
                            return false;
                        }

                        $.post(
                            "<?php echo G5_ROUTE_URL; ?>/management/beverage/itemoption.php",
                            { beverage_cd: beverage_cd, w: "<?php echo $w; ?>", opt1_subject: opt1_subject, opt1: opt1 },
                            function(data) {
                                $option_table.empty().html(data);
                            }
                        );
                    });

                    // 모두선택
                    $(document).on("click", "input[name=opt_chk_all]", function() {
                        if($(this).is(":checked")) {
                            $("input[name='opt_chk[]']").attr("checked", true);
                        } else {
                            $("input[name='opt_chk[]']").attr("checked", false);
                        }
                    });

                    // 선택삭제
                    $(document).on("click", "#sel_option_delete", function() {
                        var $el = $("input[name='opt_chk[]']:checked");
                        if($el.length < 1) {
                            alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                            return false;
                        }

                        $el.closest("tr").remove();
                    });

                    // 일괄적용
                    $(document).on("click", "#opt_value_apply", function() {
                        if($(".opt_com_chk:checked").length < 1) {
                            alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                            return false;
                        }

                        var opt_price = $.trim($("#opt_com_price").val());
                        var opt_use = $("#opt_com_use").val();
                        var $el = $("input[name='opt_chk[]']:checked");

                        // 체크된 옵션이 있으면 체크된 것만 적용
                        if($el.length > 0) {
                            var $tr;
                            $el.each(function() {
                                $tr = $(this).closest("tr");

                                if($("#opt_com_price_chk").is(":checked"))
                                    $tr.find("input[name='opt_price[]']").val(opt_price);

                                if($("#opt_com_use_chk").is(":checked"))
                                    $tr.find("select[name='opt_use[]']").val(opt_use);
                            });
                        } else {
                            if($("#opt_com_price_chk").is(":checked"))
                                $("input[name='opt_price[]']").val(opt_price);

                            if($("#opt_com_use_chk").is(":checked"))
                                $("select[name='opt_use[]']").val(opt_use);
                        }
                    });
                });
                </script>
			</td>
		</tr>
		<?php
		$spl_subject = explode(',', $row['beverage_supply_subject']);
		$spl_count = count($spl_subject);
		?>
		<tr>
			<th>추가옵션</th>
			<td>
				<div id="sit_supply_frm" class="sit_option tbl_frm01">
                    <?php echo help('옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다. 음료를 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : 스몰,레귤러,라지] , [옵션2 : 샷추가 , 옵션2 항목 : +1,+2,+3]<br><strong>옵션명과 옵션항목에 따옴표(\', ")는 입력할 수 없습니다.</strong>'); ?>
                    <table>
                    <caption>상품추가옵션 입력</caption>
                    <colgroup>
                        <col class="grid_4">
                        <col>
                    </colgroup>
                    <tbody>
                    <?php
                    $i = 0;
                    do {
                        $seq = $i + 1;
                    ?>
                    <tr>
                        <th scope="row">
                            <label for="spl_subject_<?php echo $seq; ?>">추가<?php echo $seq; ?></label>
                            <input type="text" name="spl_subject[]" id="spl_subject_<?php echo $seq; ?>" value="<?php echo $spl_subject[$i]; ?>" class="frm_input" size="15">
                        </th>
                        <td>
                            <label for="spl_item_<?php echo $seq; ?>"><b>추가<?php echo $seq; ?> 항목</b></label>
                            <input type="text" name="spl[]" id="spl_item_<?php echo $seq; ?>" value="" class="frm_input" size="40">
                            <?php
                            if($i > 0)
                                echo '<button type="button" id="del_supply_row" class="btn_frmline">삭제</button>';
                            ?>
                        </td>
                    </tr>
                    <?php
                        $i++;
                    } while($i < $spl_count);
                    ?>
                    </tbody>
                    </table>
                    <!--<div id="sit_option_addfrm_btn"><button type="button" id="add_supply_row" class="btn_frmline">옵션추가</button></div>-->
                    <div class="btn_confirm02 btn_confirm">
                        <button type="button" id="supply_table_create">옵션목록생성</button>
                    </div>
                </div>
                <div id="sit_option_addfrm"><?php include_once(G5_ROUTE_PATH.'/management/beverage/itemsupply.php'); ?></div>

                <script>
                $(function() {
                    <?php if($beverage_cd && $ps_run) { ?>
                    // 추가옵션의 항목 설정
                    var arr_subj = new Array();
                    var subj, spl;

                    $("input[name='spl_subject[]']").each(function() {
                        subj = $.trim($(this).val());

						console.log(subj);

                        if(subj && $.inArray(subj, arr_subj) == -1)
                            arr_subj.push(subj);
                    });

                    for(i=0; i<arr_subj.length; i++) {
                        var arr_spl = new Array();
                        $(".spl-subject-cell").each(function(index) {
                            subj = $(this).text();
                            if(subj == arr_subj[i]) {
                                spl = $(".spl-cell:eq("+index+")").text();
                                arr_spl.push(spl);
                            }
                        });

                        $("input[name='spl[]']:eq("+i+")").val(arr_spl.join());
                    }
                    <?php } ?>
                    // 입력필드추가
                    $("#add_supply_row").click(function() {
                        var $el = $("#sit_supply_frm tr:last");
                        var fld = "<tr>\n";
                        fld += "<th scope=\"row\">\n";
                        fld += "<label for=\"\">추가</label>\n";
                        fld += "<input type=\"text\" name=\"spl_subject[]\" value=\"\" class=\"frm_input\" size=\"15\">\n";
                        fld += "</th>\n";
                        fld += "<td>\n";
                        fld += "<label for=\"\"><b>추가 항목</b></label>\n";
                        fld += "<input type=\"text\" name=\"spl[]\" value=\"\" class=\"frm_input\" size=\"40\">\n";
                        fld += "<button type=\"button\" id=\"del_supply_row\" class=\"btn_frmline\">삭제</button>\n";
                        fld += "</td>\n";
                        fld += "</tr>";

                        $el.after(fld);

                        supply_sequence();
                    });

                    // 입력필드삭제
                    $(document).on("click", "#del_supply_row", function() {
                        $(this).closest("tr").remove();

                        supply_sequence();
                    });

                    // 옵션목록생성
                    $("#supply_table_create").click(function() {
                        var beverage_cd = $.trim($("input[name=beverage_cd]").val());
                        var subject = new Array();
                        var supply = new Array();
                        var subj, spl;
                        var count = 0;
                        var $el_subj = $("input[name='spl_subject[]']");
                        var $el_spl = $("input[name='spl[]']");
                        var $supply_table = $("#sit_option_addfrm");

                        $el_subj.each(function(index) {
                            subj = $.trim($(this).val());
                            spl = $.trim($el_spl.eq(index).val());

                            if(subj && spl) {
                                subject.push(subj);
                                supply.push(spl);
                                count++;
                            }
                        });

                        if(!count) {
                            alert("추가옵션명과 추가옵션항목을 입력해 주십시오.");
                            return false;
                        }

                        $.post(
                            "<?php echo G5_ROUTE_URL; ?>/management/beverage/itemsupply.php",
                            { beverage_cd: beverage_cd, w: "<?php echo $w; ?>", 'subject[]': subject, 'supply[]': supply },
                            function(data) {
                                $supply_table.empty().html(data);
                            }
                        );
                    });

                    // 모두선택
                    $(document).on("click", "input[name=spl_chk_all]", function() {
                        if($(this).is(":checked")) {
                            $("input[name='spl_chk[]']").attr("checked", true);
                        } else {
                            $("input[name='spl_chk[]']").attr("checked", false);
                        }
                    });

                    // 선택삭제
                    $(document).on("click", "#sel_supply_delete", function() {
                        var $el = $("input[name='spl_chk[]']:checked");
                        if($el.length < 1) {
                            alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                            return false;
                        }

                        $el.closest("tr").remove();
                    });

                    // 일괄적용
                    $(document).on("click", "#spl_value_apply", function() {
                        if($(".spl_com_chk:checked").length < 1) {
                            alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                            return false;
                        }

                        var spl_price = $.trim($("#spl_com_price").val());
                        var spl_use = $("#spl_com_use").val();
                        var $el = $("input[name='spl_chk[]']:checked");

                        // 체크된 옵션이 있으면 체크된 것만 적용
                        if($el.length > 0) {
                            var $tr;
                            $el.each(function() {
                                $tr = $(this).closest("tr");

                                if($("#spl_com_price_chk").is(":checked"))
                                    $tr.find("input[name='spl_price[]']").val(spl_price);

                                if($("#spl_com_use_chk").is(":checked"))
                                    $tr.find("select[name='spl_use[]']").val(spl_use);
                            });
                        } else {
                            if($("#spl_com_price_chk").is(":checked"))
                                $("input[name='spl_price[]']").val(spl_price);

                            if($("#spl_com_use_chk").is(":checked"))
                                $("select[name='spl_use[]']").val(spl_use);
                        }
                    });
                });

                function supply_sequence()
                {
                    var $tr = $("#sit_supply_frm tr");
                    var seq;
                    var th_label, td_label;

                    $tr.each(function(index) {
                        seq = index + 1;
                        $(this).find("th label").attr("for", "spl_subject_"+seq).text("추가"+seq);
                        $(this).find("th input").attr("id", "spl_subject_"+seq);
                        $(this).find("td label").attr("for", "spl_item_"+seq);
                        $(this).find("td label b").text("추가"+seq+" 항목");
                        $(this).find("td input").attr("id", "spl_item_"+seq);
                    });
                }
                </script>

			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./food_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>
<script>
$(document).ready(function(){

  //한글입력 안되게 처리

  $("input[name=beverage_eng_nm]").keyup(function(event){ 

   if (!(event.keyCode >=37 && event.keyCode<=40)) {

    var inputVal = $(this).val();

    $(this).val(inputVal.replace(/[^a-z0-9]/gi,''));

   }

  });

});


$(function() {
	$("#beverage_file").on('change', function(){
		readURL(this);
	});

	$('#banner_img').width("400px");
});

function readURL(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();

	reader.onload = function (e) {
			$('#banner_img').attr('src', e.target.result);
			$('#banner_img').width("400px");
		}

	  reader.readAsDataURL(input.files[0]);
	}
}


function frmBeverageGameChk(f){

	document.getElementById("btn_submit").disabled = "disabled";
	
	return true;

}
</script>
<?
include_once ('../../admin.tail.php');