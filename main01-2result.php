<?php
include "top.php";
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
        margin: 0; height: 100%; overflow: hidden; 
        background-image: url(./img/holmesBg2.jpg);
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



<div class="modal-bg"></div>
<div class="modal-penalty-popup">
    <div class="modal-penalty-popup-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-penalty-popup-title">벌칙당첨!</div>
    <div class="modal-penalty-popup-image-container">
        <img src="" alt="PENALTY" title="PENALTY">
    </div>
    <div class="modal-penalty-popup-penalty-title"></div>
    <div class="modal-penalty-popup-penalty-content"></div>
    <div class="modal-penalty-popup-btn-container">
        <button>다시하기</button>
    </div>
</div>

<div class="container-fluid h-100" >
  <div class="row h-100">

      <div style="position: absolute; width: 1100px; height: 550px; overflow: hidden; left:50%; transform: translateX(-50%); bottom: 0; z-index: 100;">
          <canvas id='canvas' width='1100' height='500'>
              Canvas not supported, use another browser.
          </canvas>
          <div style="
            /*background-color: black;*/
            width: 2px;
            height: 20px;
            position: absolute;
            top: 20px;
            left: 549px;">&nbsp;</div>
          <img src="img/homesleft.png" style="
                position: absolute;
                left: -8px;
                width: 500px;
                top: 165px;
                transform: rotate(-22deg);
            "/>
          <img src="img/homesright.png"style="
                position: absolute;
                right: -8px;
                width: 500px;
                top: 165px;
                transform: rotate(22deg);
            "/>
          <img src="img/startcircle_nostart.png"
               id="startCircle"
               style="
                position: absolute;
                top: 325px;
                left: 385px;
            "/>
          <div class="touch">touch!</div>
      </div>

        <div class="ruletbox">

            <img src="img/homesSelctor.png" style=" z-index: 100; top:70px; position:absolute; left:520px;">
<!--            <img src="img/homesleft.png" style=" bottom:100px; position:absolute; left:30px;">-->
<!--            <img src="img/startcircle_nostart.png" style=" bottom:-30px; position:absolute; left:390px;">-->
<!--            <img src="img/homesright.png" style=" bottom:100px; position:absolute; left:620px;">-->
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
            <div style="width:160px; height:160px; border-radius:50%; background:#464646; margin:0 auto;"></div>
            <h5 style="display:block; margin: 0px auto; text-align:center;">벌칙제목</h5>
            <h6 style="display:block; margin: 0px auto; text-align:center;">벌칙내용 설명 ! 이벌칙을 <br/> 누구에게 이렇게 하세요!<br>주의 : 이렇게이렇게 하면 안됨!</h6>
        </div>
      </div>
      <div class="modal-footer">
        <a href="main01-2.php"><img src="img/다시하기btn.png"></a>
      </div>
    </div>
  </div>
</div>

    <script src="js/wheel/Winwheel.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js'></script>
    <script>



        $(function(){

            var dataList = [];

            $(document).on("click", ".modal-penalty-popup-btn-close", function(){
                $(".modal-penalty-popup, .modal-bg").hide();
            })

            $.ajax({

                type: 'POST',
                url: 'ok/main01-2result_ok.php?type=wheelInfoData',
                data: {},
                success: function(data){

                    data = JSON.parse(data);
                    dataList = data;

                    console.log(data);

                    var arr = [];

                    arrayPush();

                    function arrayPush() {
                        for(var i = 0; i < data.length; i++) {
                            if(arr.length < 10) {
                                arr.push({
                                    'image': "data/penalty/" + data[i].penalty_img,
                                    'index': i,
                                    'title': data[i].penalty_title,
                                    'content': data[i].penalty_content,
                                });
                            }
                        }

                        if(arr.length < 10)
                            arrayPush();
                    }

                    console.log(arr);

                    let theWheel = new Winwheel({
                        //'numSegments'  : 10,         // Number of segments
                        'numSegments': arr.length,
                        'outerRadius'  : 390,       // The size of the wheel.
                        'centerX'      : 550,       // Used to position on the background correctly.
                        'centerY'      : 500,
                        'textFontSize' : 17,        // Font size.
                        'textOrientation'   : 'curved',     // Note use of curved text.
                        'textAligment' : 'outer',
                        'textMargin':150,
                        'textDirection'     : 'desired',
                        'yoyo':true,
                        'strokeStyle':'#7B9BA5',
                        'lineWidth':23,
                        'drawMode':"segmentImage",
                        'drawText': false,
                        'imageDirection':'S',
                        // 시작 각도
                        'rotationAngle':18,
                        // Definition of all the segments.
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
                        theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                        theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                        theWheel.draw();

                        wheelSpinning = false;
                    }

                    // Create new image object in memory.
                    let loadedImg = new Image();

                    // Create callback to execute once the image has finished loading.
                    loadedImg.onload = function()
                    {
                        theWheel.wheelImage = loadedImg;    // Make wheelImage equal the loaded image object.
                        theWheel.draw();                    // Also call draw function to render the wheel.
                    }

                    // Set the image source, once complete this will trigger the onLoad callback (above).
                    loadedImg.src = "./img/wheel/wheel.png";

                    // Called when the animation has finished.
                    function alertPrize(indicatedSegment)
                    {
                        // Do basic alert of the segment text.
                        // $('#ruletpop').modal('show');
                        console.log(indicatedSegment)

                        var index = parseInt( ((arr.length - 1) / 2) ) + indicatedSegment.index + 1;
                            index = index >= arr.length ? index % arr.length : index;


                        // alert("You have won " + indicatedSegment.text);
                        // $(".modal-penalty-popup-image-container img").attr("src", indicatedSegment.image);
                        // $(".modal-penalty-popup-penalty-title").text(indicatedSegment.title);
                        // $(".modal-penalty-popup-penalty-content").text(indicatedSegment.content);
                        // $(".modal-penalty-popup, .modal-bg").show();
                        $(".modal-penalty-popup-image-container img").attr("src", arr[index].image);
                        $(".modal-penalty-popup-penalty-title").text(arr[index].title);
                        $(".modal-penalty-popup-penalty-content").text(arr[index].content);
                        $(".modal-penalty-popup, .modal-bg").show();
                    }

                    $(document).on("click", "#startCircle, .modal-penalty-popup-btn-container button", function(){
                        $(".modal-penalty-popup, .modal-bg, .touch").hide();
                        resetWheel();
                        theWheel.startAnimation();
                    })

                }

            });
        });




    </script>