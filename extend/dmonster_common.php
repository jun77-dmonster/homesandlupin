<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// DMONSTER 함수 모음
//------------------------------------------------------------------------------

function get_game_info($games_cd){

	global $DM;

	$sql = " select * from {$DM['BOARD_GAMES_TABLE']} where games_cd = TRIM('$games_cd') ";

	return sql_fetch($sql);

}

function get_code($item_cd){

	global $DM;

	$sql = " select * from {$DM['CODE_TABLE']} where item_cd = TRIM('$item_cd') ";

	return sql_fetch($sql);

}

function get_code_name($item_cd){

	global $DM;

	$sql = " select item_nm from {$DM['CODE_TABLE']} where item_cd = TRIM('$item_cd') ";

	$return = sql_fetch($sql);

	return $return['item_nm'];

}

function exist_mem_id($reg_mb_id)
{
    global $DM;

    $reg_mb_id = trim($reg_mb_id);
    if ($reg_mb_id == "") return "";

    $sql = " select count(*) as cnt from `{$DM['MEMBER_TABLE']}` where mem_id = '$reg_mb_id' ";

    $row = sql_fetch($sql);
    if ($row['cnt'])
        return "이미 사용중인 회원아이디 입니다.";
    else
        return "";
}

function exist_manager_hp($reg_mb_hp, $reg_mb_id)
{
    global $DM;

    if (!trim($reg_mb_hp)) return "";

    $sql = "select count(*) as cnt from {$DM['MANAGER_TABLE']} where cell_phone = '$reg_mb_hp' and manager_id <> '$reg_mb_id' ";
    $row = sql_fetch($sql);

    if($row['cnt'])
        return " 이미 사용 중인 휴대폰번호입니다. ".$reg_mb_hp;
    else
        return "";
}

//지점 유니크
function get_branch_uniqid(){

	$temp = rand(0000,9999);

	$temp_ren = strlen($temp);

	if($temp_ren==4){
		$temp2 = "B".$temp;
	}

	if($temp_ren==3){
		$temp2 = "B0".$temp;
	}

	if($temp_ren==2){
		$temp2 = "B00".$temp;
	}

	if($temp_ren==1){
		$temp2 = "B000".$temp;
	}

	return $temp2;

}

//지점 회원 체크
function get_branch($branch_manager_id){

	global $DM;

	$sql = "select count(*) as cnt from {$DM['BRANCH_TABLE']} where branch_manager_id = '{$branch_manager_id}' ";

	$row = sql_fetch($sql);

    if($row['cnt'])
        return " 이미 등록된 아이디 입니다. ".$branch_manager_id;
    else
        return "";

}

function get_branch_name($branch_cd){

	global $DM;

	$sql = "select branch_nm from {$DM['BRANCH_TABLE']} where branch_cd = '{$branch_cd}' ";

	$row = sql_fetch($sql);

	return $row['branch_nm'];

    /*
	if($row['cnt'])
        return " 이미 등록된 아이디 입니다. ".$branch_manager_id;
    else
        return "";
		*/

}

//룸정보
function get_room_info($room_cd){

	global $DM;

	$sql = "select * from {$DM['BRANCH_ROOM_TABLE']} where room_cd='{$room_cd}'";

	$row  = sql_fetch($sql);

	return $row['room_no'];

}

//룸번호 유니크
function get_room_uniqid($brnach){

	$temp = rand(0000,9999);

	$temp_ren = strlen($temp);

	if($temp_ren==4){
		$temp2 = $brnach."ROOM".$temp;
	}

	if($temp_ren==3){
		$temp2 = $brnach."ROOM0".$temp;
	}

	if($temp_ren==2){
		$temp2 = $brnach."ROOM00".$temp;
	}

	if($temp_ren==1){
		$temp2 = $brnach."ROOM000".$temp;
	}

	return $temp2;

}

