<?php
include "top.php";
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
    }

</style>

<div class="modal-bg"></div>
<div class="modal-game-wheel-popup">
    <div class="modal-game-wheel-info-popup">
        <div class="modal-game-wheel-info-left">
            <div class="modal-game-thumbnail-container">
                <img src="" alt="THUMBNAIL" title="THUMBNAIL">
            </div>
            <div class="modal-game-youtube-btn-container">
                <div class="modal-game-youtube-btn" data-games_youtube="">
                    <div class="modal-game-youtube-btn-center">
                        <p>설명영상</p>
                        <img src="img/play.png" alt="PLAY" title="PLAY">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-game-wheel-info-right">
            <div class="modal-game-wheel-info-title">게임이름</div>
            <div class="modal-game-wheel-info-content">테스트 입니다.테스트 입니다.테스트 입니다.테스트 입니다.테스트 입니다.테스트 입니다.테스트 입니다.테스트 입니다.</div>
            <div class="modal-game-wheel-info-category-container">
                <div class="modal-game-wheel-info-category-list">
                    <p>추천인원 : </p>
                    <p>0명~0명</p>
                </div>
                <div class="modal-game-wheel-info-category-list">
                    <p>난이도 : </p>
                    <div class="level-container">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <p>보통</p>
                </div>
                <div class="modal-game-wheel-info-category-list">
                    <p>장르 : </p>
                    <p>추리</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-game-wheel-btn-container">
        <button>처음으로</button>
        <button>다시돌리기</button>
    </div>
</div>


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
            <iframe id="player" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player" width="1233" height="564" src="https://www.youtube.com/embed/svkTqTCm62o?enablejsapi=1&amp;origin=http%3A%2F%2Flocalhost&amp;widgetid=1"></iframe>
            <div id="player"></div></div>
        <div id="bookmark-container">
            <div class="bookmark-title-container">북마크</div>
            <div class="bookmark-item-container">
                <div class="bookmark-btn-left-container">
                    <!--                    <img src="" alt="LEFTBTN" title="LEFTBTN">-->
                </div>
                <div class="bookmark-item-list-container">

                    <div class="bookmark-item-component"><div class="bookmark-item"><div class="bookmark-item-title">123123123</div><div class="bookmark-item-content"><img src="G6731/7KCc66qp7JeG7J2M4.jpg" alt="THUMBNAIL" title="THUMBNAIL"></div></div><div class="bookmark-item-time">9:24</div></div><div class="bookmark-item-component"><div class="bookmark-item"><div class="bookmark-item-title">여러번째 테스트입니다</div><div class="bookmark-item-content"><img src="G6731/7KCc66qp7JeG7J2M4.jpg" alt="THUMBNAIL" title="THUMBNAIL"></div></div><div class="bookmark-item-time">16:43</div></div><div class="bookmark-item-component"><div class="bookmark-item"><div class="bookmark-item-title">이런 저런 테스트</div><div class="bookmark-item-content"><img src="G6731/7KCc66qp7JeG7J2M4.jpg" alt="THUMBNAIL" title="THUMBNAIL"></div></div><div class="bookmark-item-time">23:44</div></div></div>
                <div class="bookmark-btn-right-container">
                    <!--                    <img src="" alt="RIGHTBTN" title="RIGHTBTN">-->
                </div>
            </div>
        </div>
    </div>
    <div class="modal-search-player-bookmark-container"></div>
</div>


<body>
    <div class="main02-search-container">
        <div class="main02-title">돌려돌려 추천게임</div>

        <div class="search-list-container">
            <div class="search-list-item-container">
                <div>
                    <div class="text-layout">
                        <p>인원</p>
                        <p class="sub-title">[필수선택]</p>
                    </div>
                </div>
                <div data-item_cd="01005001"><span>2인</span></div>
                <div data-item_cd="01005002"><span>3인</span></div>
                <div data-item_cd="01005003"><span>4인</span></div>
                <div data-item_cd="01005004"><span>5인</span></div>
                <div data-item_cd="01005005"><span>6인</span></div>
                <div data-item_cd="01005006"><span>7인+</span></div>
            </div>
            <div class="search-list-item-container">
                <div>
                    <div class="text-layout">
                        <p>난이도</p>
                    </div>
                </div>
                <div data-item_cd="01002001"><span>아주<br>쉬움</span></div>
                <div data-item_cd="01002002"><span>쉬움</span></div>
                <div data-item_cd="01002003"><span>보통</span></div>
                <div data-item_cd="01002004"><span>어려움</span></div>
                <div data-item_cd="01002005"><span>매우<br>어려움</span></div>
                <div data-item_cd="01002006"><span>마스터</span></div>
            </div>
            <div class="search-list-item-container">
                <div>
                    <div class="text-layout">
                        <p>장르</p>
                    </div>
                </div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="search-btn-container">
            <button>START!</button>
        </div>

    </div>


