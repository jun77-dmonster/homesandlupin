<?php
include "top.php";



?>
<body>
<style>
    .modal-header .close {
        padding: 0px;
        margin:0px;
    }

    html, body {
        margin: 0; height: 100%; overflow: hidden; 
    }

    .modal-use-info-image-container img{
        display: none;
    }

    .guide-text{
        display: none;
        height: 415px;
        text-align: center;
        font-family:AggroM;
        font-size:25px;
        letter-spacing: -1px;
        line-height:400px;
    }

    .modal-use-info-movie-popup-btn-close{
        z-index: 99999;
    }

</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.rwdImageMaps.min.js"></script>

<script type="text/javascript">

$(document).ready(function(e) {

    $('img[usemap]').rwdImageMaps();

    $("#logout1").click(function () {
        alert('로그아웃1단계');

        $("#logout2").click(function () {
            alert('로그아웃2단계');

            $("#logout3").click(function () {
                alert('로그아웃3단계');

                $("#logout4").click(function () {
                    location.href="/login/logout.php";

                });

            });


        });

    });

});

</script>


<div class="modal-use-info-bg"></div>
<div class="modal-use-info-popup">
    <div class="modal-use-info-popup-btn-close">
        <div></div>
        <div></div>
    </div>

    <div class="modal-use-info-title">홈즈앤루팡 이용안내</div>

    <div class="modal-use-info-image-container">
        <img src="" alt="USEINFO" title="USEINFO">
        <p class="guide-text">
            이용안내 이미지가 없습니다. 관리자에게 문의해주세요!
        </p>
    </div>

    <div class="modal-use-info-btn-container">
        <div class="modal-use-info-btn">
            <p>자세한 내용<br>영상으로 확인하기</p>
            <img src="img/play.png" alt="PLAY" title="PLAY">
        </div>
    </div>

</div>

<div class="modal-use-info-movie-popup">
    <div class="modal-use-info-movie-popup-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-use-info-movie-container">
        <div class="use-info-player-container">
            <div style="position:absolute;background-color:#000;width:100%;height:100px;z-index:99900"></div>
            <div id="useinfoPlayer"></div>
        </div>
    </div>
</div>

<div class="star-container">
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
</div>

<img src="img/homesMainBg.jpg" usemap="#image-map" style="width: 100%; margin-top: -67px;">

<map name="image-map">
    <area target="" id="use-info-link" alt="이용안내" title="이용안내" href="#" coords="551,719,464,802,348,800,320,748,311,715,296,655,295,617,307,616,368,615,423,615,477,616,506,616" shape="poly">
    <area target="" alt="순서/벌칙" title="순서/벌칙" href="main01.php" coords="504,596,294,597,295,549,306,499,325,450,340,422,365,378,387,357,397,345,423,369,455,406,470,415,495,445,514,462,529,478,549,495" shape="poly">
    <area target="" alt="추천게임" title="추천게임" href="main02.php" coords="558,484,412,333,424,316,462,288,482,277,515,260,546,248,593,234,631,227,663,223,664,248,664,288,663,326,663,371,663,401,664,428,664,440" shape="poly">
    <area target="" alt="게임검색" title="게임검색" href="main03.php" coords="680,225,678,437,726,449,753,462,769,469,785,482,820,446,852,414,889,375,934,332,883,291,819,254,752,235" shape="poly">
    <area target="" alt="메뉴주문" title="메뉴주문" href="main04.php" coords="794,494,943,344,1001,421,1017,450,1039,519,1046,557,1049,599,963,597,908,599,836,596" shape="poly">
    <area target="" alt="고객의소리" title="고객의소리" href="main05.php" coords="836,612,1050,612,1044,663,1037,693,1030,721,1015,757,1000,792,992,802,924,802,876,803,826,748,790,713" shape="poly">
    <area target="" alt="로그아웃" title="로그아웃" href="logout.php" coords="88,362,106,368,114,384,111,409,99,419,74,421,60,411,55,389,60,371,70,362" shape="poly">

    <area target="" alt="로그아웃0" title="로그아웃0" href="#" class="logout-btn-0" coords="51,733,50,764,88,766,92,733" shape="poly">
    <area target="" alt="로그아웃1" title="로그아웃1" href="#" class="logout-btn-1" coords="53,677,50,711,92,713,93,680" shape="poly">
    <area target="" alt="로그아웃2" title="로그아웃2" href="#" class="logout-btn-2" coords="56,603,53,646,93,648,94,603" shape="poly">
    <area target="" alt="로그아웃3" title="로그아웃3" href="#" class="logout-btn-3" coords="57,536,56,581,96,582,99,537" shape="poly">
    <area target="" alt="로그아웃4" title="로그아웃4" href="#" class="logout-btn-4" coords="60,469,55,516,98,519,100,473" shape="poly">
