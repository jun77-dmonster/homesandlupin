<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');


$branch_cd		=	$branch['branch_cd'];
$qna_gubun		=	isset($_POST['qna_gubun']) ? trim($_POST['qna_gubun']) : '';
$qna_category	=	isset($_POST['qna_category']) ? trim($_POST['qna_category']) : '';
$goods_cd		=	isset($_POST['goods_cd']) ? trim($_POST['goods_cd']) : '';

if (isset($_POST['qna_subject'])) {
    $wr_subject = substr(trim($_POST['qna_subject']),0,255);
    $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
}

if (isset($_POST['qna_content'])) {
    $wr_content = substr(trim($_POST['qna_content']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

// 090710
if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

if (substr_count($wr_subject, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

if($w==""){

	//등록
	$sql = " insert into {$DM['QNA_TABLE']} 
				set branch_cd		=	'{$branch_cd}',
					qna_gubun		=	'{$qna_gubun}',
					qna_category	=	'{$qna_category}',
					qna_status		=	'Q',
					goods_cd		=	'{$goods_cd}',
					qna_subject		=	'{$wr_subject}',
					qna_content		=	'{$wr_content}',
					wr_id			=	'{$member['mb_id']}',
					link_url		=	'{$link_url}',
					reg_ip			=	'{$_SERVER['REMOTE_ADDR']}',
					reg_dt			=	'".G5_TIME_YMDHIS."'";

	echo $sql;

	sql_query($sql);

	$uid = sql_insert_id();

}else if($w=="u"){

	$sql = " update {$DM['QNA_TABLE']} 
				set qna_gubun		=	'{$qna_gubun}',
					qna_category	=	'{$qna_category}',
					goods_cd		=	'{$goods_cd}',
					qna_subject		=	'{$wr_subject}',
					qna_content		=	'{$wr_content}',
					link_url		=	'{$link_url}',
					mod_ip			=	'{$_SERVER['REMOTE_ADDR']}',
					mod_dt			=	'".G5_TIME_YMDHIS."'
				where uid = '{$uid}'";

	echo $sql;

	sql_query($sql);

}else if($w=="a"){

	$sql = " update {$DM['QNA_TABLE']} 
				set qna_status			=	'A',
					answer_title		=	'{$answer_title}',
					answer_content		=	'{$answer_content}',
					answer_wr_id		=	'{$member['mb_id']}'
				where uid = '{$uid}'";

	sql_query($sql);

}

// 파일개수 체크
$file_count   = 0;
$upload_count = (isset($_FILES['bf_file']['name']) && is_array($_FILES['bf_file']['name'])) ? count($_FILES['bf_file']['name']) : 0;

for ($i=0; $i<$upload_count; $i++) {
    if($_FILES['bf_file']['name'][$i] && is_uploaded_file($_FILES['bf_file']['tmp_name'][$i]))
        $file_count++;
}

/*
if($w == 'u') {
    $file = get_file2($bo_table, $uid);
    if($file_count && (int)$file['count'] > $board['bo_upload_count'])
        alert('기존 파일을 삭제하신 후 첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
} else {
    if($file_count > $board['bo_upload_count'])
        alert('첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
}
*/

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();

if(isset($_FILES['bf_file']['name']) && is_array($_FILES['bf_file']['name'])) {
    for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
        $upload[$i]['file']     = '';
        $upload[$i]['source']   = '';
        $upload[$i]['filesize'] = 0;
        $upload[$i]['image']    = array();
        $upload[$i]['image'][0] = 0;
        $upload[$i]['image'][1] = 0;
        $upload[$i]['image'][2] = 0;
        $upload[$i]['fileurl'] = '';
        $upload[$i]['thumburl'] = '';
        $upload[$i]['storage'] = '';

        // 삭제에 체크가 되어있다면 파일을 삭제합니다.
        if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
            $upload[$i]['del_check'] = true;

            $row = sql_fetch(" select * from {$DM['BF_TABLE']} where bd_id = '{$bo_table}' and uid = '{$uid}' and bf_no = '{$i}' ");

            $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
            if( file_exists($delete_file) ){
                @unlink($delete_file);
            }
            // 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }
        }
        else
            $upload[$i]['del_check'] = false;

        $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
        $filesize  = $_FILES['bf_file']['size'][$i];
        $filename  = $_FILES['bf_file']['name'][$i];
        $filename  = get_safe_filename($filename);

        // 서버에 설정된 값보다 큰파일을 업로드 한다면
        if ($filename) {
            if ($_FILES['bf_file']['error'][$i] == 1) {
                $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
                continue;
            }
            else if ($_FILES['bf_file']['error'][$i] != 0) {
                $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
                continue;
            }
        }

        if (is_uploaded_file($tmp_file)) {
            // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
            if (!$is_admin && $filesize > $board['bo_upload_size']) {
                $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
                continue;
            }

            //=================================================================\
            // 090714
            // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
            // 에러메세지는 출력하지 않는다.
            //-----------------------------------------------------------------
            $timg = @getimagesize($tmp_file);
            // image type
            if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
                 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
                if ($timg['2'] < 1 || $timg['2'] > 18)
                    continue;
            }
            //=================================================================

            $upload[$i]['image'] = $timg;

            // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
            if ($w == 'u') {
                // 존재하는 파일이 있다면 삭제합니다.
                $row = sql_fetch(" select * from {$DM['BF_TABLE']} where bd_id = '{$bo_table}' and uid = '{$uid}' and bf_no = '{$i}' ");
                
                if(isset($row['bf_file']) && $row['bf_file']){
                    $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
                    if( file_exists($delete_file) ){
                        @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
                    }
                    // 이미지파일이면 썸네일삭제
                    if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                        delete_board_thumbnail($bo_table, $row['bf_file']);
                    }
                }
            }

            // 프로그램 원래 파일명
            $upload[$i]['source'] = $filename;
            $upload[$i]['filesize'] = $filesize;

            // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
            $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc|phar)/i", "$0-x", $filename);

            shuffle($chars_array);
            $shuffle = implode('', $chars_array);

            // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
            $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

            $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

			echo $dest_file;			

            // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
            $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

            // 올라간 파일의 퍼미션을 변경합니다.
            chmod($dest_file, G5_FILE_PERMISSION);

            $dest_file = run_replace('write_update_upload_file', $dest_file, $board, $wr_id, $w);
            $upload[$i] = run_replace('write_update_upload_array', $upload[$i], $dest_file, $board, $wr_id, $w);
        }
    }   // end for
}   // end if

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    $upload[$i]['source'] = sql_real_escape_string($upload[$i]['source']);
    $bf_content[$i] = isset($bf_content[$i]) ? sql_real_escape_string($bf_content[$i]) : '';
    $bf_width = isset($upload[$i]['image'][0]) ? (int) $upload[$i]['image'][0] : 0;
    $bf_height = isset($upload[$i]['image'][1]) ? (int) $upload[$i]['image'][1] : 0;
    $bf_type = isset($upload[$i]['image'][2]) ? (int) $upload[$i]['image'][2] : 0;

    $row = sql_fetch(" select count(*) as cnt from {$DM['BF_TABLE']} where bd_id = '{$bo_table}' and uid = '{$uid}' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$DM['BF_TABLE']}
                        set  bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_file_url = '{$upload[$i]['fileurl']}',
                             bf_thumburl = '{$upload[$i]['thumburl']}',
                             bf_storage = '{$upload[$i]['storage']}',
                             bf_filesize = '".(int)$upload[$i]['filesize']."',
                             bf_width = '".$bf_width."',
                             bf_height = '".$bf_height."',
                             bf_type = '".$bf_type."',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bd_id = '{$bo_table}'
                                and uid = '{$uid}'
                                and bf_no = '{$i}' ";
			echo $sql;
			
            sql_query($sql);
        }
        else
        {
            $sql = " update {$DM['BF_TABLE']}
                        set bf_content = '{$bf_content[$i]}'
                        where bd_id = '{$bo_table}'
                                  and uid = '{$uid}'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$DM['BF_TABLE']}
                    set  bd_id = '{$bo_table}',
                         uid = '{$uid}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_file_url = '{$upload[$i]['fileurl']}',
                         bf_thumburl = '{$upload[$i]['thumburl']}',
                         bf_storage = '{$upload[$i]['storage']}',
                         bf_download = 0,
                         bf_filesize = '".(int)$upload[$i]['filesize']."',
                         bf_width = '".$bf_width."',
                         bf_height = '".$bf_height."',
                         bf_type = '".$bf_type."',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";

        sql_query($sql);

        run_event('write_update_file_insert', $bo_table, $uid, $upload[$i], $w);
    }
}

// 파일의 개수를 게시물에 업데이트 한다.
$row = sql_fetch(" select count(*) as cnt from {$DM['BF_TABLE']} where bd_id = '{$bo_table}' and uid = '{$uid}' ");

goto_url("./questions_write.php?w=u&uid=".$uid);
