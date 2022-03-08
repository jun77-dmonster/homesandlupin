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
                    $sql = " games.games_nm LIKE '%" . $keyword . "%' or games.games_hash_tag LIKE '%" . $keyword . "%'";
                    $consonant = ['ㄱ', 'ㄴ', 'ㄷ', 'ㄹ', 'ㅁ', 'ㅂ', 'ㅅ', 'ㅇ', 'ㅈ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ'];
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㄱ|ㄲ)' OR ( games.games_nm >= '가' AND games.games_nm < '하' )) OR (games.games_hash_tag RLIKE '^(ㄱ|ㄲ)' OR ( games.games_hash_tag >= '가' AND games.games_hash_tag < '나' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㄴ)' OR ( games.games_nm >= '나' AND games.games_nm < '다' )) OR (games.games_hash_tag RLIKE '^(ㄴ)' OR ( games.games_hash_tag >= '나' AND games.games_hash_tag < '다' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㄷ|ㄸ)' OR ( games.games_nm >= '다' AND games.games_nm < '라' )) OR (games.games_hash_tag RLIKE '^(ㄷ|ㄸ)' OR ( games.games_hash_tag >= '다' AND games.games_hash_tag < '라' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㄹ)' OR ( games.games_nm >= '라' AND games.games_nm < '마' )) OR (games.games_hash_tag RLIKE '^(ㄹ)' OR ( games.games_hash_tag >= '라' AND games.games_hash_tag < '마' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅁ)' OR ( games.games_nm >= '마' AND games.games_nm < '바' )) OR (games.games_hash_tag RLIKE '^(ㅁ)' OR ( games.games_hash_tag >= '마' AND games.games_hash_tag < '바' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅂ)' OR ( games.games_nm >= '바' AND games.games_nm < '사' )) OR (games.games_hash_tag RLIKE '^(ㅂ)' OR ( games.games_hash_tag >= '바' AND games.games_hash_tag < '사' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅅ|ㅆ)' OR ( games.games_nm >= '사' AND games.games_nm < '아' )) OR (games.games_hash_tag RLIKE '^(ㅅ|ㅆ)' OR ( games.games_hash_tag >= '사' AND games.games_hash_tag < '아' )) ";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅇ)' OR ( games.games_nm >= '아' AND games.games_nm < '자' )) OR (games.games_hash_tag RLIKE '^(ㅇ)' OR ( games.games_hash_tag >= '아' AND games.games_hash_tag < '자' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅈ|ㅉ)' OR ( games.games_nm >= '자' AND games.games_nm < '차' )) OR (games.games_hash_tag RLIKE '^(ㅈ|ㅉ)' OR ( games.games_hash_tag >= '자' AND games.games_hash_tag < '차' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅊ)' OR ( games.games_nm >= '차' AND games.games_nm < '카' )) OR (games.games_hash_tag RLIKE '^(ㅊ)' OR ( games.games_hash_tag >= '차' AND games.games_hash_tag < '카' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅋ)' OR ( games.games_nm >= '카' AND games.games_nm < '타' )) OR (games.games_hash_tag RLIKE '^(ㅋ)' OR ( games.games_hash_tag >= '카' AND games.games_hash_tag < '타' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅌ)' OR ( games.games_nm >= '타' AND games.games_nm < '파' )) OR (games.games_hash_tag RLIKE '^(ㅌ)' OR ( games.games_hash_tag >= '타' AND games.games_hash_tag < '파' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅍ)' OR ( games.games_nm >= '파' AND games.games_nm < '하' )) OR (games.games_hash_tag RLIKE '^(ㅍ)' OR ( games.games_hash_tag >= '파' AND games.games_hash_tag < '하' ))";
                    $consonantSql []= " OR (games.games_nm RLIKE '^(ㅎ)' OR ( games.games_nm >= '하') OR (gamse.games_hash_tag RLIKE '^(ㅎ)' OR ( gamse.games_hash_tag >= '하'))";
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
                    WHERE 1=1 
                    AND branch_cd='".$_SESSION['branch_cd']."' 
                    AND room_cd='".$_SESSION['room_cd']."' 
                    AND search_word = '".$keyword."'
                    AND DATE_FORMAT(search_reg_dt, '%Y-%m-%d') = '".date("Y-m-d", time())."'";
                    $result = sql_query($searchCountSql);
                    $row = sql_fetch_array($result);

                    if($row === null)
                    {
                        $sql = "INSERT INTO DM_T_SEARCHWORD (branch_cd, room_cd, search_word, cnt, search_reg_dt) VALUES ('".$_SESSION['branch_cd']."', '".$_SESSION['room_cd']."', '".$keyword."', 1, NOW())";
                        sql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE  DM_T_SEARCHWORD set cnt = cnt+1 WHERE uid = '".$row['uid']."'";
                        sql_query($sql);
                    }
                }


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
                WHERE 1=1 AND (games.games_delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."') AND (".$where.")";
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
                games.games_level FROM DM_T_BRANCH_GAEMS AS branch JOIN DM_T_BOARD_GAMES AS games ON games.games_cd = branch.games_cd  WHERE 1=1 AND games.games_delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."'";

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