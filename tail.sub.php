<?php if($is_admin == 'super') { ?><!-- RUN TIME : <?php echo get_microtime() - $begin_time;?> --><?php } ?>
</body>
</html>
<?php
/*
$tmp_sql = " select count(*) as cnt from $g4[login_table] where lo_ip = '$_SERVER[REMOTE_ADDR]' ";
$tmp_row = sql_fetch($tmp_sql);
if ($tmp_row['cnt'])
{
	$tmp_sql = " update $g4[login_table] set mb_id = '$member[mb_id]', lo_datetime = '$g4[time_ymdhis]', lo_location = '$lo_location', lo_url = '$lo_url' where lo_ip = '$_SERVER[REMOTE_ADDR]' ";
	sql_query($tmp_sql, FALSE);
}
else
{
	$tmp_sql = " insert into $g4[login_table] ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '$_SERVER[REMOTE_ADDR]', '$member[mb_id]', '$g4[time_ymdhis]', '$lo_location',  '$lo_url' ) ";
	sql_query($tmp_sql, FALSE);

	// 시간이 지난 접속은 삭제한다
	sql_query(" delete from $g4[login_table] where lo_datetime < '".date("Y-m-d H:i:s", $g4[server_time] - (60 * $config[cf_login_minutes]))."' ");
}
*/

$sql = " replace into {$g4['login_table']} set lo_ip = '{$_SERVER['REMOTE_ADDR']}', mb_id = '{$member['mb_id']}', lo_datetime = '{$g4['time_ymdhis']}', lo_location = '$lo_location', lo_url = '$lo_url' ";
sql_query($sql);

// 시간이 지난 접속은 삭제한다
// 1분마다 삭제한다.
if($g4[server_time] % 60 == 0) {
    sql_query(" delete from {$g4['login_table']} where lo_datetime < '".date('Y-m-d H:i:s', $g4['server_time'] - (60 * $config['cf_login_minutes']))."' ");
}
?>