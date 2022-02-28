<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// DMONSTER 테이블 및 상수 모음
//------------------------------------------------------------------------------

$DM['SITE_ID'] = 'dmonster';

// DMONSTER 테이블명
$DM['table_prefix']			= 'DM_T_';

/*
DM_T_CODE						환경 코드
DM_T_FAQ						FAQ 자주하는 질문
DM_T_BOARD_GAMES				게임
DM_T_BEVERAGE					식음료
DM_T_BEVERAGE_OPTION			식음료 옵션
DM_T_BASE_GUIDE					이용안내
DM_T_VOICE_CUSTOMER				고객의 소리
DM_T_POPUP						팝업
DM_T_BRANCH						지점 관리
DM_T_BRANCH_ROOM				지점 룸 관리
DM_T_BRANCH_GAEMS				지점 게임 관리
DM_T_BRANCH_BEVERAGE			지점 식음료 관리
DM_T_MANAGER					운영자 관리
DM_T_MANAGER_AUTH				운영자 권한 설정
DM_T_SITE_CONFIG				사이트 환경 관리
DM_T_SEARCHWORD					검색어
DM_T_ORDER						지점 주문 관리
DM_T_NOTICE						지점 공지사항
DM_T_QUESTIONS					지점 문의사항
DM_T_GAMES_COUNT				게임별 카운트
DM_T_CART						장바구니
DM_T_BOARD_FILE					게시판 첨부파일
DM_T_QR_CODE					QR 코드
DM_T_GAMES_PENALTY				룰렛 벌칙
DM_T_GAMES_REQUEST_DESCRIPTION	직원 호출 
DM_T_GAMES_YOUTUBE_TIMESTAMP	게임 사용 설명 타임 스탬프

*/

$DM['CODE_TABLE']						=	$DM['table_prefix'] . 'CODE';
$DM['FAQ_TABLE']						=	$DM['table_prefix'] . 'FAQ';
$DM['BOARD_GAMES_TABLE']				=	$DM['table_prefix'] . 'BOARD_GAMES';
$DM['BEVERAGE_TABLE']					=	$DM['table_prefix'] . 'BEVERAGE';
$DM['BEVERAGE_OPTION_TABLE']			=	$DM['table_prefix'] . 'BEVERAGE_OPTION';
$DM['BASE_GUIDE_TABLE']					=	$DM['table_prefix'] . 'BASE_GUIDE';
$DM['VOICE_CUSTOMER_TABLE']				=	$DM['table_prefix'] . 'VOICE_CUSTOMER';
$DM['POPUP_TABLE']						=	$DM['table_prefix'] . 'POPUP';

$DM['BRANCH_TABLE']						=	$DM['table_prefix'] . 'BRANCH';
$DM['BRANCH_ROOM_TABLE']				=	$DM['table_prefix'] . 'BRANCH_ROOM';
$DM['BRANCH_GAEMS_TABLE']				=	$DM['table_prefix'] . 'BRANCH_GAEMS';
$DM['BRANCH_BEVERAGE_TABLE']			=	$DM['table_prefix'] . 'BRANCH_BEVERAGE';

$DM['MANAGER_TABLE']					=	$DM['table_prefix'] . 'MANAGER';
$DM['MANAGER_AUTH_TABLE']				=	$DM['table_prefix'] . 'MANAGER_AUTH';
$DM['SITE_CONFIG_TABLE']				=	$DM['table_prefix'] . 'SITE_CONFIG';
$DM['SEARCHWORD_TABLE']					=	$DM['table_prefix'] . 'SEARCHWORD';
$DM['ORDER_TABLE']						=	$DM['table_prefix'] . 'ORDER';
$DM['NOTICE_TABLE']						=	$DM['table_prefix'] . 'NOTICE';
$DM['QUESTIONS_TABLE']					=	$DM['table_prefix'] . 'QUESTIONS';
$DM['GAMES_COUNT_TABLE']				=	$DM['table_prefix'] . 'GAMES_COUNT';
$DM['GAMES_PENALTY_TABLE']				=	$DM['table_prefix'] . 'GAMES_PENALTY';
$DM['CART_TABLE']						=	$DM['table_prefix'] . 'CART';
$DM['BF_TABLE']							=	$DM['table_prefix'] . 'BOARD_FILE';
$DM['QR_CODE_TABLE']					=	$DM['table_prefix'] . 'QR_CODE';
$DM['GAMES_PENALTY_TABLE']				=	$DM['table_prefix'] . 'GAMES_PENALTY';
$DM['GAMES_REQUEST_DESCRIPTION_TABLE']	=	$DM['table_prefix'] . 'GAMES_REQUEST_DESCRIPTION';
$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']	=	$DM['table_prefix'] . 'GAMES_YOUTUBE_TIMESTAMP';

$DM['NOTICE_TABLE']						=	$DM['table_prefix'] . 'NOTICE';
$DM['QNA_TABLE']						=	$DM['table_prefix'] . 'QNA';

$DM['RECOMMEND_GAME_TABLE']				=	$DM['table_prefix'] . 'RECOMMEND_GAME';
$DM['B_TEMPLATE_TABLE']					=	$DM['table_prefix'] . 'BRANCH_TEMPLATE';		//게임 자동 세팅 코드
$DM['BD_TEMPLATE_TABLE']				=	$DM['table_prefix'] . 'BRANCH_TEMPLATE_DATA';	//자동 세팅 목록

$DM['GAME_REQUEST_TABLE']				=	$DM['table_prefix'] . 'GAME_REQUEST';			//지점 본사 추가 등록 요청
$DM['GAME_CART_TABLE']					=	$DM['table_prefix'] . 'GAME_CART';				//추가 등록 요청 게임 목록


$DM['QNA_CODE0']						=	"P1000";
$DM['QNA_CODE1']						=	"P1001";
$DM['QNA_CODE2']						=	"P1002";
$DM['QNA_CODE3']						=	"P1003";
$DM['QNA_CODE4']						=	"P1004";
$DM['QNA_CODE5']						=	"P1005";
$DM['QNA_CODE6']						=	"P1006";

include_once(G5_LIB_PATH.'/thumbnail.lib.php');