//게임번호 유니크
function get_game_uniqid(){

	$temp = rand(0000,9999);

	$temp_ren = strlen($temp);

	if($temp_ren==4){
		$temp2 = "G".$temp;
	}

	if($temp_ren==3){
		$temp2 = "G0".$temp;
	}

	if($temp_ren==2){
		$temp2 = "G00".$temp;
	}

	if($temp_ren==1){
		$temp2 = "G000".$temp;
	}

	return $temp2;

}

//템플릿 유니크
function get_template_uniqid(){

	$temp = rand(0000,9999);

	$temp_ren = strlen($temp);

	if($temp_ren==4){
		$temp2 = "T".$temp;
	}

	if($temp_ren==3){
		$temp2 = "T0".$temp;
	}

	if($temp_ren==2){
		$temp2 = "T00".$temp;
	}

	if($temp_ren==1){
		$temp2 = "T000".$temp;
	}

	return $temp2;

}

// 기본운영 썸네일 삭제
function delete_basic_thumbnail($dir, $file)
{
    if(!$dir || !$file)
        return;

    $filename = preg_replace("/\.[^\.]+$/i", "", $file); // 확장자제거

    $files = glob($dir.'/thumb-'.$filename.'*');

    if(is_array($files)) {
        foreach($files as $thumb_file) {
            @unlink($thumb_file);
        }
    }
}

// 기본운영 업로드
function basic_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/basic/', '', $dir.'/'.$filename);

    return $file;
}

function _callback_it_img_upload($matches){
    return isset($matches[0]) ? base64_encode($matches[0]) : '';
}

// 파일을 업로드 함
function upload_file($srcfile, $destfile, $dir)
{
    if ($destfile == "") return false;
    // 업로드 한후 , 퍼미션을 변경함
    @move_uploaded_file($srcfile, $dir.'/'.$destfile);
    @chmod($dir.'/'.$destfile, G5_FILE_PERMISSION);
    return true;
}

function get_youtube_code($url) { 

    

    if (empty($url) || !$url) { 

        return;

    } 


    preg_match('@https?://(?:www\.)?youtube\.com/(?:watch\?|\?)[^>]*v[/=]([a-zA-Z0-9-_]+)@', $url, $matches);

	$code = $matches[1];

 
    if (!$code) { 

        preg_match('@https?://(?:www\.)?youtu\.be/([a-zA-Z0-9-_]+)@', $url, $matches);

        $code = $matches[1];

    }

 

    return $code;

} 

// 기본 썸네일 생성
function get_basic_thumbnail($img, $width, $height=0, $id='', $is_crop=false)
{
    $str = '';

    if ( $replace_tag = run_replace('get_basic_thumbnail_tag', $str, $img, $width, $height, $id, $is_crop) ){
        return $replace_tag;
    }

    $file = G5_DATA_PATH.'/basic/'.$img;

    if(is_file($file))
        $size = @getimagesize($file);

    if (! (isset($size) && is_array($size))) 
        return '';

    if($size[2] < 1 || $size[2] > 3)
        return '';

    $img_width = $size[0];
    $img_height = $size[1];
    $filename = basename($file);
    $filepath = dirname($file);

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'"';
        if($id)
            $str .= ' id="'.$id.'"';
        $str .= ' alt="">';
    }

    return $str;
}

// 기본 썸네일 생성
function get_youtube_thumbnail($img, $width, $height=0, $id='', $is_crop=false)
{
    $str = '';

    if ( $replace_tag = run_replace('get_yooutube_thumbnail_tag', $str, $img, $width, $height, $id, $is_crop) ){
        return $replace_tag;
    }

    $file = G5_DATA_PATH.'/youtubemark/'.$img;

    if(is_file($file))
        $size = @getimagesize($file);

    if (! (isset($size) && is_array($size))) 
        return '';

    if($size[2] < 1 || $size[2] > 3)
        return '';

    $img_width = $size[0];
    $img_height = $size[1];
    $filename = basename($file);
    $filepath = dirname($file);

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'"';
        if($id)
            $str .= ' id="'.$id.'"';
        $str .= ' alt="">';
    }

    return $str;
}

