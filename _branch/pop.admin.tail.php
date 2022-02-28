<?php
if (!defined('_GNUBOARD_')) exit;

// 그누보드5.4.5.5 버전과 영카트5.4.5.5.1 버전이 통합됨에 따라 그누보드 버전만 표시
// $print_version = defined('G5_YOUNGCART_VER') ? 'YoungCart Version '.G5_YOUNGCART_VER : 'Version '.G5_GNUBOARD_VER;
$print_version = 'Version '.G5_GNUBOARD_VER;
?>
<script src="<?php echo G5_ADMIN_URL ?>/admin.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_ADMIN_URL ?>/jquery.bpopup-0.1.1.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.anchorScroll.js?ver=<?php echo G5_JS_VER; ?>"></script>

<?php
include_once(G5_PATH.'/tail.sub.php');