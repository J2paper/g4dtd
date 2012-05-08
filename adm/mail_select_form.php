<?php
$sub_menu = "200300";
include_once("./_common.php");

if (!$config[cf_email_use])
    alert("환경설정에서 \'메일발송 사용\'에 체크하셔야 메일을 발송할 수 있습니다.");

auth_check($auth[$sub_menu], "r");

$sql = "select * from $g4[mail_table] where ma_id = '$ma_id' ";
$ma = sql_fetch($sql);
if (!$ma[ma_id])
    alert("보내실 내용을 선택하여 주십시오.");

// 전체회원수
$sql = "select COUNT(*) as cnt from $g4[member_table] ";
$row = sql_fetch($sql);
$tot_cnt = $row[cnt];

// 탈퇴대기회원수
$sql = "select COUNT(*) as cnt from $g4[member_table] where mb_leave_date <> '' ";
$row = sql_fetch($sql);
$finish_cnt = $row[cnt];

$last_option = explode("||", $ma[ma_last_option]);
for ($i=0; $i<count($last_option); $i++) {
    $option = explode("=", $last_option[$i]);
    // 동적변수
    $var = $option[0];
    $$var = $option[1];
}

if (!isset($mb_id1)) $mb_id1 = 1;
if (!isset($mb_level_from)) $mb_level_from = 1;
if (!isset($mb_level_to)) $mb_level_to = 10;
if (!isset($mb_mailling)) $mb_mailling = 1;
if (!isset($mb_sex)) $mb_sex = 1;
if (!isset($mb_area)) $mb_area = 1;

$g4[title] = "회원메일발송";
include_once("./admin.head.php");
?>

<table width='700'>
<tr>
    <td class='right'>전체회원수 : <?php echo number_format($tot_cnt)?> 명 , 탈퇴대기회원수 : <?php echo number_format($finish_cnt)?> 명 , <strong>정상회원수 : <?php echo number_format($tot_cnt - $finish_cnt)?> 명</strong></td>