function get_penalty_thumbnail($img, $width, $height=0, $id='', $is_crop=false)
{
    $str = '';

    if ( $replace_tag = run_replace('get_penalty_thumbnail_tag', $str, $img, $width, $height, $id, $is_crop) ){
        return $replace_tag;
    }

    $file = G5_DATA_PATH.'/penalty/'.$img;

    if(is_file($file))
        $size = @getimagesize($file);

    if (! (isset($size) && is_array($size))) 
        return '';

    if($size[2] < 1 || $size[2] > 3)
        return '';

    $img_width = $size[0];
    $img_height = $size[1];
    $filename = basename($file);
    $filepath = dirname($file);

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'"';
        if($id)
            $str .= ' id="'.$id.'"';
        $str .= ' alt="">';
    }

    return $str;
}

// 이미지 썸네일 삭제
function delete_img_thumbnail($dir, $file)
{
    if(!$dir || !$file)
        return;

    $filename = preg_replace("/\.[^\.]+$/i", "", $file); // 확장자제거

    $files = glob($dir.'/thumb-'.$filename.'*');

    if(is_array($files)) {
        foreach($files as $thumb_file) {
            @unlink($thumb_file);
        }
    }
}

// 지점 업로드
function branch_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/branch/', '', $dir.'/'.$filename);

    return $file;
}

// 상품이미지 썸네일 생성
function get_branch_thumbnail($img, $width, $height=0, $id='', $is_crop=false)
{
    $str = '';

    if ( $replace_tag = run_replace('get_branch_thumbnail_tag', $str, $img, $width, $height, $id, $is_crop) ){
        return $replace_tag;
    }

    $file = G5_DATA_PATH.'/branch/'.$img;

    if(is_file($file))
        $size = @getimagesize($file);

    if (! (isset($size) && is_array($size))) 
        return '';

    if($size[2] < 1 || $size[2] > 3)
        return '';

    $img_width = $size[0];
    $img_height = $size[1];
    $filename = basename($file);
    $filepath = dirname($file);

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'"';
        if($id)
            $str .= ' id="'.$id.'"';
        $str .= ' alt="">';
    }

    return $str;
}

//지점관련
function get_branch_info($branch_cd){

	global $DM;

	$result = sql_fetch("select * from {$DM['BRANCH_TABLE']} where branch_cd='{$branch_cd}'");

	return $result;

}

//룸생성
function set_room_make($branch_cd, $room_pwd, $room_cnt, $room_no){

	global $DM;

	if($room_no=="1"){
		$room_no = $room_no;
	}else{
		$room_no = $room_no+1;
	}

	

	for($i=0;$i<$room_cnt;$i++){
	
		$makeCnt = 0;
		$room_cd  = get_room_uniqid($branch_cd);

		$sql = " insert into {$DM['BRANCH_ROOM_TABLE']} 
					set branch_cd		=	'{$branch_cd}',
						room_cd			=	'{$room_cd}',
						room_pwd		=	'".get_encrypt_string($room_pwd)."',
						room_pwd_enc	=	'{$room_pwd}',
						room_no			=	'{$room_no}',
						room_reg_dt		=	'".G5_TIME_YMDHIS."'";

		sql_query($sql);
		
		$makeCnt++;
		$room_no++;

	}

	return $makeCnt;

}

// option 리스트에 selected 추가
function conv_selected_option2($options, $value)
{
    if(!$options)
        return '';

    $options = str_replace('value="'.$value.'"', 'value="'.$value.'" selected', $options);

    return $options;
}

function dm_array_check($str){
	
	for($i=0;$i<count($str);$i++){

		$result .= $str[$i];
		
		if( $i<count($str)-1 ){
			$result .= "|";
		}

	}

	return $result;

}

//게임관련
function games_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/boardgames/', '', $dir.'/'.$filename);

    return $file;
}

//유튜브관련
function youtube_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/youtubemark/', '', $dir.'/'.$filename);

    return $file;
}

//유튜브관련
function penalty_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/penalty/', '', $dir.'/'.$filename);

    return $file;
}


