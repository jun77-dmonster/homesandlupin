<?php
include "top.php";
$keyword = '';
if(!empty($_GET['keyword']))
{
    $keyword = $_GET['keyword'];
}
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    /* 썸네일  */
    .player-container{
        position: relative;
        font-family: NotoSansKR-Regular;
    }

    #bookmark-container{
        position: absolute;
        width: 100%;
        bottom: 0%;
        background:#051f3a;
        z-index: 30;
    }
    .bookmark-item-list-container-slide{
        padding: 40px 0;
        margin:0 auto;
        width: 80%;
        font-size: 0;
        overflow:hidden;
    }
    .bookmark-item-list-container{
        position: relative;
        width:1000%;
        left:0;
        transition: all 0.5s ease-out;
    }
    .bookmark-btn-left-container,
    .bookmark-btn-right-container {
        position: absolute;
        width: 36px;
        height: 36px;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
        background-color: #597491;
        background-size: cover;
        background-position: center;
    }
    .bookmark-btn-left-container {
        left: 27px;
        background-image: url(../img/left.png);
    }
    .bookmark-btn-right-container {
        right: 27px;
        background-image: url(../img/right.png);
    }
    .bookmark-item-component {
        margin-right:15px;
        display: inline-block;
        width: 160px;
    }
    .bookmark-item-component:last-child {
        margin-right: 0;
    }
    .bookmark-item {
        position: relative;
        padding: 5px 0;
        width: 100%;
        height: 100px;
        text-align: center;
        overflow: hidden;
        background: #000;
    }
    .bookmark-item-title {
        position: absolute;
        width: 80%;
        top: 50%;
        left: 50%;
        color: #fff;
        font-size: 15px;
        transform: translate(-50%, -50%);
        line-height:23px;
    }
    .bookmark-item-time {
        display: none;
    }
    .no-search-result-alert{
        width: 100%;
        text-align: center;
        height: 215px;
        text-align: center;
        font-family:AggroM;
        font-size:25px;
        letter-spacing: -1px;
        line-height:200px;

    }
</style>

<div class="modal-search-player-bg"></div>
<div class="modal-search-player-popup">
    <div class="modal-popup-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-search-player-container">
        <div class="player-200-popup">
            <div class="player-btn-container">
                <div>
                    <div>게임세팅<br>다시보기</div>
                    <div><img src="img/play.png" alt="PLAY" title="PLAY"></div>
                </div>
                <div>
                    <div>게임요약<br>보기</div>
                    <div><img src="img/list.png" alt="LIST" title="LIST"></div>
                </div>
            </div>
        </div>
        <div id="bookmark-container" style="z-index: 1000">
            <div class="bookmark-item-container">
                <div class="bookmark-btn-left-container"></div>
                <div class="bookmark-item-list-container-slide">
                    <div class="bookmark-item-list-container">
                        <div class="bookmark-item-component">
                            <div class="bookmark-item">
                                <div class="bookmark-item-title">게임 소개</div>
                                <div class="bookmark-item-content"></div>
                            </div>
                            <div class="bookmark-item-time">00:45</div>
                        </div>
                    </div>
                </div>
                <div class="bookmark-btn-right-container"></div>
            </div>
        </div>
        <div class="player-container"  style="z-index: 0">
            <div style="position:absolute;background-color:#000;width:100%;height:65px;z-index:99900"></div>
            <div id="player"></div>
        </div>
    </div>
    <div class="modal-search-player-bookmark-container"></div>
</div>

<div class="modal-summaray-popup">
    <div class="modal-summaray-popup-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-summaray-title">게임요약</div>
    <div class="modal-summaray-content"></div>
</div>
<div class="modal-summaray-bg"></div>

<div class="modal-staff-blue-popup">
    <div class="modal-staff-title">카운터에 직원 설명이<br>요청되었습니다.<br>잠시 기다려주세요:)</div>
    <div class="mdoal-staff-btn-container">
        <div class="modal-staff-btn">확인</div>
    </div>
    <div class="modal-staff-sub-title">※매장 상황에 따라 설명이 지연될 수 있으니 양해 바랍니다</div>
