<?php
include "top.php";
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
        background-image: url(./img/punishBg.jpg);
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color:#464646;
    }

</style>

<script type="text/javascript">
// $( document ).ready(function() {
//     $('#ruletpop').modal('show');
// });
  
</script>



<div class="container-fluid h-100" >
  <div class="row h-100">
        
        <div class="ruletbox">
        <img src="img/homesSelctor.png" style=" top:0px; position:absolute; left:520px;">    
            <img src="img/backcircle.png" style=" bottom:100px; position:absolute; left:50px;">
            <a href="main02-1result.php"><img src="img/startcircle_nostart.png" style=" bottom:-30px; position:absolute; left:390px;"></a>      
        </div>

</div>
</body>


<style>
    .modal-header .close {
        margin:0px;
    }
    .modal-footer {
        justify-content: center;
    }
</style>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="ruletpop" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 style="display:block; margin: 0px auto;">벌칙당첨</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="width:100%; float:left; padding:30px;">
            <div style="width:30%; float:left; text-align:center;">
                <div style="width: 210px; height:210px; background:#B0B0B0; margin-bottom:20px;">
                </div>
                <img src="img/intromovie_1.png">
             </div>
             <div style="width:70%; float:left; text-align:center;">
                <h2>게임이름</h2>
                <p>게임에 대한 간단한 설명! 어쩌구 저쩌구<br/>이렇게저렇게 하는 게임이에요~:)</p>
                <span style="width: 100%; display:block; margin-top:30px;">
                    <p>추천인원 0명~0명</p>
               
                        <span style="width: 100%; display:block; margin-top:10px;">난이도 : 보통</span>
                        <span style="width: 100%; display:block; margin-top:10px;">장르 : 추리</span>
                  
                </span>
             </div>
        </div>
      </div>
   
    </div>
  </div>
  <div class="customfooter" style="margin-top:-150px; text-align:center;">
        <a href="main02-1.php"><img src="img/forward.png"></a><a href="#"><img src="img/replay.png"></a>
      </div>
</div>