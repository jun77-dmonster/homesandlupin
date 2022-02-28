<?php
include "top.php";
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
        <div class="player-container">
            <div id="player"></div>
        </div>
        <div id="bookmark-container">
            <div class="bookmark-title-container">북마크</div>
            <div class="bookmark-item-container">
                <div class="bookmark-btn-left-container">
<!--                    <img src="" alt="LEFTBTN" title="LEFTBTN">-->
                </div>
                <div class="bookmark-item-list-container">
                    <div class="bookmark-item-component">
                        <div class="bookmark-item">
                            <div class="bookmark-item-title">게임 소개</div>
                            <div class="bookmark-item-content"></div>
                        </div>
                        <div class="bookmark-item-time">00:45</div>
                    </div>
                </div>
                <div class="bookmark-btn-right-container">
<!--                    <img src="" alt="RIGHTBTN" title="RIGHTBTN">-->
                </div>
            </div>
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


<div class="y-scroll-container" data-keyword="<?PHP echo isset($_GET['keyword']) && $_GET['keyword'] ? $_GET['keyword'] : '';?>">

            <div class="search-filter-container">
                <div class="search-filter-item-container">
<!--                    <div>인원구성</div>-->
<!--                    <div>2인</div>-->
<!--                    <div>3인</div>-->
<!--                    <div>4인</div>-->
<!--                    <div>5인</div>-->
<!--                    <div>6인</div>-->
<!--                    <div>7인+</div>-->
                </div>

                <div class="search-filter-item-container">
<!--                    <div>난이도</div>-->
<!--                    <div>아주쉬움</div>-->
<!--                    <div>쉬움</div>-->
<!--                    <div>보통</div>-->
<!--                    <div>어려움</div>-->
<!--                    <div>매우어려움</div>-->
<!--                    <div>마스터</div>-->
                </div>


                <div class="search-filter-item-container">
<!--                    <div>장르/테마</div>-->
<!--                    <div>직원추천</div>-->
<!--                    <div>전략</div>-->
<!--                    <div>추리</div>-->
<!--                    <div>협력/팀전</div>-->
<!--                    <div>웃음폭탄</div>-->
<!--                    <div>마피아</div>-->
<!--                    <div>순발력</div>-->
                </div>

                <div class="search-filter-item-container hidden">
<!--                    <div>플레이시간</div>-->
<!--                    <div>10분미만</div>-->
<!--                    <div>10분</div>-->
<!--                    <div>30분</div>-->
<!--                    <div>60분</div>-->
<!--                    <div>90분+</div>-->
                </div>

                <div class="search-filter-item-container hidden">