</div>

<div class="y-scroll-container" data-keyword="<?PHP echo $keyword;?>">
    <div class="search-filter-container">
        <div class="search-filter-item-container">
        </div>
        <div class="search-filter-item-container">
        </div>
        <div class="search-filter-item-container">
        </div>

        <div class="search-filter-item-container hidden">
        </div>

        <div class="search-filter-item-container hidden">
        </div>

        <div class="search-filter-more-item-container">
            <div>+ 더보기</div>
        </div>
    </div>
    <div class="search-result-container">
    </div>
</div>
    <div id="topBtn">
        <img src="img/top.png" alt="TOP" title="TOP">
    </div>

    <script>
        // Load the IFrame Player API code asynchronously.
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Replace the 'ytplayer' element with an <iframe> and
        // YouTube player after the API code downloads.
        var player;

        $(function(){
            var globalVideoId = "";

            var listIndex = 0;

            $(".modal-staff-btn").click(function(){
                $(".modal-staff-blue-popup").hide();
            });

            $(document).on("click", ".staff", function(){

                var games_cd = $(this).data("games_cd");

                $.ajax({
                    type: 'POST',
                    url: "ok/main03_ok.php?type=staff",
                    data: { games_cd: games_cd},
                    success: function(data) {
                        $(".modal-staff-blue-popup").show();
                    }
                });
            })

            $(document).on("click", ".play", function(){

                listIndex = $(this).parent().parent().index();

                $("#player").remove();
                $(".player-container").append("<div id='player'></div>");

                var youtube = $(this).attr("data-games_youtube");
                var games_cd = $(this).attr("data-games_cd");

                if(youtube == "")
                    return false;

                var youtubeId = youtube.split("?v=");

                if(youtubeId.length == 1)
                    youtubeId = youtube.split("/")[3];
                else
                    youtubeId = youtubeId[1];
                globalVideoId = youtubeId;

                onYouTubePlayerAPIReady(youtubeId);
                $.ajax({
                    type: 'POST',
                    url: "ok/main03_ok.php?type=count",
                    data: { games_cd: games_cd, type: 'play' },
                });

                function onYouTubePlayerAPIReady(videoId) {
                    player = new YT.Player('player', {
                        height: $(window).height(),
                        width: $(document).width(),
                        // videoId: 'XWv6VEoFm5c',
                        videoId: videoId,
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                    function bookmark(type)
                    {
                        if(type === 2)
                        {
                            $("#bookmark-container").show();
                        }
                        else
                        {
                            $("#bookmark-container").hide();
                        }
                    }
                    function onPlayerReady(event) {
                        // player = event.target;
                        event.target.playVideo();
                        // var duration = player.getDuration();
                        // player.seekTo(0, true);
                    }
                    var done = false;
                    function onPlayerStateChange(event) {
                        bookmark(event.data);
                        if (event.data == YT.PlayerState.PLAYING && !done) {
                            setTimeout(stopVideo, 6000);
                            done = true;
                        }
                    }
                    function stopVideo() {
                        player.stopVideo();
                    }

                    // when video ends
                    function onPlayerStateChange(event) {
                        bookmark(event.data);
                        if(event.data === 0) {
                            //동영상 끝난 후 이벤트
                            $(".player-200-popup").show();
                        }
                    }
                }

                $(document).on("click", ".player-btn-container > div:first-child", function(){
                    var duration = player.getDuration();
                    player.seekTo(0, true);
                    $(".player-200-popup").hide();
                });

                $(document).on("click", ".player-btn-container > div:last-child", function(){
                    $($(".search-result-item-container").eq(listIndex).find(".btn-summaray")).click();
                });

                var games_cd = $(this).data("games_cd");

                $.ajax({
                    type: 'POST',
                    url: 'ok/main03_ok.php?type=timestamp',
                    data: {games_cd: games_cd},
                    success: function(data) {
                        data = JSON.parse(data);

                        $(".bookmark-item-list-container > div").remove();

                        for(var i = 0; i < data.length; i++) {
                            var html = '<div class="bookmark-item-component">';
                                html += '<div class="bookmark-item">';
                                    html += '<div class="bookmark-item-title">' + data[i].youtube_thumb_title + '</div>';
                                html += '</div>'
                                html += '<div class="bookmark-item-time">' + data[i].youtube_paly_min + ':' + data[i].youtube_paly_sec + '</div>';
                            html += '</div>';

                            $(".bookmark-item-list-container").append(html);
                        }

                    }
                });

                $(".modal-search-player-bg, .modal-search-player-popup").toggle();
            });

            var bookmarkIndex = 0;

            $(document).on("click", ".bookmark-item-component", function(){

                bookmarkIndex = $(this).index();

                var timeText = $(this).find(".bookmark-item-time").text();
                var timeSplit = timeText.split(":");

                var sec = (parseInt(timeSplit[0]) * 60) + parseInt(timeSplit[1]);

                    var duration = player.getDuration();
                    player.seekTo(sec, true)

            })

            $(document).on("click", ".bookmark-btn-left-container", function(){
                var left = $(".bookmark-item-list-container").css("left");
                if(parseInt(left) === 0)
                {
                    return false;
                }
                $(".bookmark-item-list-container").css("left", parseInt(left) + 150 + "px")
            })
            $(document).on("click", ".bookmark-btn-right-container", function(){
                var left = $(".bookmark-item-list-container").css("left");
                $(".bookmark-item-list-container").css("left", parseInt(left) - 150 + "px")
              
            })

            $(document).on("click", ".modal-popup-btn-close", function(){
                $("#player").remove();
                $(".modal-search-player-bg, .modal-search-player-popup, .player-200-popup").hide();
            })

            $.ajax({
                type: "POST",
                url: "ok/main03_ok.php?type=filter",
                data: {},
                success: function(data) {
                    var data = JSON.parse(data);

                    var categoryTitleArr = [];

                    for(var i = 0; i < data.length; i++) {
                        if(data[i].item_cd.length === 5) {
                            categoryTitleArr.push(data[i]);
                        }
                    }

                    for(var i = 0; i < categoryTitleArr.length; i++) {
                        $(".search-filter-item-container").eq(i).append("<div>" + categoryTitleArr[i].item_nm + "</div>");

                        for(var k = 0; k < data.length; k++) {
                            if(categoryTitleArr[i].item_cd == data[k].item_cd.substr(0, 5) && data[k].group_cd != data[k].item_cd) {
                                $(".search-filter-item-container").eq(i).append("<div data-item_cd='" + data[k].item_cd + "'>" + data[k].item_nm + "</div>");
                            }
                        }
                    }


                    $(".search-filter-item-container div:first-child").each(function(i, item){
                        if($(this).parent().find(" > div").length > 8) {
                            $(this).css({ marginBottom: ($($(this).parent()).height() - $(this).height() + 20) + 'px'});
                        }
                    });
                }
            });

            function getParam(sname) {

                var params = location.search.substr(location.search.indexOf("?") + 1);

                var sval = "";

                params = params.split("&");

                for (var i = 0; i < params.length; i++) {

                    temp = params[i].split("=");

                    if ([temp[0]] == sname) { sval = temp[1]; }

                }

                return sval;
            }

            search();
            function search() {

                var keyword = $(".y-scroll-container").data("keyword");



                var sql = "";
                var type = 0;
                $(".search-filter-item-container").each(function(i, item){
                    $($(this).find("div.active")).each(function(k, ktem){
                            switch(i) {
                                case 0:
                                    var cnt = parseInt($(this).text().split("인")[0]);
                                    if(sql == "") {
                                        sql += " (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
                                    } else {
                                        sql += " OR (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
                                    }
                                    break;
                                case 1:
                                    if(sql == ""){
                                        sql += "  games.games_level='" + $(this).data("item_cd") + "'";
                                    }
                                    else {                                            
                                        if(type === 0)
                                        {
                                            sql += " AND games.games_level='" + $(this).data("item_cd") + "'";
                                        }
                                        else
                                        {
                                            sql += " OR games.games_level='" + $(this).data("item_cd") + "'";
                                        }
                                    }
                                    type = 1;
                                    break;
                                case 2:
                                    if(sql == ""){
                                        sql += "  games.games_theme LIKE '%" + $(this).data("item_cd") + "%'";
                                    } else {    
                                        if(type === 1)
                                        {
                                            sql += " AND games.games_theme LIKE '%" + $(this).data("item_cd") + "%'";
                                        } else {
                                            sql += " OR games.games_theme LIKE '%" + $(this).data("item_cd") + "%'";
                                        }
                                    }
                                    type = 2;
                                    break;
                                case 3:
                                    if(sql == ""){
                                        sql += "  games.play_time='" + $(this).data("item_cd") + "'";
                                    } else {    
                                        if(type === 2)
                                        {
                                        sql += " AND games.play_time='" + $(this).data("item_cd") + "'";
                                        } else {
                                        sql += " OR games.play_time='" + $(this).data("item_cd") + "'";
                                        }
                                    }
                                    type = 3;
                                    break;
                                case 4:
                                    if(sql == "")
                                    {
                                        sql += "  games.explain_time='" + $(this).data("item_cd") + "'";
                                    } else {    
                                        if(type === 3)
                                        {
                                        sql += " AND games.explain_time='" + $(this).data("item_cd") + "'";
                                        } else {
                                        sql += " OR games.explain_time='" + $(this).data("item_cd") + "'";
                                        }
                                    }
                                    type = 4;
                                    break;
                            }

                    });
                });

                $.ajax({
                    type: 'POST',
                    url: 'ok/main03_ok.php?type=search',
                    data: { keyword: keyword, option: sql },
                    success: function(data) {
                        console.log(data);
                        var data = JSON.parse(data);
                        $('.search-result-container div').remove();

                        for(var i = 0; i < data.length; i++) {
                            var html = "<div class='search-result-item-container'>";
                                    html += "<div class='search-result-img'><img src='/data/boardgames/" + data[i].games_img_file + "' alt='GAME' title='GAME'></div>";
                                        html += "<div class='search-result-content-container'>";
                                            html += "<div class='search-result-title'>";
                                                html += "<p>" + data[i].games_nm + "</p>";
                                                if(data[i].best_icon == "T")
                                                    html += "<img src='img/best.png' alt='BEST' title='BEST'>";
                                                if(data[i].new_icon == "T")
                                                    html += "<img src='img/new.png' alt='NEW' title='NEW'>";
                                            html += "</div>";
                                            html += "<div class='search-result-info-container'>";
                                                html += "<div class='search-result-info'>";
                                                    html += "<div class='search-result-info-title'>추천인원</div>";
                                                    if(data[i].recommend_player_min_cnt === data[i].recommend_player_max_cnt)
                                                    {
                                                        html += "<div class='search-result-info-content'>" + data[i].recommend_player_min_cnt + "인</div>";      
                                                    }
                                                    else
                                                    {
                                                        html += "<div class='search-result-info-content'>" + data[i].recommend_player_min_cnt + "~" + data[i].recommend_player_max_cnt + "인</div>";
                                                    }
                                                    html += "<div class='search-result-info-footer'>가능인원: " + data[i].player_min_cnt + "~" + data[i].player_max_cnt + "</div>";
                                                html += "</div>";
                                            html += "<div class='search-result-info'>";
                                                html += "<div class='search-result-info-title'>플레이시간</div>";
                                                html += "<div class='search-result-info-content item_cd' data-item_cd='" + data[i].play_time + "'></div>";
                                            html += "</div>";
                                            html += "<div class='search-result-info'>";
                                                html += "<div class='search-result-info-title'>설명시간</div>";
                                                html += "<div class='search-result-info-content item_cd' data-item_cd='" + data[i].explain_time + "'></div>";
                                            html += "</div>";
                                            html += "<div class='search-result-info'>";
                                                html += "<div class='search-result-info-title'>장르</div>";
                                                html += "<div class='search-result-info-content item_cd search-result-genre' data-item_cd='" + data[i].games_theme + "'></div>";
                                            html += "</div>";
                                            html += "<div class='search-result-info'>";
                                                html += "<div class='search-result-info-title'>난이도</div>";
                                                html += "<div class='search-result-info-content item_cd' data-item_cd='" + data[i].games_level + "'></div>";
                                            html += "</div>";
                                        html += "</div>";
                                    html += "<div class='search-result-text-container'>";
                                        html += "<p>" + data[i].games_content + "</p>";
                                        html += "<p>" + data[i].games_hash_tag + "</p>";
                                    html += "</div>";
                                html += "</div>";
                                html += "<div class='search-result-btn-container'>";
                                    var btnClass = "content";
                                    if(data[i].games_youtube != "")
                                    {
                                        btnClass = "play";
                                    } else if(data[i].staff_call == "T")
                                    {
                                        btnClass = "staff";
                                    }
                                    html += "<div class='" + btnClass + "' data-games_cd='" + data[i].games_cd + "' data-games_youtube='" + data[i].games_youtube + "'></div>";
                                    html += "<div class='btn-summaray' data-games_cd='" + data[i].games_cd + "' data-summaray='" + data[i].games_summaray + "'>게임요약</div>";
                                html += "</div>";
                            html += "</div>";

                            $(".search-result-container").append(html);


                        }

                        // 검색 결과 없을 때
                        if(data.length === 0)
                        {
                            $(".search-result-container").append("<div class='no-search-result-alert'>검색 결과가 없습니다.</div>");
                        }

                        $(".search-result-content-container").each(function(){
                            if($(this).height() > 195) {
                                var diff = ($(this).height() - 195) / 2 * -1;

                                $(this).css({ marginTop: diff + 'px' });
                            }
                        });


                        $(document).on("click", ".btn-summaray", function(){
                            var games_cd = $(this).data("games_cd");
                            $.ajax({
                                type: 'POST',
                                url: "ok/main03_ok.php?type=count",
                                data: { games_cd: games_cd, type: 'summary' },
                            });
                            var summaray = $(this).data("summaray");

                            $(".modal-summaray-content").html(summaray);
                            $(".modal-summaray-popup, .modal-summaray-bg").show();
                        })
                        $(document).on("click", ".modal-summaray-popup-btn-close", function(){
                            $(".modal-summaray-popup, .modal-summaray-bg").hide();
                        })

                        $(".item_cd").each(function(i, item){
                            var item_cd = $(this).data("item_cd");

                            item_cd = item_cd.split("|");

                            for(var k = 0; k < item_cd.length; k++) {
                                $.ajax({
                                    url: "ok/main03_ok.php?type=code",
                                    type: "POST",
                                    data: {
                                        item_cd: item_cd[k]
                                    },
                                    success: function(data) {
                                        if($(item).text())
                                            $(item).html($(item).text() + "<br>" + data);
                                        else
                                            $(item).text(data)

                                        $(item).css({
                                            marginTop: (($($(item).parent()).height() - 36 - $(item).height()) / 2) + "px"
                                        });
                                    }
                                });
                            }

                        });


                    }
                });

            }

            $("#topBtn").click(function(){

                $(".y-scroll-container").scrollTop(0);
            });

            $(document).on("click", ".search-filter-item-container div:not(:first-child)", function(event){

                $(event.target).toggleClass("active");
                search();

                // if($(event.target).hasClass("active"))

            });

            var isToggle = 0;
            $(".search-filter-more-item-container div").click(function(){
                $(".search-filter-item-container.hidden").toggle();

                if(isToggle == 0) {

                    $(this).text("- 접기");

                    isToggle = 1;
                } else {

                    $(this).text("+ 더보기");

                    isToggle = 0;
                }
            });
        });
    </script>
</body>