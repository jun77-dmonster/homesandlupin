<?php
$sub_menu = '1000100';
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'r');

$room = sql_fetch("select * from {$DM['CART_TABLE']} where branch_cd='{$branch['branch_cd']}' and od_id='{$od_id}' limit 0,1");

$g5['title'] = get_room_info($room_cd)." 룸 호출";
include_once ('./pop.admin.head.php');
?>

<div class="layer-popup" >

	<div class="wrapper type-800">

		<div class="container-wrap">

			<div class="view-title" style='text-align:center; border-bottom:1px solid #ccc;'><?php echo get_room_info($room_cd)."번 룸 호출"?> </div>


			<div class="content-bottom-wrap2">

				<div class="box-cont type-3">

					<form name="frmCall" id="frmCall" action="./pop_room_call_update.php" onsubmit="return frmCallchk(this);" method="post">
					<input type="hidden" name="sst" value="<?php echo $sst ?>">
					<input type="hidden" name="sod" value="<?php echo $sod ?>">
					<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
					<input type="hidden" name="stx" value="<?php echo $stx ?>">
					<input type="hidden" name="page" value="<?php echo $page ?>">
					<input type="hidden" name="token" value="">

					
					<table class="ncp_tbl" style='margin:50px 0 20px 0;'>
					<colgroup>
						<col>
						<col style='width:120px;'>
					</colgroup>
					<thead>
					<tr>
						<th>내용</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
						<textarea class="frm_input"><?php echo $route['sc_room_text1']?></textarea>
						</td>
						<td>
							<button class="btn btn_01">전송</button>
						</td>
					</tr>
					<tr>
						<td><textarea class="frm_input"><?php echo $route['sc_room_text2']?></textarea></td>
						<td>
							<button class="btn btn_01">전송</button>
						</td>
					</tr>
					<tr>
						<td><textarea class="frm_input"><?php echo $route['sc_room_text3']?></textarea></td>
						<td>
							<button class="btn btn_01">전송</button>
						</td>
					</tr>
					</tbody>
					</table>


					</form>
				
				</div>

			</div>

		</div>

	</div>

</div>

<?
include_once ('./pop.admin.tail.php');