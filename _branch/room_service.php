<?php
$sub_menu = '100000';
include_once('./_common.php');

@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

$result = sql_query(" select * from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch['branch_cd']}' and room_delete_fl='F' order by room_no ");

$g5['title'] = '룸 호출';
include_once ('./admin.head.php');
?>

<div class="box-view-wrap">
	
	<div class="notice-box">
		<ul>
			<li>호출하고자 하는 룸을 클릭해서 내용을 선택 후 룸을 호출 할수 있습니다</li>
		</ul>
	</div>

	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="content_item_bx">

				<div class="branch_list">
					
					<div class="ul_list">
						
						<ul>
							<?php for($i=0;$row=sql_fetch_array($result);$i++){?>
							<li>
								<a href="#" onclick="roomCall('<?php echo $row['room_cd']?>')"> ROOM <?php echo $row['room_no']?> 번 호출</a>
							</li>
							<?php }?>
						</ul>
						

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<script>
function roomCall(room_cd){

	var _width	= '800';
    var _height = '600';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_room_call.php?room_cd="+room_cd;

	var new_win = window.open(href, "pop_room_call", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?php
include_once ('./admin.tail.php');	