//음료 유니크
function get_beverage_uniqid(){

	$temp = rand(0000,9999);

	$temp_ren = strlen($temp);

	if($temp_ren==4){
		$temp2 = "BEVERAGE".$temp;
	}

	if($temp_ren==3){
		$temp2 = "BEVERAGE0".$temp;
	}

	if($temp_ren==2){
		$temp2 = "BEVERAGE00".$temp;
	}

	if($temp_ren==1){
		$temp2 = "BEVERAGE000".$temp;
	}

	return $temp2;

}

//식음료관련
function beverage_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    //php파일도 getimagesize 에서 Image Type Flag 를 속일수 있다
    if (!preg_match('/\.(gif|jpe?g|png)$/i', $filename))
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback("/[가-힣]+/", '_callback_it_img_upload', $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/beverage/', '', $dir.'/'.$filename);

    return $file;
}

// 로그인 패스워드 체크
function route_password_check($mb, $pass, $hash)
{
    global $DM;

    $mb_id = isset($mb['manager_id']) ? $mb['manager_id'] : '';

    if(!$mb_id)
        return false;


    return route_check_password($pass, $hash);
}

// 비밀번호 비교
function route_check_password($pass, $hash)
{
    if(defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION === 'create_hash') {
        return validate_password($pass, $hash);
    }

    $password = get_encrypt_string($pass);

    return ($password === $hash);
}

// 로그인 패스워드 체크
function branch_password_check($mb, $pass, $hash)
{
    global $DM;

    $mb_id = isset($mb['branch_manager_id']) ? $mb['branch_manager_id'] : '';

    if(!$mb_id)
        return false;


    return branch_check_password($pass, $hash);
}

// 비밀번호 비교
function branch_check_password($pass, $hash)
{
    if(defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION === 'create_hash') {
        return validate_password($pass, $hash);
    }

    $password = get_encrypt_string($pass);

    return ($password === $hash);
}


// 게시글보기 썸네일 생성
function get_notice_thumbnail($contents, $thumb_width=0)
{
    global $config;

    if (!$thumb_width)
        $thumb_width = 600;

    // $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

    $extensions = array(1=>'gif', 2=>'jpg', 3=>'png', 18=>'webp');

    for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        $img_tag = isset($matches[0][$i]) ? $matches[0][$i] : '';

        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = isset($m[1]) ? $m[1] : '';
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = isset($m[1]) ? $m[1] : '';
        preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = isset($m[1]) ? $m[1] : '';
        preg_match("/height:\s*(\d+)px/", $style, $m);
        $height = isset($m[1]) ? $m[1] : '';
        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = isset($m[1]) ? get_text($m[1]) : '';

        // 이미지 path 구함
        $p = parse_url($src);
        if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
            $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
        else
            $data_path = $p['path'];

        $srcfile = G5_PATH.$data_path;

        if(is_file($srcfile)) {
            $size = @getimagesize($srcfile);
            if(empty($size))
                continue;

            $file_ext = $extensions[$size[2]];
            if (!$file_ext) continue;

            // jpg 이면 exif 체크
            if( $file_ext === 'jpg' && function_exists('exif_read_data')) {
                $degree = 0;
                $exif = @exif_read_data($srcfile);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }
            }

            // Animated GIF 체크
            $is_animated = false;
            if($file_ext === 'gif') {
                $is_animated = is_animated_gif($srcfile);

                if($replace_content = run_replace('thumbnail_is_animated_gif_content', '', $contents, $srcfile, $is_animated, $img_tag, $data_path, $size)){

                    $contents = $replace_content;
                    continue;
                }
            }

            // 원본 width가 thumb_width보다 작다면
            if($size[0] <= $thumb_width)
                continue;

            // 썸네일 높이
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            $filename = basename($srcfile);
            $filepath = dirname($srcfile);

            // 썸네일 생성
            if(!$is_animated)
                $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
            else
                $thumb_file = $filename;

            if(!$thumb_file)
                continue;

            if ($width) {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'"/>';
            } else {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'"/>';
            }
            
            // $img_tag에 editor 경로가 있으면 원본보기 링크 추가
            if(strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                $imgurl = str_replace(G5_URL, "", $src);
                $attr_href = run_replace('thumb_view_image_href', G5_BBS_URL.'/view_image.php?fn='.urlencode($imgurl), $filename, '', $width, $height, $alt);
                $thumb_tag = '<a href="'.$attr_href.'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
            }

            $contents = str_replace($img_tag, $thumb_tag, $contents);
        }
    }

    return run_replace('get_notice_thumbnail', $contents);
}

