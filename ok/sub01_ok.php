<?PHP

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "category":

            $sql = "SELECT * FROM DM_T_CODE WHERE category_group_cd = '03'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row=sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            print_r(json_encode($arr));

        break;
        case "faq":

            $sql = "SELECT * FROM DM_T_FAQ WHERE category_cd = ".$_POST['item_cd'];
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            print_r(json_encode(array($row)));

        break;
        case "top_text":

            $sql = "SELECT * FROM DM_T_SITE_CONFIG";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            print_r(json_encode(array($row)));

        break;
    }