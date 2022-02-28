<?php
include "top.php";
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
    }

</style>



<!--<div class="container-fluid h-100">-->
<!--  <div class="row h-100">-->
<!---->
<!--    <div class="scorebox">-->
<!--        <div id="tab">-->
<!--            <div class="subtab2 stabactive">-->
<!--                1인-->
<!--            </div>-->
<!--            <div class="subtab2">-->
<!--            2인-->
<!--            </div>-->
<!--            <div class="subtab2">-->
<!--            3인-->
<!--            </div>-->
<!--            <div class="subtab2" >-->
<!--            4인-->
<!--            </div>-->
<!--            <div class="subtab2" >-->
<!--            5인-->
<!--            </div>-->
<!--            <div class="subtab2" style="margin-right:0px;">-->
<!--            6인-->
<!--            </div>-->
<!--        </div>-->
<!--        <div style="width:1220px; height:640px; float:left; position:relative; background:darkblue; color:white; text-align:center;">-->
<!--        이미지 영역-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<div class="main02-2-tab-container">
    <div class="active">2인</div>
    <div>3인</div>
    <div>4인</div>
    <div>5인</div>
    <div>6인</div>
    <div>7인+</div>
</div>

<div class="main02-2-img-container">
    <img src="" alt="GAMES" title="GAMES">
</div>

<script>
    $(function(){

        $.ajax({
            type: "POST",
            data: {},
            url: "ok/main02-2_ok.php?type=person_game",
            success: function(data) {

                data = JSON.parse(data);

                console.log(data);

                $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player2_img);

                $(".main02-2-tab-container > div").click(function(){
                    switch($(this).index()) {
                        case 0:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player2_img);
                            break;
                        case 1:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player3_img);
                            break;
                        case 2:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player4_img);
                            break;
                        case 3:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player5_img);
                            break;
                        case 4:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player6_img);
                            break;
                        case 5:
                            $(".main02-2-img-container img").attr("src", "data/branch/" + data.guide_player7_img);
                            break;
                    }
                    $(this).addClass("active").siblings().removeClass("active");
                });

            }
        });



    });
</script>
</body>
</html>