//qna 구분
$branch_gubun = ['지점 정보'=>'P1000','지점 이용안내'=>'P1001','지점 추천게임정보'=>'P1002','FAQ'=>'P1003','팝업'=>'P1004','게임'=>'P1005','식음료'=>'P1006'];


// cart id 설정
function set_dmcart_id()
{
	$tmp_cart_id = get_session('ss_cart_direct');
	if(!$tmp_cart_id) {
		$tmp_cart_id = get_uniqid();
		set_session('ss_cart_direct', $tmp_cart_id);
	}
}

function get_beverage_options($beverage_cd, $subject){
	
	global $DM;

	if(!$beverage_cd || !$subject)
        return '';

	$sql = " select * from {$DM['BEVERAGE_OPTION_TABLE']} where beverage_op_type = '0' and beverage_code = '$beverage_cd' and beverage_op_use_fl = 'T' order by beverage_op_no asc ";

    $result = sql_query($sql);

	$str = '';
    $subj = explode(',', $subject);
    $subj_count = count($subj);

	if($subj_count > 1) {
        
		$options = array();

		// 옵션항목 배열에 저장
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $opt_id = explode(chr(30), $row['beverage_op_id']);

            for($k=0; $k<$subj_count; $k++) {
                if(! (isset($options[$k]) && is_array($options[$k])))
                    $options[$k] = array();

                if(isset($opt_id[$k]) && $opt_id[$k] && !in_array($opt_id[$k], $options[$k]))
                    $options[$k][] = $opt_id[$k];
            }
        }

		// 옵션선택목록 만들기
        for($i=0; $i<$subj_count; $i++) {

			$opt = $options[$i];
            $opt_count = count($opt);
			$disabled = '';

			if($opt_count) {
                $seq = $i + 1;
                if($i > 0)
                    //$disabled = ' disabled="disabled"';


				$str .= '<div class="get_item_options">'.PHP_EOL;
				$str .= '<label for="it_option_'.$seq.'" class="label-title">'.$subj[$i].'</label>'.PHP_EOL;

                $select = '<select id="it_option_'.$seq.'" class="it_option"'.$disabled.'>'.PHP_EOL;

                $first_option_title = $is_first_option_title ? $subj[$i] : '선택';

                $select .= '<option value="">'.$first_option_title.'</option>'.PHP_EOL;
                for($k=0; $k<$opt_count; $k++) {
                    $opt_val = $opt[$k];
                    if(strlen($opt_val)) {
                        $select .= '<option value="'.$opt_val.'">'.$opt_val.'</option>'.PHP_EOL;
                    }
                }
                $select .= '</select>'.PHP_EOL;

                
				$str .= '<span>'.$select.'</span>'.PHP_EOL;
				$str .= '</div>'.PHP_EOL;
                
            }

		}


	}else{
	
		$select = '<select id="it_option_1" class="it_option">'.PHP_EOL;
        $select .= '<option value="">선택</option>'.PHP_EOL;
        for($i=0; $row=sql_fetch_array($result); $i++) {
            if($row['beverage_op_price'] >= 0)
                $price = '&nbsp;&nbsp;+ '.number_format($row['beverage_op_price']).'원';
            else
                $price = '&nbsp;&nbsp; '.number_format($row['beverage_op_price']).'원';

            $select .= '<option value="'.$row['beverage_op_id'].','.$row['beverage_op_price'].'">'.$row['beverage_op_id'].$price.'</option>'.PHP_EOL;
        }

		$str = '<span>'.$select.'</span>'.PHP_EOL;

	}

	return $str;
	

}

