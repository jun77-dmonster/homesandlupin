<?php
include "top.php";
?>
<style>


    html, body {
        margin: 0; height: 100%;
    }

</style>



<!--<div class="container-fluid h-100">-->
<!--  <div class="row h-100">-->
<!--  <div class="col-14 col-sm-12 col-md-12 col-lg-10 col-xl-10">-->
<!--        <table class="scorebox" style="margin-top: 100px;">-->
<!--                <tr>-->
<!--                    <td>-->
<!--                        <img  src="img/upArrow.png"><br/>-->
<!--                        <img  src="img/timerconter.png"><br/>-->
<!--                        <img  src="img/downArrow.png"><br/>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <img  src="img/upArrow.png"><br/>-->
<!--                        <img  src="img/timerconter.png"><br/>-->
<!--                        <img  src="img/downArrow.png"><br/>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <img src="img/dotdot.png" style="text-align: center;">-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <img  src="img/upArrow.png"><br/>-->
<!--                        <img  src="img/timerconter.png"><br/>-->
<!--                        <img  src="img/downArrow.png"><br/>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <img  src="img/upArrow.png"><br/>-->
<!--                        <img  src="img/timerconter.png"><br/>-->
<!--                        <img  src="img/downArrow.png"><br/>-->
<!--                    </td>-->
<!--                </tr>-->
<!---->
<!--        -->
<!--                <tr>-->
<!--                    <td colspan="5">-->
<!--                    <div style="width:100%; height:100px; float:left; position:relative; display:block;">-->
<!--                     </div>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="5">-->
<!--                    <img src="img/reset.png" style="margin-right:15px;"><a href="sub02-01.php"><img src="img/start.png"></a>-->
<!--                    </td>-->
<!--                -->
<!--            </table>-->
<!--            -->
<!--    </div>-->
<!--    <div class="col-2 hidden-md-down" style="background-color: #ffffff; color:white; display:table;">-->
<!--       <div id="qrcontainer">-->
<!--           <p><img src="img/faststart.png"></p>-->
<!--           <p><img src="img/30sec.png"></p>-->
<!--           <p><img src="img/1min.png"></p>-->
<!--           <p><img src="img/5min.png"></p>-->
<!--           <p><img src="img/7min.png"></p>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!-- -->
<!--  </div>-->
<!--</div>-->

    <div class="sub02-container">
        <div class="sub02-timer-container active">

            <div class="sub02-timer-set-container">
                <div class="time-container">
                    <div class="up-arrow" data-limit="9">
                        <img src="img/upArrow.png" alt="UPARROW" title="UPARROW">
                    </div>
                    <div class="time">0</div>
                    <div class="time-add"></div>
                    <div class="down-arrow">
                        <img src="img/downArrow.png" alt="DOWNARROW" title="DOWNARROW">
                    </div>
                </div>
                <div class="time-container">
                    <div class="up-arrow" data-limit="9">
                        <img src="img/upArrow.png" alt="UPARROW" title="UPARROW">
                    </div>
                    <div class="time">0</div>
                    <div class="time-add"></div>
                    <div class="down-arrow">
                        <img src="img/downArrow.png" alt="DOWNARROW" title="DOWNARROW">
                    </div>
                </div>
                <div class="time-colon">
                    <div class="time-colon-center">
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="time-container">
                    <div class="up-arrow" data-limit="5">
                        <img src="img/upArrow.png" alt="UPARROW" title="UPARROW">
                    </div>
                    <div class="time">0</div>
                    <div class="time-add"></div>
                    <div class="down-arrow">
                        <img src="img/downArrow.png" alt="DOWNARROW" title="DOWNARROW">
                    </div>
                </div>
                <div class="time-container">
                    <div class="up-arrow" data-limit="9">
                        <img src="img/upArrow.png" alt="UPARROW" title="UPARROW">
                    </div>
                    <div class="time">0</div>
                    <div class="time-add"></div>
                    <div class="down-arrow">
                        <img src="img/downArrow.png" alt="DOWNARROW" title="DOWNARROW">
                    </div>
                </div>
            </div>

            <div class="sub02-btn-container">
                <div class="sub02-btn-center-container">
                    <button class="btn-timer-re-setting">재설정</button>
                    <button class="btn-timer-start">시작</button>
                    <button class="btn-timer-stop">일시정지</button>
                    <button class="btn-timer-resume">재개</button>
                    <button class="btn-timer-re-start">재시작</button>
                    <button class="btn-timer-power">종료</button>
                </div>
            </div>
        </div>
        <div class="sub02-quick-container active">
            <div class="quick-title">빠른시작</div>
            <div class="quick-tab-container">
                <div>
                    <p data-time="0030">30</p>
                    <p>초</p>
                </div>
                <div>
                    <p data-time="0100">1</p>
                    <p>분</p>
                </div>
                <div>
                    <p data-time="0500">5</p>
                    <p>분</p>
                </div>
                <div>
                    <p data-time="0700">7</p>
                    <p>분</p>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(function(){

            var sum = 0;
            var resum = 0;
            var interval = function(){};
            var colonInterval = function(){};

            $(".btn-timer-re-start").click(function(){
                sum = resum;

                timerInterval();
                interval = setInterval(function(){
                    return timerInterval();
                }, 1000);

                colonAnimation();
                colonInterval = setInterval(function(){
                    return colonAnimation();
                }, 1000);

                $(".sub02-timer-container").css({
                    backgroundColor: '#03254b'
                });

                $(".btn-timer-stop, .btn-timer-start, .btn-timer-re-setting, .btn-timer-re-start").hide();
                $(".btn-timer-power, .btn-timer-stop").show();
            });

            function colonAnimation() {
                $(".time-colon-center")
                    .animate({
                        opacity: .25
                    }, 1000 / 3)
                    .delay(1000 / 3)
                    .animate({
                        opacity: 1
                    });
            }

            $(".btn-timer-re-setting").click(function(){
                $(".time").text(0);
                $(".time-add").css({
                    backgroundImage: 'url("img/count/0.png")',
                });
            });
            $(".btn-timer-power").click(function(){

                timerClear();

                $(".time").text(0);
                $(".time-add").css({
                    backgroundImage: 'url("img/count/0.png")',
                });

                // $(".header").css({
                //     display: 'block'
                // });
                // $(".sub02-container").css({
                //     height: 'calc(100% - 98px)'
                // });
                $(".sub02-timer-set-container").css({
                    marginTop: '11px',
                });
                $(".sub02-btn-center-container").css({
                    marginTop: '0'
                });
                $(".sub02-timer-container").css({
                    width: '1070px',
                    transition: '.2s',
                    backgroundColor: '#fff',
                });
                $(".sub02-timer-container").css({
                    transition: '.2s',
                    backgroundColor: '#fff'
                });
                $(".up-arrow, .down-arrow").css({
                    display: 'block'
                });
                $(".time-colon").css({
                    height: '415px'
                });
                $(".time-add").css({
                    top: '50px'
                });
                $(".sub02-quick-container").css({
                    width: '20%'
                });

                // $(".time").css({
                //     marginTop: '0'
                // });

                $(".btn-timer-re-setting, .btn-timer-start").show();
                $(".btn-timer-stop, .btn-timer-power, .btn-timer-re-start, .btn-timer-resume").hide();
            });
            $(".btn-timer-stop").click(function(){
                timerClear();
                $(".btn-timer-stop").hide();
                $(".btn-timer-resume").show();
            });
            $(".btn-timer-resume").click(function(){
                $(".btn-timer-resume").hide();
                $(".btn-timer-start").click();
            });

            $(".up-arrow").click(function(){
                var num = parseInt($($(this).parent().find(".time")).text());

                if(num < parseInt($(this).data("limit"))) {
                    num++;
                } else {
                    num = 0;
                }

                $($(this).parent().find(".time")).text(num);
                $($(this).parent().find(".time-add")).css({
                    backgroundImage: 'url(img/count/' + num + '.png)'
                });
            });

            $(".down-arrow").click(function(){
                var num = parseInt($($(this).parent().find(".time")).text());

                if(num > 0) {
                    num--;
                } else {
                    num = 9;
                }

                $($(this).parent().find(".time")).text(num);
                $($(this).parent().find(".time-add")).css({
                    backgroundImage: 'url(img/count/' + num + '.png)'
                });
            });


            function timerStart() {
                var min = parseInt($(".time-container:nth-child(1) .time").text() + $(".time-container:nth-child(2) .time").text()) * 60;
                var second = parseInt($(".time-container:nth-child(4) .time").text() + $(".time-container:nth-child(5) .time").text());

                if(min === 0 && second === 0)
                    return false;


                sum = min + second;
                resum = sum;

                timerInterval();
                interval = setInterval(function(){
                    return timerInterval();
                }, 1000);

                colonAnimation();
                colonInterval = setInterval(function(){
                    return colonAnimation();
                }, 1000);

                // $(".header").css({
                //     display: 'none'
                // });
                // $(".sub02-container").css({
                //     height: '100%'
                // });
                $(".sub02-timer-set-container").css({
                    marginTop: '55px',
                    left: '50%',
                    transform: 'translateX(-50%)'
                });
                $(".sub02-btn-center-container").css({
                    marginTop: '-55px'
                });
                $(".sub02-timer-container").css({
                    width: '100%',
                    transition: '.2s',
                    backgroundColor: '#03254b',
                });
                $(".sub02-timer-container").css({
                    transition: '.2s',
                    backgroundColor: '#03254b'
                });
                $(".up-arrow, .down-arrow").css({
                    display: 'none'
                });
                $(".time-colon").css({
                    height: '308px'
                });
                $(".time-add").css({
                    top: 0
                });
                $(".sub02-quick-container").css({
                    width: '0'
                });
                // $(".time").css({
                //     marginTop: '55px'
                // });

                $(".btn-timer-re-setting, .btn-timer-start, .btn-timer-re-start, .btn-timer-resum").hide();
                $(".btn-timer-stop, .btn-timer-power").show();
            }

            $(".btn-timer-start").click(function(){
                timerStart();
            });

            $(".quick-tab-container > div").click(function(){
                timerClear();
                var dataTime = $($(this).find("p:first-child")).data("time");

                $(".time-container:nth-child(1) .time").text(dataTime[0]);
                $(".time-container:nth-child(2) .time").text(dataTime[1]);
                $(".time-container:nth-child(4) .time").text(dataTime[2]);
                $(".time-container:nth-child(5) .time").text(dataTime[3]);


                $(".time-container:nth-child(1) .time-add").css({ backgroundImage: 'url("img/count/' + dataTime[0] + '.png")'});
                $(".time-container:nth-child(2) .time-add").css({ backgroundImage: 'url("img/count/' + dataTime[1] + '.png")'});
                $(".time-container:nth-child(4) .time-add").css({ backgroundImage: 'url("img/count/' + dataTime[2] + '.png")'});
                $(".time-container:nth-child(5) .time-add").css({ backgroundImage: 'url("img/count/' + dataTime[3] + '.png")'});


                $(".btn-timer-start").click();
            });

            function timerClear() {
                clearInterval(interval);
                clearInterval(colonInterval);
            }

            function timerInterval() {

                if(sum === 0) {
                    timerClear();
                    $(".sub02-timer-container").css({
                        backgroundColor: '#fff',
                    });
                    $(".btn-timer-re-start").show();
                    $(".btn-timer-stop").hide();
                }

                var newMin = Math.floor(sum / 60);
                var newSecond = Math.floor(sum % 60);

                if(newMin < 10) {
                    newMin = "0" + newMin;
                } else {
                    newMin += "";
                }
                if(newSecond < 10) {
                    newSecond = "0" + newSecond;
                } else {
                    newSecond += "";
                }

                $(".time-container:nth-child(1) .time").text(newMin[0]);
                $(".time-container:nth-child(2) .time").text(newMin[1]);
                $(".time-container:nth-child(4) .time").text(newSecond[0]);
                $(".time-container:nth-child(5) .time").text(newSecond[1]);


                $(".time-container:nth-child(1) .time-add").css({ backgroundImage: 'url(img/count/' + newMin[0] + '.png)' });
                $(".time-container:nth-child(2) .time-add").css({ backgroundImage: 'url(img/count/' + newMin[1] + '.png)' });
                $(".time-container:nth-child(4) .time-add").css({ backgroundImage: 'url(img/count/' + newSecond[0] + '.png)' });
                $(".time-container:nth-child(5) .time-add").css({ backgroundImage: 'url(img/count/' + newSecond[1] + '.png)' });


                sum--;
            }

        });

    </script>

</body>
</html>