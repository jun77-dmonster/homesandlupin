<?php
$menu['menu200'] = array (
    array('200000', '운영관리', G5_ROUTE_URL.'/management/index.php', 'management'),
    //array('200001', '운영메인페이지', G5_ROUTE_URL.'/management/index.php', 'management_list'),
    array('200100', '이용안내', G5_ROUTE_URL.'/management/base_guide_list.php', 'base_guide'),
    array('200200', 'FAQ', G5_ROUTE_URL.'/management/faq_list.php', 'faq_list'),
    array('200300', '고객의소리', G5_ROUTE_URL.'/management/voice_customer_list.php', 'voice_customer'),
    array('200400', '팝업관리', G5_ROUTE_URL.'/management/popup_list.php', 'mb_delete'),
	array('200002', 'line'),
    array('200500', '지점관리', G5_ROUTE_URL.'/management/branch/index.php', 'branch_index'),
    array('200510', '운영지점', G5_ROUTE_URL.'/management/branch/branch_list.php', 'branch_list'),
    array('200520', '탈퇴지점', G5_ROUTE_URL.'/management/branch/branch_withdrawal_list.php', 'branch_withdrawal_list'),
	array('200002', 'line'),
    //array('200600', '보드게임관리', '', 'game_index'),
    //array('200610', '게임코드관리', G5_ROUTE_URL.'/management/game/game_code_list.php', 'game_code'),
    array('200610', '보드게임목록', G5_ROUTE_URL.'/management/game/board_games_list.php', 'board_games'),
    array('200620', '벌칙룰렛', G5_ROUTE_URL.'/management/game/penalty_roulette_list.php', 'penalty_roulette'),
	array('200002', 'line'),
    //array('200700', '식음료관리', '', 'beverage_index'),
    //array('200710', '식음료코드관리', G5_ROUTE_URL.'/management/beverage/beverage_code_list.php', 'beverage_code'),
    array('200720', '음료목록', G5_ROUTE_URL.'/management/beverage/beverage_list.php', 'beverage_list'),
    array('200730', '푸드목록', G5_ROUTE_URL.'/management/beverage/food_list.php', 'food_list'),
    array('200740', '세트목록', G5_ROUTE_URL.'/management/beverage/setmenu_list.php', 'setmenu_list')
);