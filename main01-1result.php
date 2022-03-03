<?php
include "top.php";
?>
<style>
    .col-14 {text-align: center;}

  
    html, body {
      margin: 0; height: 100%; overflow: hidden; 
    }

    #ladderComponent {
        margin-top: 32px;
        height: 550px;
    }

    .ladder_canvas{
        z-index: 999;
    }
    .ladder{
        position: relative;
        margin: 0 auto;
        padding-top: 30px;
        z-index: 0;
    }
    .node{
        width: 0px;
        height: 0px;
        background-color: #000;
    }
    .ladder table{
        position: absolute;
        top: 30px;
        z-index: -99;
        left: -1px;
    }
    .user-wrap{
        width: 80px;
        position: absolute;
        top : -52px;
        text-align: center;
    }
    .user-wrap input{
        width:100%;
        height: 20px;
        text-align: center;
        border-radius:3px;
        border: 1px solid #ddd;
    }
    .user-wrap button{
        margin: 5px 0 0 0;
        border:0;
        width: 20px;
        height: 20px;
        border-radius: 10px;
        text-align: center;
        line-height: 20px;
        font-weight: bolder;
        color: #fff;
        cursor: pointer;
        outline: 0;
    }
    .answer-wrap{
        width: 80px;
        position: absolute;
        bottom : -55px;
        text-align: center;
        border-radius: 16px;
        background-color: #587f96;
        width: 90px;
        height: 60px;
        line-height: 60px;
        font-weight: bold;
        font-size: 24px;
        font-family: AggroB;
        font-weight: bold;
    }
    .answer-wrap span:nth-child(2) {
        color: #fff;
    }
    .answer-wrap span:nth-child(3) {
        color: #8eabb5;
    }
    .answer-wrap input{
        width:100%;
        height: 20px;
        text-align: center;
        border-radius:3px;
        border: 1px solid #ddd;
    }
    .answer-wrap p{
        width: 100%;
        height: 20px;
        font-weight: bold;
        font-size: 0.8em;
        line-height: 20px;
    }

    .start-form{
        width:300px;
        height: 400px;
        background-image: url("bg.png") ;
        background-repeat: no-repeat;
        background-position: 50% 30%;
        margin: 0 auto;
        text-align: center;
        position: relative;
    }
    .landing-form{
        position: absolute;
        top:270px;
    }
    .landing-form input{
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    .landing-form label{
        display: block;
        width: 100%;
    }
    .landing-form .button{
        margin-top: 10px;
        width: 220px;
    }
    .dim{
        width: 100%;
        height: 100%;
        /*background-color: #fff;*/
        position: absolute;
        top: 0;
        left: 0;
    }


    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

</style>


<div class="modal-popup">
    <div class="modal-popup-btn-close">
        <div></div>
        <div></div>
    </div>

    <div class="modal-game-result-title">전체결과</div>

    <div class="modal-game-table-container">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="modal-game-re-btn-container">
        <button class="btn-re-game">다시하기</button>
    </div>

</div>
<div class="modal-bg"></div>

    <div class="main01-1-container">
        <div class="game-preview-container">
            <div id="ladderComponent">
                <div id="ladder" class="ladder">
                    <div class="dim"></div>
                    <canvas class="ladder_canvas" id="ladder_canvas"></canvas>
                </div>
            </div>

            <div class="game-btn-container">
                <button class="btn-result-view" disabled="true">전체결과보기</button>
            </div>

        </div>
        <div class="game-num-container">
            <div>인원수</div>
            <div>2인</div>
            <div>3인</div>
            <div>4인</div>
            <div>5인</div>
            <div>6인</div>
        </div>
    </div>

</body>
</html>
<style>
    .modal-header .close {
        margin:0px;
    }
    .modal-footer {
        justify-content: center;
    }
</style>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="sadari" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="img/전체결과text.png" style="display:block; margin: 0px auto;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="width:100%; float:left; padding:30px;">
            <div class="sadariresult">
                <img src="img/1.png" style="margin-right:30px;">
                <img src="img/foot.png">
            </div>
            <div class="sadariresult">
                <img src="img/2.png" style="margin-right:30px;">
                <img src="img/hat.png">
            </div>
            <div class="sadariresult">
                <img src="img/3.png" style="margin-right:30px;">
                <img src="img/lock.png">
            </div>
            <div class="sadariresult">
                <img src="img/4.png" style="margin-right:30px;">
                <img src="img/searchicon.png">
            </div>
            <div class="sadariresult">
                <img src="img/5.png" style="margin-right:30px;">
                <img src="img/smile.png">
            </div>
            <div class="sadariresult">
                <img src="img/6.png" style="margin-right:30px;">
                <img src="img/smoke.png">
            </div>
            
        </div>
      </div>
      <div class="modal-footer">
        <a href="main01-1.php"><img src="img/다시하기btn.png"></a>
      </div>
    </div>
  </div>
</div>

<script>
    $(function(){

        var userCount = 0;
        var userCountCheck = 0;
        var userArr = [];
        var resultArr = [];
        var colorArr = ['#a884d5', '#faff80', '#71eae8', '#ff8eba', '#9efa76', '#ffbb4b'];
        var userArr1 = [];


        $(".btn-result-view").click(function(){

            userCount = 0;

            $(".modal-popup, .modal-bg").show();

        });


        $(document).on("click", ".user-wrap img", function(event) {
            var index = $($(this).parent()).data("index");
            userArr1.push(index);
        })

        $(".btn-re-game").click(function(){
            location.reload();
            // ladderInitialize();
            $(".modal-popup, .modal-bg").toggle();
        });


        $(document).on("click", ".modal-popup-btn-close", function(event){
            $(".modal-popup, .modal-bg").toggle();
        });


        var count = 0;

        ladderInitialize();

        function result()//추가
        {
            // rgb(168, 132, 213);
            // rgb(250, 255, 128);
            // rgb(113, 234, 232);
            // rgb(255, 142, 186);
            // rgb(158, 250, 118);
            // rgb(255, 187, 75);

            // let array = []
            resultArr = [];
            for (let index = 0; index < $(".user-wrap").length; index++) {
                if ($('input[value=' + index + ']').attr('style'))
                {
                    switch ($('input[value=' + index + ']').attr('style').split('rgb')[1]) {
                        case "(168, 132, 213);":
                            resultArr[0] = index
                            break;
                        case "(250, 255, 128);":
                            resultArr[1] = index
                            break;
                        case "(113, 234, 232);":
                            resultArr[2] = index
                            break;
                        case "(255, 142, 186);":
                            resultArr[3] = index
                            break;
                        case "(158, 250, 118);":
                            resultArr[4] = index
                            break;
                        case "(255, 187, 75);":
                            resultArr[5] = index
                            break;
                    }
                }
            }
            console.log(resultArr);
        }

        function getParam(sname) {

            var params = location.search.substr(location.search.indexOf("?") + 1);

            var sval = "";

            params = params.split("&");

            for (var i = 0; i < params.length; i++) {

                temp = params[i].split("=");

                if ([temp[0]] == sname) { sval = temp[1]; }

            }

            return sval;
        }


        $(".game-num-container > div").eq(parseInt(getParam("num")) - 1).addClass("active");

        $(".game-num-container > div").click(function(event){
            event.preventDefault();

            window.location.href = 'main01-1result.php?num=' + $(this).text().split("인")[0];
        });

        function ladderInitialize() {
            var heightNode = 10;
            var widthNode =  0;

            var LADDER = {};
            var row =0;
            var ladder = $('#ladder');
            var ladder_canvas = $('#ladder_canvas');
            var GLOBAL_FOOT_PRINT= {};
            var GLOBAL_CHECK_FOOT_PRINT= {};
            var working = false;
            function init(){
                canvasDraw();
            }

            $('#button').on('click', function () {
                var member = $('input[name=member]').val();
                if (member < 2) {
                    return alert('최소 2명 이상 선택하세요.')
                }

                if (member > 7) {
                    return alert('너무 많아요.. ㅠㅠ')
                }
                $('#landing').css({
                    'opacity': 0
                });
                widthNode = member;
                setTimeout(function () {
                    $('#landing').remove();
                    init();
                }, 310)

            });

            widthNode = getParam("num");
            init();

            function canvasDraw() {
                ladder.css({
                    'width': (widthNode - 1) * 180 + 24,
                    'height': (heightNode - 1) * 50,
                    'background-color': '#FFFFFF'
                });
                ladder_canvas
                    .attr('width', (widthNode - 1) * 180 + 54)
                    .attr('height', (heightNode - 1) * 50);

                setDefaultFootPrint();
                reSetCheckFootPrint();
                setDefaultRowLine();
                setRandomNodeData();
                drawDefaultLine();
                drawNodeLine();
                userSetting();
                resultSetting();
            }

            var userName = "";
            $(document).on('click', 'img.ladder-start', function (e) {
                if (working) {
                    return false;
                }
                $('.dim').remove();
                working = true;
                reSetCheckFootPrint();
                var _this = $(e.target);
                _this.attr('disabled', true).css({
                    'color': '#03254c',
                })
                var node = _this.attr('data-node');
                var color = _this.attr('data-color');
                startLineDrawing(node, color);


                if(jQuery.inArray(node.substr(0, 1), userArr))
                    userArr.push(node.substr(0, 1));



                userName = $('input[data-node="' + node + '"]').val();
            })

            function startLineDrawing(node, color) {

                var node = node;
                var color = color;

                var x = node.split('-')[0] * 1;
                var y = node.split('-')[1] * 1;
                var nodeInfo = GLOBAL_FOOT_PRINT[node];

                GLOBAL_CHECK_FOOT_PRINT[node] = true;

                // if(jQuery.inArray(x, resultArr)) {
                //     resultArr[userArr[userArr.length - 1]].push(x);
                // }
                // resultArr.push({
                //     id: userArr[userArr.length - 1],
                // });
                // console.log(resultArr);

                var dir = 'r'
                if (y == heightNode) {
                    reSetCheckFootPrint();
                    var target = $('input[data-node="' + node + '"]');
                    target.css({
                        'background-color': color
                    })
                    $('#' + node + "-user").text(userName)
                    working = false;
                    count++;//추가
                    //추가
                    result();
                    if (count == $(".user-wrap").length) {
                        $(".btn-result-view").attr("disabled", false).css({ opacity: 1 });
                    }
                    // $(".answer-wrap").each(function(i, item){
                    //     $(item).css({
                    //         backgroundColor: colorArr[resultArr[i]],
                    //     });
                    // });
                    // console.log(resultArr);
                    $(".modal-game-table-container > div").remove();
                    $(".modal-game-table-container").append("<div></div><div></div><div></div><div></div><div></div><div></div>");
                    var unitArr = ['st', 'nd', 'rd', 'th', 'th', 'th'];
                    for(var i = 0; i < 6; i++) {
                        if(resultArr[i] || resultArr[i] === 0) {
                            $(".answer-wrap-" + resultArr[i]).css({
                                backgroundColor: colorArr[i],

                            });
                            $(".answer-wrap-" + resultArr[i]).find("span").css({
                                color: '#0D2449',
                            });
                            $(".modal-game-table-container > div").eq(resultArr[i]).append("<div><img src='img/ladder/i" + i + ".png' alt='user' title='user'><div class='user-num-container' style='background-color:" + colorArr[i] + "'><div><span style='color: #0D2449'>" + (resultArr[i] + 1) + "</span><span style='color: #0D2449'>" + unitArr[i] + "</span></div></div></div>");
                        }
                        // for(var k = 0; k < resultArr.length; k++) {
                        //     if(i == resultArr[k])
                        //         $(".modal-game-table-container > div").eq(k).append("<div><img src='img/ladder/i" + resultArr[k] + ".png' alt='user' title='user'><div class='user-num-container'><div><span>" + (k + 1) + "</span><span>" + unitArr[k] + "</span></div></div></div>");
                        // }
                    }




                    console.log(colorArr);
                    console.log("userArr", userArr1);
                    console.log("resultArr", resultArr);


                    return false;
                }
                if (nodeInfo["change"]) {
                    var leftNode = (x - 1) + "-" + y;
                    var rightNode = (x + 1) + "-" + y;
                    var downNode = x + "-" + (y + 1);
                    var leftNodeInfo = GLOBAL_FOOT_PRINT[leftNode];
                    var rightNodeInfo = GLOBAL_FOOT_PRINT[rightNode];


                    if (GLOBAL_FOOT_PRINT.hasOwnProperty(leftNode) && GLOBAL_FOOT_PRINT.hasOwnProperty(rightNode)) {
                        var leftNodeInfo = GLOBAL_FOOT_PRINT[leftNode];
                        var rightNodeInfo = GLOBAL_FOOT_PRINT[rightNode];
                        if ((leftNodeInfo["change"] && leftNodeInfo["draw"] && !!!GLOBAL_CHECK_FOOT_PRINT[leftNode]) && (rightNodeInfo["change"]) && leftNodeInfo["draw"] && !!!GLOBAL_CHECK_FOOT_PRINT[rightNode]) {
                            //Left우선

                            stokeLine(x, y, 'w', 'l', color, 6)
                            setTimeout(function () {
                                return startLineDrawing(leftNode, color)
                            }, 100);
                        } else if ((leftNodeInfo["change"] && !!!leftNodeInfo["draw"] && !!!GLOBAL_CHECK_FOOT_PRINT[leftNode]) && (rightNodeInfo["change"]) && !!!GLOBAL_CHECK_FOOT_PRINT[rightNode]) {

                            stokeLine(x, y, 'w', 'r', color, 6)

                            setTimeout(function () {
                                return startLineDrawing(rightNode, color)
                            }, 100);
                        } else if ((leftNodeInfo["change"] && leftNodeInfo["draw"] && !!!GLOBAL_CHECK_FOOT_PRINT[leftNode]) && (!!!rightNodeInfo["change"])) {
                            //Left우선

                            stokeLine(x, y, 'w', 'l', color, 6)
                            setTimeout(function () {
                                return startLineDrawing(leftNode, color)
                            }, 100);
                        } else if (!!!leftNodeInfo["change"] && (rightNodeInfo["change"]) && !!!GLOBAL_CHECK_FOOT_PRINT[rightNode]) {
                            //Right우선

                            stokeLine(x, y, 'w', 'r', color, 6)
                            setTimeout(function () {
                                return startLineDrawing(rightNode, color)
                            }, 100);
                        } else {

                            stokeLine(x, y, 'h', 'd', color, 6)
                            setTimeout(function () {
                                return startLineDrawing(downNode, color)
                            }, 100);
                        }
                    } else {

                        if (!!!GLOBAL_FOOT_PRINT.hasOwnProperty(leftNode) && GLOBAL_FOOT_PRINT.hasOwnProperty(rightNode)) {
                            /// 좌측라인

                            if ((rightNodeInfo["change"] && !!!rightNodeInfo["draw"]) && !!!GLOBAL_CHECK_FOOT_PRINT[rightNode]) {
                                //Right우선

                                stokeLine(x, y, 'w', 'r', color, 6)
                                setTimeout(function () {
                                    return startLineDrawing(rightNode, color)
                                }, 100);
                            } else {

                                stokeLine(x, y, 'h', 'd', color, 6)
                                setTimeout(function () {
                                    return startLineDrawing(downNode, color)
                                }, 100);
                            }

                        } else if (GLOBAL_FOOT_PRINT.hasOwnProperty(leftNode) && !!!GLOBAL_FOOT_PRINT.hasOwnProperty(rightNode)) {
                            /// 우측라인

                            if ((leftNodeInfo["change"] && leftNodeInfo["draw"]) && !!!GLOBAL_CHECK_FOOT_PRINT[leftNode]) {
                                //Right우선

                                stokeLine(x, y, 'w', 'l', color, 6)
                                setTimeout(function () {
                                    return startLineDrawing(leftNode, color)
                                }, 100);
                            } else {

                                stokeLine(x, y, 'h', 'd', color, 6)
                                setTimeout(function () {
                                    return startLineDrawing(downNode, color)
                                }, 100);
                            }
                        }
                    }


                } else {

                    var downNode = x + "-" + (y + 1);
                    stokeLine(x, y, 'h', 'd', color, 6)
                    setTimeout(function () {
                        return startLineDrawing(downNode, color)
                    }, 100);
                }

            }





            function userSetting() {
                var userList = LADDER[0];
                var html = '';
                var color_data = ['#A884D5', '#FAFF80', '#71EAE8', '#FF8EBA', '#9EFA76', '#FFBB4B']
                for (var i = 0; i < userList.length; i++) {
                    // var color = '#'+(function lol(m,s,c){return s[m.floor(m.random() * s.length)] + (c && lol(m,s,c-1));})(Math,'0123456789ABCDEF',4);

                    color = color_data[i]
                    var x = userList[i].split('-')[0] * 1;
                    var y = userList[i].split('-')[1] * 1;
                    var left = x * 180 - 40
                    switch (x) {
                        case 2:
                            left += 3
                            break;
                        case 3:
                            left += 3
                            break;
                        case 4:
                            left += 6
                            break;
                        case 5:
                            left += 9
                            break;

                        default:
                            break;
                    }

                    html += '<div class="user-wrap"  data-index=' + i + ' style="top:-40px;left:' + (left + 10) + 'px">';
                    html += '<img class="ladder-start" style="cursor:pointer" src="img/ladder/i' + x + '.png" data-color="' + color + '" data-node="' + userList[i] + '" width="100"/>'
                    html += '</div>'
                }
                ladder.append(html);
            }

            function resultSetting() {
                var resultList = LADDER[heightNode - 1];
                console.log(resultList)

                var unit = ["st", "nd", "rd", "th", "th", "th"];

                var html = '';
                for (var i = 0; i < resultList.length; i++) {

                    var x = resultList[i].split('-')[0] * 1;
                    var y = resultList[i].split('-')[1] * 1 + 1;
                    var node = x + "-" + y;
                    var left = x * 180 - 35
                    switch (x) {
                        case 2:
                            left += 3
                            break;
                        case 3:
                            left += 3
                            break;
                        case 4:
                            left += 6
                            break;
                        case 5:
                            left += 9
                            break;

                        default:
                            break;
                    }
                    html += '<div class="answer-wrap answer-wrap-'+ i +'"  style="bottom:-80px;left:' + left + 'px"><input type="hidden" data-node="' + node + '" value="'+i+'">';
                    // html += '<img src="img/ladder/t' + x + '.png" id="' + node + '-user-img" width="80"/>'
                    // html += '<p id="' + node + '-user"></p>'
                            html += "<span>" + (i + 1) + "</span>";
                            html += "<span>" + unit[i] + "</span>";
                    html += '</div>';
                    // console.log(x)
                }
                ladder.append(html);
            }

            function drawNodeLine() {

                for (var y = 0; y < heightNode; y++) {
                    for (var x = 0; x < widthNode; x++) {
                        var node = x + '-' + y;
                        var nodeInfo = GLOBAL_FOOT_PRINT[node];
                        if (nodeInfo["change"] && nodeInfo["draw"]) {
                            stokeLine(x, y, 'w', 'r', '#03254b', '15')
                        } else {

                        }

                    }
                }
            }


            function stokeLine(x, y, flag, dir, color, width) {
                var canvas = document.getElementById('ladder_canvas');
                var ctx = canvas.getContext('2d');
                var moveToStart = 0, moveToEnd = 0, lineToStart = 0, lineToEnd = 0;
                var eachWidth = 182;
                var eachHeight = 50;
                if (flag == "w") {
                    //가로줄


                    if (dir == "r") {
                        ctx.beginPath();
                        moveToStart = x * eachWidth + 6;
                        moveToEnd = y * eachHeight + 6;
                        lineToStart = (x + 1) * eachWidth + 6;
                        lineToEnd = y * eachHeight + 6;

                    } else {
                        // dir "l"
                        ctx.beginPath();
                        moveToStart = x * eachWidth + 6;
                        moveToEnd = y * eachHeight + 6;
                        lineToStart = (x - 1) * eachWidth + 6;
                        lineToEnd = y * eachHeight + 6;
                    }
                } else {
                    ctx.beginPath();
                    moveToStart = (x * eachWidth) + 6;
                    moveToEnd = y * eachHeight + 6;
                    lineToStart = (x * eachWidth) + 6;
                    lineToEnd = (y + 1) * eachHeight + 6;
                }



                ctx.moveTo(moveToStart, moveToEnd);
                ctx.lineTo(lineToStart, lineToEnd);
                ctx.strokeStyle = color;
                ctx.lineWidth = width;
                ctx.stroke();
                ctx.closePath();
            }

            function drawDefaultLine() {
                var html = '';
                html += '<table>'
                for (var y = 0; y < heightNode - 1; y++) {
                    html += '<tr>';
                    for (var x = 0; x < widthNode - 1; x++) {
                        html += '<td style="width:189px; height:50px; border-left:15px solid #03254b; border-right:15px solid #03254b;"></td>';
                    }
                    html += '</tr>';
                }
                html += '</table>'
                ladder.append(html);
            }

            function setRandomNodeData() {
                for (var y = 1; y < heightNode - 1; y++) {
                    for (var x = 0; x < widthNode; x++) {
                        var loopNode = x + "-" + y;
                        var rand = Math.floor(Math.random() * 2);
                        if (rand == 0) {
                            GLOBAL_FOOT_PRINT[loopNode] = {"change": false, "draw": false}
                        } else {
                            if (x == (widthNode - 1)) {
                                GLOBAL_FOOT_PRINT[loopNode] = {"change": false, "draw": false};
                            } else {
                                GLOBAL_FOOT_PRINT[loopNode] = {"change": true, "draw": true};
                                ;
                                x = x + 1;
                                loopNode = x + "-" + y;
                                GLOBAL_FOOT_PRINT[loopNode] = {"change": true, "draw": false};
                                ;
                            }
                        }
                    }
                }
            }

            function setDefaultFootPrint() {

                for (var r = 0; r < heightNode; r++) {
                    for (var column = 0; column < widthNode; column++) {
                        GLOBAL_FOOT_PRINT[column + "-" + r] = false;
                    }
                }
            }

            function reSetCheckFootPrint() {

                for (var r = 0; r < heightNode; r++) {
                    for (var column = 0; column < widthNode; column++) {
                        GLOBAL_CHECK_FOOT_PRINT[column + "-" + r] = false;
                    }
                }
            }

            function setDefaultRowLine() {

                for (var y = 0; y < heightNode; y++) {
                    var rowArr = [];
                    for (var x = 0; x < widthNode; x++) {
                        var node = x + "-" + row;
                        rowArr.push(node);
                        // 노드그리기
                        var left = x * 180;
                        var top = row * 50;
                        var node = $('<div></div>')
                            .attr('class', 'node')
                            .attr('id', node)
                            .attr('data-left', left)
                            .attr('data-top', top)
                            .css({
                                'position': 'absolute',
                                'left': left,
                                'top': top,
                                backgroundColor: '#03254b'
                            });
                        ladder.append(node);
                    }
                    LADDER[row] = rowArr;
                    row++;
                }
            }
        }

    });
</script>