</map>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="guide" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="img/guidetext.png" style="display:block; margin: 0px auto;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="width:970px; height:415px;">
        </div>
      </div>
      <div class="modal-footer">
        <a href="#"><img src="img/guidebtn.png"></a>
      </div>
    </div>
  </div>
</div>


<script>
    $(function(){

        // Load the IFrame Player API code asynchronously.
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Replace the 'ytplayer' element with an <iframe> and
        // YouTube player after the API code downloads.
        var player;

        var logoutArr = [];

        $("[class*='logout-btn-']").click(function(){
            switch($(this).attr("class")) {
                case "logout-btn-0":
                    logoutArr[0] = true;
                break;
                case "logout-btn-1":
                    logoutArr[1] = true;
                    break;
                case "logout-btn-2":
                    logoutArr[2] = true;
                    break;
                case "logout-btn-3":
                    logoutArr[3] = true;
                    break;
                case "logout-btn-4":
                    logoutArr[4] = true;
                    break;
            }

            if(logoutArr[0] && logoutArr[1] && logoutArr[2] && logoutArr[3] && logoutArr[4]) {
                window.location.href='logout.php';
            }
        });

        $(".modal-use-info-movie-popup-btn-close").click(function(){

            $("#useinfoPlayer").remove();

            $(".modal-use-info-movie-popup").hide();
        });

        $(".modal-use-info-btn").click(function(){

            $(".use-info-player-container").append("<div id='useinfoPlayer'></div>");

            $.ajax({
                type: 'POST',
                url: "ok/main_ok.php?type=use_info",
                data: {},
                success: function(data) {
                    data = JSON.parse(data);
                    var youtube = data[0].guide_operation_guide_movie;
                    var youtubeId = youtube.split("?v=")[1];
                    // var youtubeId = data[0].guide_operation_guide_movie;

                    onYouTubePlayerAPIReady(youtubeId);

                    function onYouTubePlayerAPIReady(videoId) {
                        player = new YT.Player('useinfoPlayer', {
                            height: $(window).height(),
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
                                $("#useinfoPlayer").remove();
                                $(".modal-use-info-movie-popup").hide();
                            }
                        }

                    }
                }
            });


            $(".modal-use-info-movie-popup").show();
        });

        $(".modal-use-info-popup-btn-close").click(function(){
            $(".modal-use-info-popup, .modal-use-info-bg").toggle();
        });

        $("#use-info-link").click(function(event){
            event.preventDefault();
            $(".modal-use-info-popup, .modal-use-info-bg").toggle();
        });

        $.ajax({
            type: 'POST',
            url: "ok/main_ok.php?type=use_info",
            data: {},
            success: function(data) {
                data = JSON.parse(data);

                // 지점 별 이용안내 이미지 없을 시 본사에서 등록한 이용안내 출력
                var guideImage = "";
                if(data[0].guide_file1 === "") {
                    if(data[0].configImage.sc_basic_guide_img != '')
                    {
                        guideImage = "/data/basic/" + data[0].configImage.sc_basic_guide_img;
                    }
                } else {
                    guideImage = "/data/branch/" + data[0].guide_file1;
                }

                // 본사 이미지도 없을 때 안내 문구 출력
                var img = new Image();
                img.src = guideImage

                // 이미지가 존재할 경우
                img.onload = function () {
                    $(".modal-use-info-image-container img").show();
                    $(".modal-use-info-image-container img").attr("src", guideImage);
                }
                // 없을 경우
                img.onerror = function () {
                    $(".guide-text").show();
                }

            }
        });
    });
</script>

</body>
</html>