</tr>
<tr>
    <td>
        <form id='frmsendmailselectform' method='post' action="./mail_select_list.php">
        <table cellpadding='0' cellspacing='0' class='table2'>
        <col class='col1' />
        <col class='col2' />
        <tr><td colspan='2' class='line1'></td></tr>
        <tr>
            <th>회원 ID</th>
            <td>
                <input type='hidden' name='ma_id' value='<? echo $ma_id ?>' />

                <input type='radio' name='mb_id1' value='1' onclick="mb_id1_click(1);" <?php echo $mb_id1?"checked='checked'":"";?> /> 전체
                <input type='radio' name='mb_id1' value='0' onclick="mb_id1_click(0);" <?php echo !$mb_id1?"checked='checked'":"";?> /> 구간
                <br />
                <input type='text' id='mb_id1_from' name='mb_id1_from' class='text' value="<?php echo $mb_id1_from?>" /> 에서
                <input type='text' id='mb_id1_to' name='mb_id1_to' class='text' value="<?php echo $mb_id1_to?>" /> 까지

                <script type="text/javascript">
                function mb_id1_click(num)
                {
                    if (num == 1) {
                        document.getElementById('mb_id1_from').disabled = true;
                        document.getElementById('mb_id1_from').style.backgroundColor = '#EEEEEE';
                        document.getElementById('mb_id1_to').disabled = true;
                        document.getElementById('mb_id1_to').style.backgroundColor = '#EEEEEE';
                    } else {
                        document.getElementById('mb_id1_from').disabled = false;
                        document.getElementById('mb_id1_from').style.backgroundColor = '#FFFFFF';
                        document.getElementById('mb_id1_to').disabled = false;
                        document.getElementById('mb_id1_to').style.backgroundColor = '#FFFFFF';
                    }
                }
                document.onLoad=mb_id1_click(<?php echo (int)$mb_id1?>);
                </script>
            </td>
        </tr>
        <tr>
            <th>생일</th>
            <td>
                <input type='text' name='mb_birth_from' size='4' maxlength='4' class='text' value="<?php echo $mb_birth_from?>" /> 부터
                <input type='text' name='mb_birth_to' size='4' maxlength='4' class='text' value="<?php echo $mb_birth_to?>" /> 까지 (예 : 5월5일 인 경우, 0505 와 같이 입력 , 둘다 입력해야함)</td>
        </tr>
        <tr>
            <th>E-mail에</th>
            <td><input type='text' name='mb_email' class='text' value="<?php echo $mb_email?>" /> 단어 포함 (예 : @sir.co.kr)</td>
        </tr>
        <tr>
            <th>성별</th>
            <td>
                <select id='mb_sex' name='mb_sex'>
                    <option value=''>전체</option>
                    <option value='F'>여자</option>
                    <option value='M'>남자</option>
                </select>
                <script type="text/javascript"> document.getElementById('mb_sex').value = "<?php echo $mb_sex?>"; </script>
            </td>
        </tr>
        <tr>
            <th>지역</th>
            <td>
                <select id='mb_area' name='mb_area'>
                    <option value=''>전체</option>
                    <option value='서울'>서울</option>
                    <option value='부산'>부산</option>
                    <option value='대구'>대구</option>
                    <option value='인천'>인천</option>
                    <option value='광주'>광주</option>
                    <option value='대전'>대전</option>
                    <option value='울산'>울산</option>
                    <option value='강원'>강원</option>
                    <option value='경기'>경기</option>
                    <option value='경남'>경남</option>
                    <option value='경북'>경북</option>
                    <option value='전남'>전남</option>
                    <option value='전북'>전북</option>
                    <option value='제주'>제주</option>
                    <option value='충남'>충남</option>
                    <option value='충북'>충북</option>
                </select>
                <script type="text/javascript"> document.getElementById('mb_area').value = "<?php echo $mb_area?>"; </script>
            </td>
        </tr>
        <tr>
            <th>메일링</th>
            <td>
                <select id='mb_mailling' name='mb_mailling'>
                    <option value='1'>수신동의한 회원만</option>
                    <option value=''>전체</option>
                </select>
                <script type="text/javascript"> document.getElementById('mb_mailling').value = "<?php echo $mb_mailling?>"; </script>
            </td>
        </tr>
        <tr>
            <th>권한</th>
            <td>
                <select id='mb_level_from' name='mb_level_from'>
                <?php for ($i=1; $i<=10; $i++) { ?>
                    <option value='<? echo $i ?>'><? echo $i ?></option>
                <?php } ?>
                </select> 에서
                <select id='mb_level_to' name='mb_level_to'>
                <?php for ($i=1; $i<=10; $i++) { ?>
                    <option value='<? echo $i ?>'><? echo $i ?></option>
                <?php } ?>
                </select> 까지
                <script type="text/javascript"> document.getElementById('mb_level_from').value = "<?php echo $mb_level_from?>"; </script>
                <script type="text/javascript"> document.getElementById('mb_level_to').value = "<?php echo $mb_level_to?>"; </script>
            </td>
        </tr>
        <tr>
            <th>게시판그룹회원</th>
            <td>
                <select id='gr_id' name='gr_id'>
                <option value=''>전체</option>
                <?php
                $sql = " select gr_id, gr_subject from $g4[group_table] order by gr_subject ";
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++) {
                    echo "<option value='$row[gr_id]'>$row[gr_subject]</option>";
                }
                ?>
                </select>
                <script type="text/javascript"> document.getElementById('gr_id').value = "<?php echo $gr_id?>"; </script>
            </td>
        </tr>
        <tr><td colspan='2' class='line2'></td></tr>
        </table>

        <p class='center'>
            <input type='submit' class='btn1' value='  확  인  ' />
            <input type='button' class='btn1' value='  목  록  ' onclick="document.location.href='./mail_list.php';" />
        </p>
        </form>
    </td>
</tr></table>


<?php
include_once("./admin.tail.php");
?>
