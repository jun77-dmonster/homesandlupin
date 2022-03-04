<?php

    include "../common.php";

    session_start();

//    echo "main03_ok.php";

    global $g5;

    $link = $g5['connect_db'];

    switch($_GET['type']) {
        case "filter":

            $sql = "SELECT * FROM DM_T_CODE WHERE category_group_cd = '01'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row=sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "search":

            $where = stripslashes($_POST['sql']);

            if($where != "")
                $sql = "SELECT games.games_summaray, games.games_youtube, games.games_cd, games.games_theme, games.staff_call, games.best_icon, games.new_icon, games.games_nm, games.games_content, games.games_hash_tag, games.games_img_file, games.recommend_player_min_cnt, games.recommend_player_max_cnt, games.player_max_cnt, games.player_min_cnt, games.play_time, games.explain_time, games.search_filtering_play_cnt, games.games_level FROM DM_T_BRANCH_GAEMS AS branch JOIN DM_T_BOARD_GAMES AS games ON games.games_cd = branch.games_cd  WHERE 1=1 AND (games.games_delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."') AND (".$where.")";
            else
                $sql = "SELECT games.games_summaray, games.games_youtube, games.games_cd, games.games_theme, games.staff_call, games.best_icon, games.new_icon, games.games_nm, games.games_content, games.games_hash_tag, games.games_img_file, games.recommend_player_min_cnt, games.recommend_player_max_cnt, games.player_max_cnt, games.player_min_cnt, games.play_time, games.explain_time, games.search_filtering_play_cnt, games.games_level FROM DM_T_BRANCH_GAEMS AS branch JOIN DM_T_BOARD_GAMES AS games ON games.games_cd = branch.games_cd  WHERE 1=1 AND games.games_delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."'";

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

            $sql = "SELECT * FROM DM_T_GAMES_COUNT WHERE 1=1 AND branch_cd='".$_SESSION['branch_cd']."' AND games_cd='".$_POST['games_cd']."'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            if($row === [])
            {
                $sql = "INSERT INTO DM_T_GAMES_COUNT (games_cd, branch_cd, games_play_movie_cnt, count_reg_dt) VALUES ('".$_POST['games_cd']."', '".$_SESSION['branch_cd']."', 1, NOW())";
                sql_query($sql);
            }
            else
            {
                $sql = "UPDATE  DM_T_GAMES_COUNT set games_play_movie_cnt = games_play_movie_cnt+1 WHERE uid = '".$row['uid']."'";
                sql_query($sql);
            }

        break;
    }

?>