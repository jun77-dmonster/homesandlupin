<?php
include "top.php";

$sql = "SELECT * FROM DM_T_BASE_GUIDE WHERE branch_cd='" . $_SESSION['branch_cd'] . "' AND guide_use_fl = 'T' AND guide_delete_fl = 'F'";
$result = sql_query($sql);
$baseImage = sql_fetch_array($result);

$scSql = "SELECT
    sc_recommend_player2_img as re2,
    sc_recommend_player3_img as re3,
    sc_recommend_player4_img as re4,
    sc_recommend_player5_img as re5,
    sc_recommend_player6_img as re6,
    sc_recommend_player7_img as re7
FROM
DM_T_SITE_CONFIG";
$query = sql_query($scSql);
$configImage = sql_fetch_array($query);

$image = [];
foreach(range(2, 7) as $value)
{
    if($baseImage['guide_player' . $value . '_img'] != "")
    {
        $image[$value] = '/data/branch/' . $baseImage['guide_player' . $value . '_img'];
    }
    else if($configImage['guide_player' . $value . '_img'] != "")
    {
        $image[$value] = '/data/basic' . $configImage['guide_player' . $value . '_img'];
    }
    else
    {
        $image[$value] = "";
    }
}
?>
<style>
    .col-14 {text-align: center;}

    html, body {
        margin: 0; height: 100%; overflow: hidden; 
    }
    
    .main02-2-img-container p{
        height: 540px;
        line-height:540px;
        text-align: center;
        font-family:AggroM;
        font-size:25px;
        letter-spacing: -1px;
    }
</style>

<div class="main02-2-tab-container">
    <div class="active">2인</div>
    <div>3인</div>
    <div>4인</div>
    <div>5인</div>
    <div>6인</div>
    <div>7인+</div>
</div>

<div class="main02-2-img-container">
    <?php foreach($image as $key => $value):?>
    <?php $show = $key === 2 ? 'block' : 'none';?>
    <div class="box" style="display: <?php echo $show?>">
        <?php if($value != ""):?>
            <img src="<?php echo $value?>" alt="GAMES" title="GAMES">
        <?php else:?>
            <p>이미지가 없습니다. 관리자에게 문의해주세요!</p>
        <?php endif;?>
    </div>
    <?php endforeach;?>
</div>

<script>
    $(function(){

        $.ajax({
            type: "POST",
            data: {},
            url: "ok/main02-2_ok.php?type=person_game",
            success: function(data) {
                data = JSON.parse(data);

                $(".main02-2-tab-container > div").click(function(){
                    $(".main02-2-img-container .box").hide();
                    switch($(this).index()) {
                        case 0:
                            $(".main02-2-img-container .box").eq(0).show();
                            break;
                        case 1:
                            $(".main02-2-img-container .box").eq(1).show();
                            break;
                        case 2:
                            $(".main02-2-img-container .box").eq(2).show();
                            break;
                        case 3:
                            $(".main02-2-img-container .box").eq(3).show();
                            break;
                        case 4:
                            $(".main02-2-img-container .box").eq(4).show();
                            break;
                        case 5:
                            $(".main02-2-img-container .box").eq(5).show();
                            break;
                        case 6:
                            $(".main02-2-img-container .box").eq(6).show();
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