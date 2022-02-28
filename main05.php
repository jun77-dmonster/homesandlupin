<?php
include "top.php";

$branch_cd = get_session('branch_cd');
$room_cd = get_session('room_cd');

?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
    }

</style>

<script type="text/javascript">

$().ready(function () {
        $("#alertStart").click(function () {
            var customer_content = $('#customtextarea').val();
            var branch_cd = $('#branch_cd').val();
            var room_cd = $('#room_cd').val();
            var write_gubun = $('#write_gubun').val();


            if(customer_content == "") {
                alert('고객의 소리를 작성해주세요.');
                $('#customtextarea').focus();
                return false;
            }

            var allData = {
                'customer_content' : customer_content
                , 'branch_cd' : branch_cd
                , 'room_cd' : room_cd
                , 'write_gubun' : write_gubun

            };

            $.ajax({
                dataType : "html",
                url : "customer/insertrq.php",
                type:'POST',
                data: allData,
                success : function(data){

                    Swal.fire({
                        icon: 'success', // Alert 타입
                        title: '등록완료', // Alert 제목
                        text: '고객의 소리가 접수되었습니다:)', // Alert 내용
                    });


                }, error : function(){
                    alert("로딩실패!");
                }
            });

    }); 
});

</script>

<!--<div class="container-fluid h-100">-->
<!--  <div class="row h-100">-->
<!--      <div class="col-12 col-sm-6 col-md-8 ">-->
<!--          <div class="row text-center">-->
<!--            <div class="requestbox">-->
<!--                <img src="img/customer_text.png" style="margin-bottom:15px;">-->
<!--                <p>홈즈앤루팡을 이용 하며 좋았던 점 / 개선점이 있다면 알려주세요!</p>-->
<!--                <p>해당 내용은 <span style="color:#FF8C00;">홈즈앤루팡 보드게임카페 본사</span>로 전달됩니다.</p>-->
<!--                <p>이용 중 불편 사항은 <span style="color:#FF8C00;">카운터에 문의</span>해주시면 빠르게 도와드리겠습니다. :)</p>-->
<!---->
<!--                <form action="customer/insertrq.php" name="customform" id="customform" method="post">-->
<!--                    <input type="hidden" name="branch_cd"  id="branch_cd" value="--><?//=$branch_cd?><!--">-->
<!--                    <input type="hidden" name="room_cd" id="room_cd" value="--><?//=$room_cd?><!--">-->
<!--                    <input type="hidden" name="write_gubun" id="write_gubun" value="app">-->
<!--                    <textarea name="customer_content" id="customtextarea"></textarea>-->
<!--                    <p><a href="#" id="alertStart"><img src="img/submitbtn.png"></a></p>-->
<!--                </form>-->
<!---->
<!---->
<!--            </div>-->
<!---->
<!--          </div>-->
<!--    </div>-->
<!--    <div  class="col-6 col-md-4" style="background-color: #3F2958; color:white; display:table;">-->
<!--       <div id="qrcontainer">-->
<!--            <div id="qrbox">-->
<!--                <img src="img/qrtext.png">-->
<!--                <div class="qrinbox">-->
<!--                    <img src="img/qrcode.png">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--  </div>-->
<!--</div>-->


    <div class="modal-client-blue-popup">
        <div class="modal-client-title">고객의 소리가 접수되었습니다:)</div>
        <div class="modal-client-btn-container">
            <div class="modal-client-btn">확인</div>
        </div>
    </div>

    <div class="main05-container">
        <div class="form-container">
            <div class="form-title">고객의 소리</div>
            <div class="form-content">
                홈즈앤루팡을 이용 하며 좋았던 점 / 개선점이 있다면 알려주세요!<br>
                해당 내용은 <span>홈즈앤루팡 보드게임카페 본사</span>로 전달됩니다.<br>
                이용 중 불편 사항은 <span>카운터에 문의</span>해주시면 빠르게 도와드리겠습니다 :)
            </div>
            <textarea id="client-textarea" cols="30" rows="10"></textarea>
            <div class="client-btn-container">
                <button class="client-btn">전송하기</button>
            </div>
        </div>
        <div class="qrcode-container">
            <div class="qrcode-center">
                <img src="img/qrtext.png">
                <img src="img/qrcode.png">
            </div>
        </div>
    </div>

    <script>
        $(function(){

            $(".modal-client-btn").click(function(){
                $(".modal-client-blue-popup").hide();
            });

            $(".client-btn").click(function(){
                if($("#client-textarea").val()) {
                    $.ajax({
                        type: "POST",
                        url: "ok/main05_ok.php?type=client_insert",
                        data: { customer_content: $("#client-textarea").val() },
                        success: function() {
                            $("#client-textarea").val("");
                            $(".modal-client-blue-popup").show();
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>