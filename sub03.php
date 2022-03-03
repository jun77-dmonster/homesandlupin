<?php
include "top.php";
?>
<!--<style>-->
<!--    .col-14 {text-align: center;}-->
<!---->
<!--  -->
<!--    html, body {-->
<!--        margin: 0; height: 100%; overflow: hidden; -->
<!--    }-->
<!---->
<!--</style>-->



<!--<div class="container-fluid h-100">-->
<!--  <div class="row h-100">-->
<!---->
<!--    <div class="scorebox">-->
<!--        <div class="scoreleft">-->
<!--            <p><img src="img/purplePlus.png"></p>-->
<!--            <p><img src="img/purpleBack2.png"></p>-->
<!--            <p><img src="img/purpleMinus.png"></p>-->
<!--        </div>-->
<!--        <div class="scoreright">-->
<!--            <p><img src="img/bluePlus.png"></p>-->
<!--            <p><img src="img/blueBack.png"></p>-->
<!--            <p><img src="img/blueMinus.png"></p>-->
<!--        </div>-->
<!--        <p><img src="img/resetbtn.png"></p>-->
<!--    </div>-->
<!--</div>-->

    <div class="score-container">
        <div class="score-left-container">
            <div class="plus">
                <div>+</div>
            </div>
            <div class="score">
                <div>
                    <div>
                        <div><img src="" alt="COUNT" title="COUNT"></div>
                        <div><img src="" alt="COUNT" title="COUNT"></div>
                    </div>
                </div>
            </div>
            <div class="minus">
                <div>-</div>
            </div>
        </div>
        <div>
            <div></div>
            <div></div>
        </div>
        <div class="score-right-container">
            <div class="plus">
                <div>+</div>
            </div>
            <div class="score">
                <div>
                    <div>
                        <div><img src="" alt="COUNT" title="COUNT"></div>
                        <div><img src="" alt="COUNT" title="COUNT"></div>
                    </div>
                </div>
            </div>
            <div class="minus">
                <div>-</div>
            </div>
        </div>

        <div class="btn-reset-container">
            <button class="btn-reset">초기화</button>
        </div>
    </div>


    <script>

        $(function(){

            var score = [0, 0];

            $(".score-left-container .plus").click(function(){
                if(score[0] < 99)
                    score[0] += 1;

                leftScoreHTMLUpdate();
            });
            $(".score-left-container .minus").click(function(){
                if(score[0] > 0)
                    score[0] -= 1;

                leftScoreHTMLUpdate();
            });

            $(".score-right-container .plus").click(function(){
                if(score[1] < 99)
                    score[1] += 1;

                rightScoreHTMLUpdate();
            });
            $(".score-right-container .minus").click(function(){
                if(score[1] > 0)
                    score[1] -= 1;

                rightScoreHTMLUpdate();
            });

            $(".btn-reset").click(function(){
                score = [0, 0];

                leftScoreHTMLUpdate();
                rightScoreHTMLUpdate();
            });

            function leftScoreHTMLUpdate() {

                var score0 = 0;

                if(score[0] < 10)
                    score0 = "0" + score[0];
                else
                    score0 = score[0] + "";

                $(".score-left-container .score div div div:first-child img").attr("src", "img/count/" + score0[0] + ".png");
                $(".score-left-container .score div div div:last-child img").attr("src", "img/count/" + score0[1] + ".png");
            }

            function rightScoreHTMLUpdate() {
                var score1 = 0;

                if(score[1] < 10)
                    score1 = "0" + score[1];
                else
                    score1 = score[1] + "";

                $(".score-right-container .score div div div:first-child img").attr("src", "img/count/" + score1[0] + ".png");
                $(".score-right-container .score div div div:last-child img").attr("src", "img/count/" + score1[1] + ".png");
            }

            rightScoreHTMLUpdate();
            leftScoreHTMLUpdate();

        })

    </script>

</body>
</html>