<div class="container-fluid h-100 wheel-container" >
    <div class="row h-100">

        <div style="position: absolute; width: 1100px; height: 554px;  left:50%; transform: translateX(-50%); bottom: 20px; z-index: 100;">
          <canvas id='canvas' width='1100' height='1100' style="margin-top: 5px;">
              Canvas not supported, use another browser.
          </canvas>
            <div style="
            /*background-color: black;*/
            width: 2px;
            height: 20px;
            position: absolute;
            top: 20px;
            left: 549px;">&nbsp;</div>
<!--            <img src="img/homesleft.png" style="-->
<!--                position: absolute;-->
<!--                left: -8px;-->
<!--                width: 500px;-->
<!--                top: 165px;-->
<!--                transform: rotate(-22deg);-->
<!--            "/>-->
<!--            <img src="img/homesright.png"style="-->
<!--                position: absolute;-->
<!--                right: -8px;-->
<!--                width: 500px;-->
<!--                top: 165px;-->
<!--                transform: rotate(22deg);-->
<!--            "/>-->
            <img src="img/wheel/startcircle.png"
               id="startCircle"
               class="startCircleClass"
               style="
                position: absolute;
                top: 365px !important;
                left: 384px;
            "/>
<!--            <div class="touch">touch!</div>-->
        </div>

        <div class="ruletbox">

            <img src="img/homesSelctor.png" style=" z-index: 100; top:42px; position:absolute; left:516px;">
            <!--            <img src="img/homesleft.png" style=" bottom:100px; position:absolute; left:30px;">-->
            <!--            <img src="img/startcircle_nostart.png" style=" bottom:-30px; position:absolute; left:390px;">-->
            <!--            <img src="img/homesright.png" style=" bottom:100px; position:absolute; left:620px;">-->
        </div>

    </div>
</body>

<style>
    .wheel-container {
        display: none;
    }
</style>

