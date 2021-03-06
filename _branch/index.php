<?php
$sub_menu = '100000';
include_once('./_common.php');

@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');

/*
$r4 = sql_query(" select t1.*, t2.* from {$DM['GAMES_REQUEST_DESCRIPTION_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd where t1.branch_cd='{$branch['branch_cd']}' and date_format(t1.request_reg_dt,'%Y-%m-%d') = '".G5_TIME_YMD."' and  t1.request_status='request' order by t1.request_reg_dt desc ");
*/
$r4 = sql_query("SELECT t1.od_id, t1.branch_cd, t1.room_cd, t2.od_status, t2.od_time, t3.room_no  
            from ( SELECT  od_id, branch_cd, room_cd FROM {$DM['CART_TABLE']} GROUP BY od_id ) as t1 
            join {$DM['ORDER_TABLE']} as t2 
            on t1.od_id=t2.od_id
			join ( select room_no, room_cd from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch['branch_cd']}') AS t3
			on t1.room_cd=t3.room_cd
            where t1.branch_cd='{$branch['branch_cd']}' 
            and date_format(t2.od_time,'%Y-%m-%d') = '".G5_TIME_YMD."' and t2.od_status='주문'
            order by t2.od_time asc limit 0, 10");

$colspan1 = "4";

$r5 = sql_query("SELECT t1.od_id, t1.branch_cd, t1.room_cd, t2.od_status, t2.od_time, t3.room_no  
            from ( SELECT  od_id, branch_cd, room_cd FROM {$DM['CART_TABLE']} GROUP BY od_id ) as t1 
            join {$DM['ORDER_TABLE']} as t2 
            on t1.od_id=t2.od_id
			join ( select room_no, room_cd from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch['branch_cd']}') AS t3
			on t1.room_cd=t3.room_cd
            where t1.branch_cd='{$branch['branch_cd']}' 
            and date_format(t2.od_time,'%Y-%m-%d') = '".G5_TIME_YMD."' and t2.od_status='접수'
            order by t2.od_time asc limit 0, 10");

?>
<div class="popup_bg"></div>
<div class="popup">
  
  
	<div class="title_wrap">
		<span class="table-tit">게임 설명 요청 및 주문 요청</span>

		<div class="btn-wrap-left" style='width:calc(75% - 0px);'>
			<button type="button" id="close" class="crmBtn type-white">닫기</button>
		</div>
	</div>
  
	<div class="pop_wrap_left">

		<div class="title_wrap">
			<span class="table-tit">직원 호출</span>
		</div>

		<?php
		$call = sql_fetch("select t1.*, t2.* from {$DM['GAMES_REQUEST_DESCRIPTION_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd where t1.branch_cd='{$branch['branch_cd']}' and date_format(t1.request_reg_dt,'%Y-%m-%d') = '".G5_TIME_YMD."' order by t1.request_reg_dt desc limit 0, 1");

		$games_dir = G5_DATA_URL.'/boardgames';
		$game_img = $games_dir."/".$call['games_img_file'];						
		?>

		<div class="cont-box marT30" style='height:380px;'>
		
			<div class="cont-box-top">
				<p class="tit" style='font-size:16px; font-weight:bold;'><?php echo get_room_info($call['room_cd'])?> 번룸 | 호출 시간 : <?php echo $call['request_reg_dt']?> </p>
			</div>

			<div class="cont-box-bottom">
				
				<div style="text-align:center; padding-top:30px;">
					
					<div class="list-box">
						
						<div class="txt-title">게임명 : <?php echo $call['games_nm']?></div>

						<div class="txt-cont">
							
							<img src="<?php echo $game_img?>" style='width:150px;'>

							<span class="dis-cmt marT05">
								<button type="button" class="crmBtn type-white" onclick="">직원확인</button>
							</span>

						</div>

					</div>

				</div>
				
			</div>

		</div><!--//cont-box-->

	</div>
	<div class="pop_wrap_right">

		<div class="title_wrap">
			<span class="table-tit">주문 요청</span>
		</div>

		<div class="cont-box marT30"  style='height:380px;'>
		
			<div class="cont-box-top">
				<p class="tit">테스트1</p>
			</div>
			<div class="cont-box-bottom"></div>

		</div><!--//cont-box-->

	</div>
  
</div>

<div class="ajax popup_bg"></div>
<div class="ajax popup">
  
  
	<div class="title_wrap">
		<span class="table-tit">게임 설명 요청 및 주문 요청</span>

		<div class="btn-wrap-left" style='width:calc(75% - 0px);'>
			<button type="button" id="close" class="crmBtn type-white">닫기</button>
		</div>
	</div>
  
	<div class="pop_wrap_left">

		<div class="title_wrap">
			<span class="table-tit">직원 호출</span>
		</div>

		<div class="request cont-box marT30" style='height:380px;'>
		
			<div class="cont-box-top">
				<p class="tit" style='font-size:16px; font-weight:bold;'><span class='room_cd'></span> 번룸 | 호출 시간 : <span class='request_reg_dt'></span> </p>
				
			</div>
			<div class="cont-box-bottom">
				
				<form name="frmEmployee" method="post" action="./index_employee_update.php" onsubmit="return frmEmployeeChk(this)" enctype="multipart/form-data">
				<input type="hidden" name="employee_uid" id="employee_uid" value="">
				
				<div style="text-align:center; padding-top:0px;">
					
					<!--
					<div class="list-box">
						
						<div class="txt-title">게임명 : <span class='games_nm'></span></div>

						<div class="txt-cont">
							
							<div class='game-image-area'>
							</div>
							

							<span class="dis-cmt marT05">
								<button type="submit" class="crmBtn type-white">직원확인</button>
							</span>

						</div>

					</div>
					--->

					<div class="intro-cont type2">
						
						<div class="it-left">
							
							<span>게임 설명 요청</span>
							<strong class="games_nm"></strong>

							<button type="submit" class="btn-start2 btn-scroll">직원 확인</button>

						</div>

					</div>

				</div>

				</form>
				
			</div>

		</div><!--//cont-box-->

	</div>
	<div class="pop_wrap_right">

		<div class="title_wrap">
			<span class="table-tit">주문 요청</span>
		</div>

		<div class="order cont-box marT30" style='height:380px;'>
		
			<div class="cont-box-top">
				<p class="tit" style='font-size:16px; font-weight:bold;'><!--<span class='room_cd'></span> 번룸 |--> 주문 시간 : <span class='request_reg_dt'></span> </p>
				
			</div>
			<div class="cont-box-bottom">
				
				<form name="frmOrder" id="frmOrder" method="post" action="./index_order_update.php" onsubmit="return frmOrderChk(this)" enctype="multipart/form-data">
				<input type="hidden" name="od_id" id="od_id" value="">
				
				<div style="text-align:center; padding-top:0px;">
					
					<div class="intro-cont type2">
						
						<div class="it-left">
							
							<span class="od_id"></span>
							<strong class="room_no"></strong>

							<button type="button" onclick="popOrder()" class="btn-start btn-scroll">오더 확인</button>
							<button type="submit" class="btn-start2 btn-scroll">주문 접수</button>

						</div>

					</div>
					

				</div>

				</form>
				
			</div>

		</div><!--//cont-box-->

	</div>
  

  
</div>



<div style="padding:20px;">
	
<div id="index_left">
	
	<div class="title_wrap">
		<span class="table-tit">주문 요청</span>
		<div class="btn-wrap-left" style='width:calc(100% - 80px);'>
			<button type="button" class="crmBtn type-white" onclick="location.href='./order/order_list.php	'">더보기</button>
		</div>
	</div>

	<div class="content_wrap">
		<table class="ncp_tbl marT15">
		<thead>
		<tr>
			<th>룸</th>
			<th>주문번호</th>
			<th>주문시간</th>
			<th>관리</th>
		</tr>
		</thead>
		<tbody id="order_call">
		<?
		for($i=0;$row=sql_fetch_array($r4);$i++){
		?>
		<tr>
			<td class="td_mng"><?php echo $row['room_no']?>번</td>
			<td><?php echo $row['od_id']?></td>
			<td class="td_datetime"><?php echo substr($row['od_time'],10,10)?></td>
			<td class="td_mng">
				<a href="#" class="btn btn_01">접수</a>
			</td>
		</tr>
		<?
		}
		if ($i == 0)
		echo "<tr><td colspan=\"".$colspan1."\" class=\"empty_table\">등록된 주문 현황이 없습니다</td></tr>";
		?>
		</tbody>
		</table>
	</div>

</div>


<div id="index_right">

	<div class="title_wrap">
		<span class="table-tit">접수 현황</span>
		<div class="btn-wrap-left" style='width:calc(100% - 80px);'>
			<button type="button" class="crmBtn type-white" onclick="location.href='./order/order_list.php	'">더보기</button>
		</div>
	</div>

	<div class="content_wrap">
		<table class="ncp_tbl marT15">
		<thead>
		<tr>
			<th>룸</th>
			<th>주문번호</th>
			<th>주문시간</th>
			<th>호출</th>
		</tr>
		</thead>
		<tbody id="order_call">
		<?
		for($i=0;$row=sql_fetch_array($r5);$i++){
		?>
		<tr>
			<td class="td_mng"><?php echo $row['room_no']?>번</td>
			<td><?php echo $row['od_id']?></td>
			<td class="td_datetime"><?php echo substr($row['od_time'],10,10)?></td>
			<td class="td_mng">
				<!--<a href="#" class="btn btn_01 modalPopup">호출</a>-->
				<?php if($row['od_status']=="접수"){?>
				<button class="btn btn_01" onclick="location.href='./index_room_call.php?od_id=<?php echo $row['od_id']?>'" style='width:80px'>룸호출</button>
				<?php }else{?>
				<button class="btn btn_01" onclick="wait()" style='width:80px'>룸호출</button>
				<?php }?>
			</td>
		</tr>
		<?
		}
		if ($i == 0)
		echo "<tr><td colspan=\"".$colspan1."\" class=\"empty_table\">등록된 주문 현황이 없습니다</td></tr>";
		?>
		</tbody>
		</table>
	</div>
	
	</div></div>
</div>

</div>

<script>
var time_interval
$( document ).ready(function() {
	//interval_order()
	time_interval = setInterval(() => {
		interval_order();
        console.log("interval");
	}, 5000);
});
console.log("global");

function interval_order(){
	let branch_cd = 'B9168'
	$.ajax({ 
		url: "./ajax_interval_order.php?branch_cd=" + branch_cd,
		method: "GET", 
		dataType: "json"
	}).done(function(json) { 
		console.log(json)
		if(json.list || json.order){
			if(json.list)
			{
				let req_data = json.list[0]
				$('.request .txt-cont .game-image-area').prepend("<img src='"+"http://dmonster9995.ingyu7.gethompy.com/data/boardgames/"+req_data.games_img_file+"' style='width:130px;'>")
				$('.request .room_cd').html(req_data.room_no)
				$('.request .request_reg_dt').html(req_data.request_reg_dt)
				$('.request .games_nm').html(req_data.games_nm)
				$('.request #employee_uid').val(req_data.uid)
			}
			if(json.order)
			{
				let order_data = json.order[0]
				$('.order .txt-cont .game-image-area').prepend("<img src='"+"http://dmonster9995.ingyu7.gethompy.com/data/boardgames/"+order_data.games_img_file+"' style='width:130px;'>")
				$('.order .room_no').html(order_data.room_no+"번룸 주문")
				$('.order .request_reg_dt').html(order_data.od_time)
				$('.order .od_id').html("주문번호 :	"+order_data.od_id)
				$('.order .games_nm').html(order_data.games_nm)
				$('.order #od_id').val(order_data.od_id)
			}
			$(".ajax.popup_bg").show();
			$(".ajax.popup").show(700);
			clearInterval(time_interval);
		}
	})
}


$(function () {
    $(".modalPopup").click(function () {    // [1]
        $(".popup_bg").show();
        $(".popup").show(700);
    });

    $(".popup_bg, #close").click(function () {   // [2]
        $(".popup_bg").hide();
        $(".popup").hide(200);
    });

    $(".ajax.popup_bg, #close").click(function () {   // [2]
		$(".ajax.popup_bg").hide();
        $(".ajax.popup").hide(200);
		location.replace("./index.php");
    });


});

function popCall(uid){

	var _width	= '800';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_employee_call.php?uid="+uid;

	var new_win = window.open(href, "pop_employee_call", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function popOrder(){
	var f = document.frmOrder;

	var _width	= '800';
    var _height = '600';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	var od_id = f.od_id.value;

	href="./pop_order.php?od_id="+od_id;

	var new_win = window.open(href, "pop_order", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();
	
	//alert(f.od_id.value);
}

function wait(){

	alert("직원의 오더 확인 후 룸 호출이 가능합니다");
	
}

</script>
<?php
include_once ('./admin.tail.php');	