<!--                    <div>설명시간</div>-->
<!--                    <div>5분미만</div>-->
<!--                    <div>5분~10분</div>-->
<!--                    <div>10분~15분</div>-->
<!--                    <div>15분+</div>-->
                </div>

                <div class="search-filter-more-item-container">
                    <div>+ 더보기</div>
                </div>
            </div>

            <div class="search-result-container">
                <div class="search-result-item-container">
                    <div class="search-result-img"></div>
                    <div class="search-result-content-container">
                        <div class="search-result-title">
                            <p>게임이름</p>
                            <img src="img/best.png" alt="BEST" title="BEST">
                            <img src="img/new.png" alt="NEW" title="NEW">
                        </div>
                        <div class="search-result-info-container">
                            <div class="search-result-info">
                                <div class="search-result-info-title">추천인원</div>
                                <div class="search-result-info-content">2~4인</div>
                                <div class="search-result-info-footer">가능인원: 2~6</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">플레이시간</div>
                                <div class="search-result-info-content">30분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">설명시간</div>
                                <div class="search-result-info-content">10분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">장르</div>
                                <div class="search-result-info-content">전략</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">난이도</div>
                                <div class="search-result-info-content">보통</div>
                            </div>
                        </div>

                        <div class="search-result-text-container">
                            <p>게임 설명~ 어쩌구 저쩌구 이런 저런 게임입니다. 아주 재미있어요~! 진짜로!! 우하하하^ㅇ^!!</p>
                            <p>#숫자타일 #추상전략게임 #유명한게임 #컴플레또_비슷한게임</p>
                        </div>
                    </div>
                    <div class="search-result-btn-container">
                        <div class="play"></div>
                        <div>게임요약</div>
                    </div>

                </div>
                <div class="search-result-item-container">
                    <div class="search-result-img"></div>
                    <div class="search-result-content-container">
                        <div class="search-result-title">
                            <p>게임이름</p>
                            <img src="img/best.png" alt="BEST" title="BEST">
                            <img src="img/new.png" alt="NEW" title="NEW">
                        </div>
                        <div class="search-result-info-container">
                            <div class="search-result-info">
                                <div class="search-result-info-title">추천인원</div>
                                <div class="search-result-info-content">2~4인</div>
                                <div class="search-result-info-footer">가능인원: 2~6</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">플레이시간</div>
                                <div class="search-result-info-content">30분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">설명시간</div>
                                <div class="search-result-info-content">10분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">장르</div>
                                <div class="search-result-info-content">전략</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">난이도</div>
                                <div class="search-result-info-content">보통</div>
                            </div>
                        </div>

                        <div class="search-result-text-container">
                            <p>게임 설명~ 어쩌구 저쩌구 이런 저런 게임입니다. 아주 재미있어요~! 진짜로!! 우하하하^ㅇ^!!</p>
                            <p>#숫자타일 #추상전략게임 #유명한게임 #컴플레또_비슷한게임</p>
                        </div>
                    </div>
                    <div class="search-result-btn-container">
                        <div class="content"></div>
                        <div>게임요약</div>
                    </div>

                </div>
                <div class="search-result-item-container">
                    <div class="search-result-img"></div>
                    <div class="search-result-content-container">
                        <div class="search-result-title">
                            <p>게임이름</p>
                            <img src="img/best.png" alt="BEST" title="BEST">
                            <img src="img/new.png" alt="NEW" title="NEW">
                        </div>
                        <div class="search-result-info-container">
                            <div class="search-result-info">
                                <div class="search-result-info-title">추천인원</div>
                                <div class="search-result-info-content">2~4인</div>
                                <div class="search-result-info-footer">가능인원: 2~6</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">플레이시간</div>
                                <div class="search-result-info-content">30분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">설명시간</div>
                                <div class="search-result-info-content">10분</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">장르</div>
                                <div class="search-result-info-content">전략</div>
                            </div>
                            <div class="search-result-info">
                                <div class="search-result-info-title">난이도</div>
                                <div class="search-result-info-content">보통</div>
                            </div>
                        </div>

                        <div class="search-result-text-container">
                            <p>게임 설명~ 어쩌구 저쩌구 이런 저런 게임입니다. 아주 재미있어요~! 진짜로!! 우하하하^ㅇ^!!</p>
                            <p>#숫자타일 #추상전략게임 #유명한게임 #컴플레또_비슷한게임</p>
                        </div>
                    </div>
                    <div class="search-result-btn-container">
                        <div class="staff"></div>
                        <div>게임요약</div>
                    </div>

                </div>
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

            console.log(player);

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
                    data: { games_cd: games_cd },
                    success: function(data) {
                        console.log(data);
                        $(".modal-staff-blue-popup").show();
                    }
                });
            })

            $(document).on("click", ".play", function(){

                listIndex = $(this).parent().parent().index();

                $("#player").remove();
                $(".player-container").append("<div id='player'></div>");

                var youtube = $(this).attr("data-games_youtube");

                if(youtube == "")
                    return false;

                var youtubeId = youtube.split("?v=");

                if(youtubeId.length == 1)
                    youtubeId = youtube.split("/")[3];
                else
                    youtubeId = youtubeId[1];

                //https://www.youtube.com/watch?v=svkTqTCm62o

                globalVideoId = youtubeId;

                onYouTubePlayerAPIReady(youtubeId);


                function onYouTubePlayerAPIReady(videoId) {
                    player = new YT.Player('player', {
                        height: $(window).height() - 240,
                        width: $(document).width(),
                        // videoId: 'XWv6VEoFm5c',
                        videoId: videoId,
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                    function onPlayerReady(event) {
                        // player = event.target;
                        event.target.playVideo();
                        // var duration = player.getDuration();
                        // player.seekTo(0, true);
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

                    // when video ends
                    function onPlayerStateChange(event) {
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

                console.log(games_cd);

                $.ajax({
                    type: 'POST',
                    url: 'ok/main03_ok.php?type=timestamp',
                    data: {games_cd: games_cd},
                    success: function(data) {
                        data = JSON.parse(data);

                        $(".bookmark-item-list-container > div").remove();

                        for(var i = 0; i < data.length; i++) {
                            console.log(data[i]);
                            var html = '<div class="bookmark-item-component">';
                                html += '<div class="bookmark-item">';
                                    html += '<div class="bookmark-item-title">' + data[i].youtube_thumb_title + '</div>';
                                    html += '<div class="bookmark-item-content"><img src="' + data[i].youtube_img_thumb + '" alt="THUMBNAIL" title="THUMBNAIL"></div>';
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

                // if(player.seekTo) {
                    var duration = player.getDuration();
                    player.seekTo(sec, true)
                // }

                //넘길 초 넣어서 쓰시면됩니다.
                // function bookmark(sec)
                // {
                //     if(player.seekTo) {
                //         player.seekTo(sec, true)
                //     }
                // }
                //
                // bookmark(sec);
            })

            $(document).on("click", ".bookmark-btn-left-container", function(){
                var bookmarkCount = $(".bookmark-item-component").length;

                if(bookmarkIndex > 0) {
                    bookmarkIndex--;
                } else {
                    bookmarkIndex = bookmarkCount - 1;
                }

                $(".bookmark-item-component").eq(bookmarkIndex).click();
            })
            $(document).on("click", ".bookmark-btn-right-container", function(){
                var bookmarkCount = $(".bookmark-item-component").length;
                if(bookmarkIndex < bookmarkCount) {
                    bookmarkIndex++;
                } else {
                    bookmarkIndex = 0;
                }
                $(".bookmark-item-component").eq(bookmarkIndex).click();
            })

            $(document).on("click", ".modal-popup-btn-close", function(){
                // var duration = player.getDuration();
                // player.seekTo(0, true);

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
                        // console.log(data[i]);
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
                // if(getParam("keyword")) {
                //     keyword = getParam("keyword");
                // }

                var sql = "";
                if(keyword) {
                    sql = " games.games_nm LIKE '%" + keyword + "%'";
                }

                $(".search-filter-item-container").each(function(i, item){
                    $($(this).find("div.active")).each(function(k, ktem){

                            switch(i) {
                                case 0:
                                    if(sql == "")
                                        sql += " games.games_theme LIKE '%" + $(this).data("item_cd") + "%'";
                                    else
                                        sql += " OR games.games_theme LIKE '%" + $(this).data("item_cd") + "%'";

                                    break;
                                case 1:
                                    if(sql == "")
                                        sql += " games.games_level='" + $(this).data("item_cd") + "'";
                                    else
                                        sql += " OR games.games_level='" + $(this).data("item_cd") + "'";

                                    break;
                                case 2:
                                    if(sql == "")
                                        sql += " games.play_time='" + $(this).data("item_cd") + "'";
                                    else
                                        sql += " OR games.play_time='" + $(this).data("item_cd") + "'";

                                    break;
                                case 3:
                                    if(sql == "")
                                        sql += " games.explain_time='" + $(this).data("item_cd") + "'";
                                    else
                                        sql += " OR games.explain_time='" + $(this).data("item_cd") + "'";

                                    break;
                                case 4:
                                    var cnt = parseInt($(this).text().split("인")[0]);
                                    if(sql == "") {
                                        sql += " (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
                                    } else {
                                        sql += " OR (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
                                    }
                                    
                                    break;
                            }


                    });
                });

                $.ajax({
                    type: 'POST',
                    url: 'ok/main03_ok.php?type=search',
                    data: { sql: sql },
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
                                                    html += "<div class='search-result-info-content'>" + data[i].recommend_player_min_cnt + "~" + data[i].recommend_player_max_cnt + "인</div>";
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
                                                html += "<div class='search-result-info-content item_cd' data-item_cd='" + data[i].games_theme + "'></div>";
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
                                        btnClass = "play";
                                    if(data[i].staff_call == "T")
                                        btnClass = "staff";
                                    html += "<div class='" + btnClass + "' data-games_cd='" + data[i].games_cd + "' data-games_youtube='" + data[i].games_youtube + "'></div>";
                                    html += "<div class='btn-summaray' data-summaray='" + data[i].games_summaray + "'>게임요약</div>";
                                html += "</div>";
                            html += "</div>";

                            $(".search-result-container").append(html);
                        }

                        $(document).on("click", ".btn-summaray", function(){
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
                                            $(item).text($(item).text() + ", " + data);
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