//지점 자동 세팅 (게임)
function set_game_insert($branch_cd, $games_template_uid){

	global $DM;
	
	sql_query("delete from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}'");
	
	$result = sql_query("select * from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$games_template_uid}'");

	for($i=0;$row=sql_fetch_array($result);$i++){
		
		sql_query(" insert into {$DM['BRANCH_GAEMS_TABLE']} set branch_cd='{$branch_cd}', games_cd='{$row['data_cd']}', branch_games_reg_dt='".G5_TIME_YMDHIS."'");
		
	}

	$r1 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}' ");

	sql_query("update {$DM['BRANCH_TABLE']} set branch_game_reg_cnt='{$r1['cnt']}' where branch_cd='{$branch_cd}' ");

}

//추천 지점 자동 세팅 (게임)
function set_rgame_insert($branch_cd, $rgames_template_uid){

	global $DM;
	
	sql_query("delete from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}'");
	
	$result = sql_query("select * from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$rgames_template_uid}'");

	for($i=0;$row=sql_fetch_array($result);$i++){
		
		sql_query(" insert into {$DM['BRANCH_GAEMS_TABLE']} set branch_cd='{$branch_cd}', games_cd='{$row['data_cd']}', branch_games_reg_dt='".G5_TIME_YMDHIS."'");
		
	}

	$r1 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}' ");

	sql_query("update {$DM['BRANCH_TABLE']} set branch_games_recommend_cnt='{$r1['cnt']}' where branch_cd='{$branch_cd}' ");

}

//지점 자동 세팅 (식음료)
function set_beverage_insert($branch_cd, $beverage_template_uid){

	global $DM;
	
	sql_query("delete from {$DM['BRANCH_BEVERAGE_TABLE']} where branch_cd='{$branch_cd}'");
	
	$result = sql_query("select * from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$beverage_template_uid}'");

	for($i=0;$row=sql_fetch_array($result);$i++){
		
		sql_query(" insert into {$DM['BRANCH_BEVERAGE_TABLE']} set branch_cd='{$branch_cd}', beverage_cd='{$row['data_cd']}', branch_beverage_reg_dt='".G5_TIME_YMDHIS."'");
		
	}

}

function set_game_cart_id($direct)
{
    global $DM, $branch;

    /*
	$tmp_cart_id = get_session('ss_cart_direct');
	if(!$tmp_cart_id) {
		$tmp_cart_id = get_uniqid();
		set_session('ss_cart_direct', $tmp_cart_id);
	}
	*/
	
	if ($direct) {
        $tmp_cart_id = get_session('ss_cart_direct');
        if(!$tmp_cart_id) {
            $tmp_cart_id = get_uniqid();
            set_session('ss_cart_direct', $tmp_cart_id);
        }
    } else {
            
		$tmp_cart_id = get_session('ss_cart_id');
		if(!$tmp_cart_id) {
			$tmp_cart_id = get_uniqid();
			set_session('ss_cart_id', $tmp_cart_id);
		}

        // 보관된 회원장바구니 자료 cart id 변경
        if($branch['branch_cd'] && $tmp_cart_id) {
            $sql = " update {$DM['GAME_CART_TABLE']}
                        set od_id = '$tmp_cart_id'
                        where branch_cd = '{$branch['branch_cd']}'
                          and ct_direct = '0'
                          and ct_status = '신청' ";
            sql_query($sql);
        }
    }

}

// 장바구니 건수 검사
function get_game_cart_count($cart_id)
{
    global $DM;

    $sql = " select count(ct_id) as cnt from {$DM['GAME_CART_TABLE']} where od_id = '$cart_id' ";
    $row = sql_fetch($sql);
    $cnt = (int)$row['cnt'];
    return $cnt;
}

// 장바구니 상품삭제
function cart_game_clean()
{
    global $DM, $default;

    // 장바구니 보관일
    $keep_term = 1; // 기본값 15일

    // 설정 시간이상 경과된 상품 삭제
    $statustime = G5_SERVER_TIME - (86400 * $keep_term);

    $sql = " delete from {$DM['GAME_CART_TABLE']}
                where ct_status = '신청'
                  and UNIX_TIMESTAMP(ct_time) < '$statustime' ";
    sql_query($sql);
}