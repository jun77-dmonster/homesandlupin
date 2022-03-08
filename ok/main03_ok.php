<?php

    include "../common.php";

    session_start();

//    echo "main03_ok.php";

    global $g5;

    $link = $g5['connect_db'];

    switch($_GET['type']) {
        case "filter":

            $sql = "SELECT * FROM DM_T_CODE WHERE category_group_cd = '01' ORDER BY item_order ASC";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row=sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "search":
            if(!empty($_POST['keyword']))
            {
                if(preg_match('/^[ㄱ-ㅎ]+/', mb_substr($keyword, 0, 1)))
                {
                    $sql = "";
                    // $sql = "";
                    $consonant = ['ㄱ', 'ㄴ', 'ㄷ', 'ㄹ', 'ㅁ', 'ㅂ', 'ㅅ', 'ㅇ', 'ㅈ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ'];
                    $consonantSql []= " (games.games_nm between '가' and '깋') OR (games.games_hash_tag between '가' and '깋')";
                    $consonantSql []= " (games.games_nm between '나' and '닣') OR (games.games_hash_tag between '나' and '닣')";
                    $consonantSql []= " (games.games_nm between '다' and '딯') OR (games.games_hash_tag between '다' and '딯')";
                    $consonantSql []= " (games.games_nm between '라' and '맇') OR (games.games_hash_tag between '라' and '맇')";
                    $consonantSql []= " (games.games_nm between '마' and '밓') OR (games.games_hash_tag between '마' and '밓')";
                    $consonantSql []= " (games.games_nm between '바' and '빟') OR (games.games_hash_tag between '바' and '빟')";
                    $consonantSql []= " (games.games_nm between '사' and '싷') OR (games.games_hash_tag between '사' and '싷')";
                    $consonantSql []= " (games.games_nm between '아' and '잏') OR (games.games_hash_tag between '아' and '잏')";
                    $consonantSql []= " (games.games_nm between '자' and '짛') OR (games.games_hash_tag between '자' and '짛')";
                    $consonantSql []= " (games.games_nm between '차' and '칳') OR (games.games_hash_tag between '차' and '칳')";
                    $consonantSql []= " (games.games_nm between '카' and '킿') OR (games.games_hash_tag between '카' and '킿')";
                    $consonantSql []= " (games.games_nm between '타' and '팋') OR (games.games_hash_tag between '타' and '팋')";
                    $consonantSql []= " (games.games_nm between '파' and '핗') OR (games.games_hash_tag between '파' and '핗')";
                    $consonantSql []= " (games.games_nm between '하' and '힣') OR (games.games_hash_tag between '하' and '힣')";
                    $consonantArray = [];
                    foreach($consonant as $key => $value)
                    {
                        $consonantArray[$consonant[$key]] = $consonantSql[$key];
                    }

                    $sql = $sql . $consonantArray[$keyword];
                }
                else
                {
                    $sql = " games.games_nm LIKE '%" . $keyword . "%' or games.games_hash_tag LIKE '%" . $keyword . "%'";
                    // 지점별 검색 수
                    $searchCountSql = 
                    "SELECT
                        *
                    FROM
                        DM_T_SEARCHWORD
                    WHERE branch_cd='".$_SESSION['branch_cd']."' 
                    AND room_cd='".$_SESSION['room_cd']."' 
                    AND search_word = '".$keyword."'
                    AND DATE_FORMAT(search_reg_dt, '%Y-%m-%d') = '".date("Y-m-d", time())."'";
                    $result = sql_query($searchCountSql);
                    $row = sql_fetch_array($result);

                    if($row === null)
                    {
                        $countSql = "INSERT INTO DM_T_SEARCHWORD (branch_cd, room_cd, search_word, cnt, search_reg_dt) VALUES ('".$_SESSION['branch_cd']."', '".$_SESSION['room_cd']."', '".$keyword."', 1, NOW())";
                        sql_query($countSql);
                    }
                    else
                    {
                        $countSql = "UPDATE  DM_T_SEARCHWORD set cnt = cnt+1 WHERE uid = '".$row['uid']."'";
                        sql_query($countSql);
                    }
                }


            }

            if(!empty($_POST['option'])){
                $option = 'AND' . stripslashes($_POST['option']);
            }
            else
            {
                $option = '';
            }

            $where = stripslashes($sql);

            if($where != "")
                $sql = 
                "SELECT
                    games.games_summaray,
                    games.games_youtube,
                    games.games_cd,
                    games.games_theme,
                    games.staff_call,
                    games.best_icon,
                    games.new_icon,
                    games.games_nm,
                    games.games_content,
                    games.games_hash_tag,
                    games.games_img_file,
                    games.recommend_player_min_cnt,
                    games.recommend_player_max_cnt,
                    games.player_max_cnt,
                    games.player_min_cnt,
                    games.play_time,
                    games.explain_time,
                    games.search_filtering_play_cnt,
                    games.games_level
                FROM
                    DM_T_BRANCH_GAEMS AS branch
                JOIN
                    DM_T_BOARD_GAMES AS games ON games.games_cd = branch.games_cd
                WHERE games.games_delete_fl = 'F'
                AND branch.branch_cd ='".$_SESSION['branch_cd']."' (".$option.") AND (".$where.")";
            else
                $sql = "SELECT games.games_summaray,
                games.games_youtube,
                games.games_cd,
                games.games_theme,
                games.staff_call,
                games.best_icon,
                games.new_icon,
                games.games_nm,
                games.games_content,
                games.games_hash_tag,
                games.games_img_file,
                games.recommend_player_min_cnt,
                games.recommend_player_max_cnt,
                games.player_max_cnt,
                games.player_min_cnt,
                games.play_time,
                games.explain_time,
                games.search_filtering_play_cnt,
                games.games_level
                FROM
                    DM_T_BRANCH_GAEMS AS branch
                JOIN
                    DM_T_BOARD_GAMES AS games
                ON
                    games.games_cd = branch.games_cd
                WHERE
                    games.games_delete_fl = 'F'
                AND
                    branch.branch_cd ='".$_SESSION['branch_cd']."' $option";

                    
            $result = sql_query($sql);
            

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "code":

            $sql = " select item_nm from DM_T_CODE where item_cd = TRIM('".$_POST['item_cd']."') ";
            $result = sql_query($sql);
            $row = sql_fetch($sql);

            echo $row['item_nm'];

        break;

        case "timestamp":
            $sql = 
            "SELECT
                *
            FROM
                DM_T_GAMES_YOUTUBE_TIMESTAMP
            WHERE
                display_fl='T' 
            AND
                delete_fl='F'
            AND
                games_cd='".$_POST['games_cd']."'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "staff":

            $sql = "INSERT INTO DM_T_GAMES_REQUEST_DESCRIPTION (branch_cd, room_cd, games_cd, request_reg_dt) VALUES ('".$_SESSION['branch_cd']."','".$_SESSION['room_cd']."','".$_POST['games_cd']."',NOW())";
            echo sql_query($sql);

        break;

        case "count":
            $sql = 
            "SELECT
                *
            FROM
                DM_T_GAMES_COUNT
            WHERE 1=1 
            AND branch_cd='".$_SESSION['branch_cd']."' 
            AND games_cd='".$_POST['games_cd']."' 
            AND room_cd='".$_SESSION['room_cd']."' 
            AND DATE_FORMAT(count_reg_dt, '%Y-%m-%d') = '".date("Y-m-d", time())."'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);


            if($_POST['type'] === 'play')
            {
                $column = 'games_cd, branch_cd, room_cd, games_play_movie_cnt, count_reg_dt';
                $update = 'games_play_movie_cnt = games_play_movie_cnt+1';
            }
            else
            {
                $column = 'games_cd, branch_cd, room_cd, games_summary_click_cnt, count_reg_dt';
                $update = 'games_summary_click_cnt = games_summary_click_cnt+1';
            }

            if($row === null)
            {
                $sql = "INSERT INTO DM_T_GAMES_COUNT (".$column.") VALUES ('".$_POST['games_cd']."', '".$_SESSION['branch_cd']."', '".$_SESSION['room_cd']."', 1, NOW())";
                sql_query($sql);
            }
            else
            {
                $sql = "UPDATE  DM_T_GAMES_COUNT set ".$update." WHERE uid = '".$row['uid']."'";
                sql_query($sql);
            }

        break;
    }

?>