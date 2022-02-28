<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "theme":

            $sql = "SELECT * FROM DM_T_CODE WHERE group_cd = '01001'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "select":

            $where = stripslashes($_POST['sql']);

            $sql = "SELECT games.games_summaray, games.games_youtube, games.games_cd, games.games_theme, games.staff_call, games.best_icon, games.new_icon, games.games_nm, games.games_content, games.games_hash_tag, games.games_img_file, games.recommend_player_min_cnt, games.recommend_player_max_cnt, games.player_max_cnt, games.player_min_cnt, games.play_time, games.explain_time, games.search_filtering_play_cnt, games.games_level FROM DM_T_BRANCH_GAEMS AS branch JOIN DM_T_BOARD_GAMES AS games ON games.games_cd = branch.games_cd  WHERE 1=1 AND (games.games_delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."') AND (".$where.")";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
    }