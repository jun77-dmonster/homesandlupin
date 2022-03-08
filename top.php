<?php 
include "common.php";
session_start();

$branch_cd = $_SESSION['branch_cd'];

if(!isset($_SESSION['branch_cd']) or !isset($_SESSION['branch_cdcommon'])){
    goto_url("/index.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>

<title>홈즈앤 루팡</title>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<style>
    .modal-wifi-image-container img{
        display:none;
    }

    .modal-wifi-image-container .wifi-text{
        display: none;
        height: 415px;
        text-align: center;
        font-family:AggroM;
        font-size:25px;
        letter-spacing: -1px;
        line-height:570px;
        min-height: 576px;
    }
</style>

<div class="modal-order-success-blue-popup">
    <p>
        메뉴가 준비되었습니다!<br>
        <span>계산서와 결제수단을 지참</span>해<br>
        <span>카운터에서 픽업</span>해주세요:)
    </p>
    <div class="btn-order-success-container">
        <button class="btn-order-success">확인</button>
    </div>
    <p>※계산서 미 지참시 픽업시 지연될 수 있으니,꼭! 확인 부탁드려요</p>
</div>

<div class="header">
    <div class="searchbox">
        <a href="index.php"><img src="img/home.png" style="float: left;"></a> 
        <div id="drop_the_text">
            <a id="search_link" href="#"><img src="img/search.png"></a>
            <input type="text" placeholder="" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" id="write_list">
        </div>
    </div>
    <div class="logo">
        <a href="index.php"><img src="img/logo.png"></a> 
    </div>
    <div class="menu">
<!--        <div class="submenu">-->
<!--            <img src="img/m_title.png" style="display: block;">-->
<!--            <img src="img/t_menu.png" usemap="#smenutitle">-->
<!--            <map name="smenutitle">-->
<!--                <area shape="rect" coords="2,2.75,80.75,25" href="#" data-toggle="modal" data-target="#wifi">-->
<!--                <area shape="rect" coords="87.75,2,166,25" href="sub01.php">-->
<!--                <area shape="rect" coords="173,1.75,251,25" href="sub02.php">-->
<!--                <area shape="rect" coords="258.50,2.75,335.50,25" href="sub03.php">-->
<!--            </map>-->
<!--        </div>-->
        <div class="branch-info-container">
            <img src="img/branch-icon.png" alt="BRANCH" title="BRANCH">
            <p><?PHP echo $_SESSION['branch_string']?> R<?PHP echo $_SESSION['room_string']?></p>
        </div>
        <div class="top-navigation-container">
<!--            <button data-toggle="modal" data-target="#wifi">-->

            <button onclick="window.location.href='sub03.php'">
                <div>
                    <img src="img/kg-icon.png" alt="WIFI" title="WIFI">
                    <span>스코어</span>
                </div>
            </button>
            <button onclick="window.location.href='sub02.php'">
                <div>
                    <img src="img/timer-icon.png" alt="WIFI" title="WIFI">
                    <span>타이머</span>
                </div>
            </button>
            <button onclick="window.location.href='sub01_.php'">
                <div>
                    <img src="img/answer-icon.png" alt="WIFI" title="WIFI">
                    <span>FAQ</span>
                </div>
            </button>
            <button id="btn-wifi">
                <div>
                    <img src="img/wifi-icon.png" alt="WIFI" title="WIFI">
                    <span>와이파이</span>
                </div>
            </button>



        </div>
    </div>
</div>
</div>


<div class="modal-wifi-popup">
    <div class="modal-wifi-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-wifi-image-container">
        <img src="" alt="WIFI" title="WIFI">
        <p class="wifi-text">
            와이파이 안내 이미지가 없습니다. 관리자에게 문의해주세요!
        </p>
    </div>
</div>
<div class="modal-wifi-bg"></div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="wifi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div style="width:1005px; height:576px;"></div>
    </div>
  </div>
</div>

<script>
    $(function(){

        var successOrderInterval;
        var successOrderIntervalTime = 3000;

        var successOrderDate = "";

        var successOrderCartId = new Array();

        // function AddComma(num)
        // {
        //     var regexp = /\B(?=(\d{3})+(?!\d))/g;
        //     return num.toString().replace(regexp, ',');
        // }

        function getSuccessOrderData() {
            return $.ajax({
                type: "POST",
                url: "ok/main04_ok.php?type=success_order",
                async: false,
                data: {},
                success: function(data) {
                    getSuccessOrderDataCallBack(data);
                }
            });
        }

        function getSuccessOrderDataCallBack(data) {
            // console.log(data);
            var data = JSON.parse(data);
            console.log(data);

            if(data.length > 0) {

                var arrValues = data;
                console.log(arrValues);
                var arrCheckVal = new Array();

                var chk = true;

                for(var i = 0; i < arrValues.length; i++) {

                    chk = true;

                    for(var value in arrCheckVal) {
                        if(arrCheckVal[value] == arrValues[i].od_id) {
                            chk = false;
                        }
                    }

                    if(chk)
                        arrCheckVal.push(arrValues[i].od_id);
                }


                successOrderCartId = arrCheckVal;

                $(".modal-order-success-blue-popup").show();
            }
        }

        function setIntervalSuccessOrderPopup() {
            getSuccessOrderData();
            successOrderInterval = setInterval(function(){
                getSuccessOrderData();
            }, successOrderIntervalTime);
        }

        function setClearIntervalSuccessOrderPopup() {
            return clearInterval(successOrderInterval);
        }

        setIntervalSuccessOrderPopup();

        $(document).on("click", ".btn-order-success", function(event){

            setClearIntervalSuccessOrderPopup();

            var wherein = successOrderCartId.join(',');

            console.log(wherein);

            $.ajax({
                type: 'POST',
                url: 'ok/main04_ok.php?type=success_order_check',
                data: {
                    wherein: wherein,
                },
                success: function(data){
                    console.log(data);
                    // $(".modal-order-success-blue-popup").hide();
                    $(".modal-order-success-blue-popup").hide();
                    setIntervalSuccessOrderPopup();
                }
            });


        })


        // 메뉴 주문 완료 알림 팝업

        // interval_order();
        // var time_interval = setInterval(function(){
        //     interval_order();
        // }, 3000);
        //
        // function interval_order(){
        //     let branch_cd = 'B9168'
        //     $.ajax({
        //         url: "ok/main04_ok.php?type=order_popup",
        //         method: "POST",
        //         dataType: "json"
        //     }).done(function(json) {
        //         console.log(json)
        //         if(json.list || json.order){
        //             if(json.list)
        //             {
        //                 let req_data = json.list[0]
        //                 $('.request .txt-cont .game-image-area').prepend("<img src='"+"http://dmonster9995.ingyu7.gethompy.com/data/boardgames/"+req_data.games_img_file+"' style='width:130px;'>")
        //                 $('.request .room_cd').html(req_data.room_no)
        //                 $('.request .request_reg_dt').html(req_data.request_reg_dt)
        //                 $('.request .games_nm').html(req_data.games_nm)
        //                 $('.request #employee_uid').val(req_data.uid)
        //             }
        //             if(json.order)
        //             {
        //                 let order_data = json.order[0]
        //                 $('.order .txt-cont .game-image-area').prepend("<img src='"+"http://dmonster9995.ingyu7.gethompy.com/data/boardgames/"+order_data.games_img_file+"' style='width:130px;'>")
        //                 $('.order .room_no').html(order_data.room_no)
        //                 $('.order .request_reg_dt').html(order_data.od_time)
        //                 $('.order .games_nm').html(order_data.games_nm)
        //                 $('.order #employee_uid').val(order_data.uid)
        //             }
        //             $(".ajax.popup_bg").show();
        //             $(".ajax.popup").show(700);
        //             clearInterval(time_interval);
        //         }
        //     })
        // }

        // 메뉴 주문 완료 알림 팝업




        $("#btn-wifi").click(function(event){
            $(".modal-wifi-popup, .modal-wifi-bg").toggle();
        });

        $(".modal-wifi-btn-close").click(function(){
            $(".modal-wifi-popup, .modal-wifi-bg").hide();
        });

        $("#search_link").click(function(event){
            event.preventDefault();

            if($("#write_list").val()) {
                window.location.href='/main03.php?keyword=' + $("#write_list").val();
            }
        });

        $.ajax({
            type: 'POST',
            url: 'ok/top_ok.php?type=wifi',
            data: {},
            success: function(data) {
                data = JSON.parse(data);
                
                // 지점 별 와이파이 이미지 없을 시 본사에서 등록한 와이파이 출력
                var guideImage = "";
                if(data[0].guide_file2 === "") {
                    guideImage = "/data/basic/" + data[0].wifiImage;
                } else {
                    guideImage = "/data/branch/" + data[0].guide_file2;
                }
                
                // 본사 이미지도 없을 때 안내 문구 출력
                var img = new Image();
                img.src = guideImage

                // 이미지가 존재할 경우
                img.onload = function () {
                    $(".modal-wifi-image-container img").show();
                    $(".modal-wifi-image-container img").attr("src", guideImage);
                }
                // 없을 경우
                img.onerror = function () {
                    $(".wifi-text").show();
                }
            }
        });

    });
</script>