<script src="js/wheel/Winwheel.js"></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js'></script>
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

        var isWheel = true;

        $(document).on("click", ".modal-game-youtube-btn", function(event){

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
                    playerVars: {
                        modestbranding: 1,
                        autoplay: 0,
                    },
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



        $(".search-list-item-container > div:not(:first-child)").click(function(event){
            $(this).toggleClass("active");
        });
        $(".search-btn-container button").click(function(){

            if($(".search-list-item-container > div.active").length === 0)
                return false;

            var sql = "";

            $(".search-list-item-container:nth-child(1) > div.active").each(function(i, item){
                var item_cd = $(item).data("item_cd");
                var cnt = parseInt($(item).text().split("인")[0]);

                if(sql == "")
                    sql += " (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
                else
                    sql += " OR (games.recommend_player_min_cnt <= " + cnt + " AND games.recommend_player_max_cnt >= " + cnt + ")";
            });
            $(".search-list-item-container:nth-child(2) > div.active").each(function(i, item){
                var item_cd = $(item).data("item_cd");

                if(sql == "")
                    sql += " games.games_level='" + item_cd + "'";
                else
                    sql += " OR games.games_level='" + item_cd + "'";
            });
            $(".search-list-item-container:nth-child(3) > div.active").each(function(i, item){
                var item_cd = $(item).data("item_cd");

                if(sql == "")
                    sql += " games.games_theme LIKE '%" + item_cd + "%'";
                else
                    sql += " OR games.games_theme LIKE '%" + item_cd + "%'";
            });

            console.log(sql);
            $.ajax({
                type: "POST",
                url: "ok/main03_ok.php?type=search",
                data: { sql: sql },
                success: function(data) {

                    data = JSON.parse(data);

                    console.log(data);

                    var arr = [];
                    // var limit = data.length < 10 ? data.length : 10;
                    // // limit = 10;
                    // for(var i = 0; i < limit; i++) {
                    //
                    //     arr.push({
                    //         'image': "data/boardgames/" + data[i].games_img_file,
                    //         'index': i,
                    //         'title': data[i].games_nm,
                    //         'content': data[i].games_content,
                    //         'theme': data[i].games_theme,
                    //         'youtube': data[i].games_youtube,
                    //         'min': data[i].recommend_player_max_cnt,
                    //         'max': data[i].recommend_player_max_cnt,
                    //         'level': data[i].games_level,
                    //         'games_cd': data[i].games_cd,
                    //         // 'image': "img/number/" + (index) + '.jpg',
                    //         // 'index': i,
                    //         // 'title': index,
                    //         // 'content': index,
                    //         // 'fillStyle' : color
                    //     });
                    // }

                    arrayPush();

                    function arrayPush() {
                    
                        for(var i = 0; i < data.length; i++) {
                            if(arr.length < 10) {
                                console.log(data[i].games_img_file.split('/')[0] + '/thumb-' + data[i].games_img_file.split('/')[1])
                                arr.push({
                                    'image': "data/boardgames/" + data[i].games_img_file,
                                    'index': i,
                                    'title': data[i].games_nm,
                                    'content': data[i].games_content,
                                    'theme': data[i].games_theme,
                                    'youtube': data[i].games_youtube,
                                    'min': data[i].recommend_player_max_cnt,
                                    'max': data[i].recommend_player_max_cnt,
                                    'level': data[i].games_level,
                                    'games_cd': data[i].games_cd,
                                });
                            }
                        }

                        if(arr.length < 10)
                            arrayPush();
                    }

                    console.log(arr);

                    $(".main02-search-container").hide();
                    $(".wheel-container").show();
                    $("body").addClass("wheel-body");

                    let theWheel1 = new Winwheel({
                        //'numSegments'  : 10,         // Number of segments
                        // 'numSegments': arr.length,
                        // 'outerRadius'  : 390,       // The size of the wheel.
                        // 'centerX'      : 550,       // Used to position on the background correctly.
                        // 'centerY'      : 500,
                        // 'textFontSize' : 17,        // Font size.
                        // 'textOrientation'   : 'curved',     // Note use of curved text.
                        // 'textAligment' : 'outer',
                        // 'textMargin': 150,
                        // 'textDirection'     : 'desired',
                        // 'yoyo':true,
                        // 'strokeStyle':'#7B9BA5',
                        // 'textStrokeStyle'   : 'black',
                        // 'lineWidth':23,
                        // 'drawMode':"segmentImage",
                        // 'drawText': false,
                        // 'imageDirection':'S',
                        'numSegments': arr.length,
                        'outerRadius'  : 1100,       // The size of the wheel.
                        'centerX'      : 550,       // Used to position on the background correctly.
                        'centerY'      : 505,
                        'textFontSize' : 17,        // Font size.
                        'textOrientation'   : 'curved',     // Note use of curved text.
                        'textAligment' : 'outer',
                        'textMargin': 150,
                        'textDirection'     : 'desired',
                        'yoyo':true,
                        'strokeStyle':'#7B9BA5',
                        'textStrokeStyle'   : 'black',
                        'lineWidth':23,
                        'drawMode':"segmentImage",
                        'drawText': true,
                        'imageDirection':'S',
                        'rotationAngle':18,
                        // 'segments':
                        //     [
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //         { 'image' : 'img/wheel/game.png'},
                        //     ],
                        'segments': arr,
                        'animation' :               // Definition of the animation
                            {
                                'type'     : 'spinToStop',
                                'duration' : 5,
                                'spins'    : 8,
                                'callbackFinished' : alertPrize
                            }
                    });

                    function resetWheel() {
                        theWheel1.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                        theWheel1.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                        theWheel1.draw();

                        wheelSpinning = false;
                    }

                    // Create new image object in memory.
                    let loadedImg = new Image();

                    // Create callback to execute once the image has finished loading.
                    loadedImg.onload = function()
                    {
                        theWheel1.wheelImage = loadedImg;    // Make wheelImage equal the loaded image object.
                        theWheel1.draw();                    // Also call draw function to render the wheel.
                    }

                    // Set the image source, once complete this will trigger the onLoad callback (above).
                    loadedImg.src = "./img/wheel/wheel.png";

                    // Called when the animation has finished.
                    function alertPrize(indicatedSegment)
                    {
                        // Do basic alert of the segment text.
                        // $('#ruletpop').modal('show');
                        console.log('indicatedSegment', indicatedSegment)

                        // var index = indicatedSegment.index + 4;
                        // if(indicatedSegment.index)


                        var index = indicatedSegment.index;

                        //((0.5 * (indicatedSegment.index - 1)) + 1) +
                        var index = parseInt( ((arr.length - 1) / 2) ) + indicatedSegment.index + 1;
                            index = index >= arr.length ? index % arr.length : index;

                        // alert("You have won " + indicatedSegment.text);

                        $(".modal-game-thumbnail-container img").attr("src", arr[index].image);
                        $(".modal-game-wheel-info-title").text(arr[index].title);
                        $(".modal-game-wheel-info-content").text(arr[index].content);
                        $(".modal-game-wheel-info-category-list:nth-child(1) p:nth-child(2)").text(arr[index].min+"명~"+arr[index].max+"명");

                        $(".modal-game-youtube-btn").attr("data-games_youtube", arr[index].youtube);
                        $(".modal-game-youtube-btn").attr("data-games_cd", arr[index].games_cd);

                        console.log(arr[index].youtube);

                        $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div").css({ backgroundColor: '#c5c5c5' });

                        var level = "";

                        switch(arr[index].level) {
                            case "01002001":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1)").css({
                                    backgroundColor: '#F7B400',
                                });
                                level = "아주쉬움";
                            break;
                            case "01002002":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(2)").css({
                                    backgroundColor: '#8DC21F',
                                });
                                level = "쉬움";
                            break;
                            case "01002003":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(2), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(3)").css({
                                    backgroundColor: '#036EB7',
                                });
                                level = "보통";
                            break;
                            case "01002004":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(2), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(3), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(4)").css({
                                    backgroundColor: '#5F1985',
                                });
                                level = "어려움";
                            break;
                            case "01002005":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(2), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(3), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(4), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(5)").css({
                                    backgroundColor: '#CF1979',
                                });
                                level = "매우어려움";
                            break;
                            case "01002006":
                                $(".modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(1), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(2), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(3), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(4), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(5), .modal-game-wheel-info-category-list:nth-child(2) .level-container div:nth-child(6)").css({
                                    backgroundColor: '#B41018',
                                });
                                level = "마스터";
                            break;
                        }

                        $(".modal-game-wheel-info-category-list:nth-child(2) p:nth-child(3)").text(level);

                        var theme = arr[index].theme.split("|");
                        var themeText = "";
                        for(var i = 0; i < theme.length; i++) {
                            $.ajax({
                                url: "ok/main03_ok.php?type=code",
                                type: "POST",
                                data: {
                                    item_cd: theme[i]
                                },
                                success: function(data) {

                                    if($(".modal-game-wheel-info-category-list:nth-child(3) p:nth-child(2)").text())
                                        $(".modal-game-wheel-info-category-list:nth-child(3) p:nth-child(2)").text($(".modal-game-wheel-info-category-list:nth-child(3) p:nth-child(2)").text() + ", " + data);
                                    else
                                        $(".modal-game-wheel-info-category-list:nth-child(3) p:nth-child(2)").text(data);


                                }
                            });

                        }



                        $(".modal-game-wheel-info-category-list:nth-child(3) p:nth-child(2)").text(themeText);
                        $(".modal-game-wheel-popup, .modal-bg").show();

                        $("#startCircle").attr("src", "img/wheel/startcircle_nostart.png");
                        isWheel = true;
                    }

                    $(document).on("click", "#startCircle, .modal-game-wheel-btn-container button:nth-child(2)", function(){
                        if(isWheel) {
                            isWheel = false;
                            $("#startCircle").attr("src", "img/wheel/startBtn_none.png");
                            $(".modal-game-wheel-popup, .modal-search-player-bg, .modal-bg, .touch").hide();
                            resetWheel();
                            theWheel1.startAnimation();
                        }
                    });

                    // $(document).on("click", ".modal-game-wheel-btn-container button:nth-child(2)", function(event){
                    //     $(".modal-game-wheel-popup, .modal-bg, .touch").hide();
                    //     resetWheel();
                    //     theWheel1.startAnimation();
                    // })

                }
            });

        });

        $(document).on("click", ".modal-bg", function(){
            $(".modal-game-wheel-popup, .modal-bg").hide();
        })

        $.ajax({
            type: 'POST',
            url: 'ok/main02search_ok.php?type=theme',
            data: {},
            success: function(data) {
                data = JSON.parse(data);

                function shuffle(array) { return array.sort(() => Math.random() - 0.5); }

                data = shuffle(data);

                $(".search-list-item-container:nth-child(3) > div:not(:first-child)").each(function(i, item){
                
                    fontSize = '';
                    if(data[i].item_nm.length > 4)
                    {
                        fontSize = "style=font-size:28px";
                    }
                    else if(data[i].item_nm.length > 3)
                    {
                        fontSize = "style=font-size:36px;";
                    }
                    
                    $(this).attr("data-item_cd", data[i].item_cd);
                    $(this).append("<span " + fontSize + ">" + data[i].item_nm + "</span>");
                });

            }
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

        $(document).on("click", '.modal-search-player-popup .modal-popup-btn-close', function(){
            $("#player").remove();
            $(".modal-search-player-popup").hide();
        })

        $(document).on("click", ".modal-game-wheel-btn-container button:nth-child(1)", function(event){
            window.location.href="/main02search.php";
        })

    });
</script>