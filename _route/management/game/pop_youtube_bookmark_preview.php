<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$game_info = get_game_info($games_cd);

$g5['title'] = "게임 설명영상 미리보기";
include_once ('../../pop.admin.head.php');

$youtube_url = $game_info['games_youtube'];
$regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
preg_match($regExp, $youtube_url, $matches);
$youtube_id = $matches[7];

$result = sql_query("select * from {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} where display_fl='T' and games_cd='{$games_cd}' ");
?>

</div><div class="layer-popup">

	<div class="type-800">

		<div class="view-title"><?php echo $game_info['games_nm']?> >  책갈피 미리보기</div>

		<div class="content-bottom-wrap2">

		
			<div class="contents type-3">

					<div class="inner-table-wrap type-2 scroll">

						<div class="table-tit-area2">

							<div class="btn-wrap-right marB20">
	
								<button type="button" class="crmBtn type-white" onclick="location.href='./pop_youtube_bookmark_list.php?games_cd=<?php echo $games_cd?>'">책갈피 목록</button>

							</div>

						</div><!--table-tit-area2-->

						<div class="content_item_bx" style='text-align:center;'>


							<div id="ytplayer"></div>

							<!--
							<div style="text-align:Center; padding:20px;" class="marT30">
							<iframe width="800" height="400" src="https://www.youtube.com/embed/" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="<?php echo $games_cd?>"></iframe>
							</div>
							-->


							<div style='width:100%; height:130px;'>
								
								<ul class="bookMarkList">
									
									<?php for($i=0;$row = sql_fetch_array($result);$i++){
										$time = ($row['youtube_paly_min']*60)+$row['youtube_paly_sec'];
										$url = "https://youtu.be/".$youtube_id."&t=".$time;
										//$url = "https://www.youtube.com/embed/sqfkNcRC92g";
									?>
									<li class="title">
										<div onclick="bookmark('<?php echo $time?>')"><?php echo $row['youtube_thumb_title']?></div>
									</li>
									<?php }?>

								</ul>

							</div>
		

						</div>


					</div>

			</div>

		</div>

	</div>

</div>
<script>
let count = 200;
// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player;

function onYouTubePlayerAPIReady() {
	player = new YT.Player('ytplayer', {
		height: '360',
		width: '640',
		videoId: '<?php echo $youtube_id?>',
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
	function onPlayerReady(event) {
		event.target.playVideo();
	}
	var done = false;
	function onPlayerStateChange(event) {
		if (event.data == YT.PlayerState.PLAYING && !done) {
		setTimeout(stopVideo, 6000);
		done = true;
		}
	}
	function stopVideo() {
		player.stopVideo();
	}
	
}
function bookmark(sec){
	player.seekTo(sec, true)
	console.log(sec);
}
</script>
<?
include_once ('../../pop.admin.tail.php');