<?php
    include_once('../setting.php');
    if(isset($_GET["email"])){
        $RSLT = [];
        $email = form_input($_GET["email"]);
        $SQL_ACC = mysqli_query($db, '
            SELECT
                tb_racc.ACC_LOGIN,
                MD5(MD5(tb_racc.ACC_MBR)) AS ACC_MBR,
                tb_racc.ACC_F_APP_PRIBADI_NAMA,
                tb_racc.ACC_F_APP_BK_1_NAMA,
                tb_racc.ACC_F_APP_BK_1_CBNG,
                tb_racc.ACC_F_APP_BK_1_ACC,
                tb_racc.ACC_F_APP_BK_1_TLP,
                tb_racc.ACC_F_APP_BK_1_JENIS,
                tb_racc.ACC_F_APP_BK_2_NAMA,
                tb_racc.ACC_F_APP_BK_2_CBNG,
                tb_racc.ACC_F_APP_BK_2_ACC,
                tb_racc.ACC_F_APP_BK_2_TLP,
                tb_racc.ACC_F_APP_BK_2_JENIS,
                tb_bankadm.BKADM_HOLDER
            FROM tb_racc
            JOIN tb_bankadm
            JOIN MT4_USERS
            ON(MT4_USERS.LOGIN = tb_racc.ACC_LOGIN)
            WHERE tb_racc.ACC_MBR = (SELECT tb_member.MBR_ID FROM tb_member WHERE tb_member.MBR_EMAIL = "'.$email.'")
            AND tb_racc.ACC_DERE = 1
            AND tb_racc.ACC_WPCHECK = 6
            AND LENGTH(tb_racc.ACC_LOGIN) >= 5
            GROUP BY tb_racc.ACC_LOGIN
        ');
        if($SQL_ACC && mysqli_num_rows($SQL_ACC) > 0){
            while($RESLUT_ACC = mysqli_fetch_assoc($SQL_ACC)){
                $RSLT[] = [
                    "login"         => $RESLUT_ACC["ACC_LOGIN"],
                    "mr_ux"         => $RESLUT_ACC["ACC_MBR"],
                    "pers_name"     => $RESLUT_ACC["ACC_F_APP_PRIBADI_NAMA"],
                    "bk_name_1"     => $RESLUT_ACC["ACC_F_APP_BK_1_NAMA"],
                    "bk_brnch_1"    => $RESLUT_ACC["ACC_F_APP_BK_1_CBNG"],
                    "bk_acc_1"      => $RESLUT_ACC["ACC_F_APP_BK_1_ACC"],
                    "bk_tlp_1"      => $RESLUT_ACC["ACC_F_APP_BK_1_TLP"],
                    "bk_type_1"     => $RESLUT_ACC["ACC_F_APP_BK_1_JENIS"],
                    "bk_name_2"     => $RESLUT_ACC["ACC_F_APP_BK_2_NAMA"],
                    "bk_brnch_2"    => $RESLUT_ACC["ACC_F_APP_BK_2_CBNG"],
                    "bk_acc_2"      => $RESLUT_ACC["ACC_F_APP_BK_2_ACC"],
                    "bk_tlp_2"      => $RESLUT_ACC["ACC_F_APP_BK_2_TLP"],
                    "bk_type_2"     => $RESLUT_ACC["ACC_F_APP_BK_2_JENIS"],
                    "bk_comp"       => $RESLUT_ACC["BKADM_HOLDER"]
                ];
            }
        }
        echo json_encode($RSLT);
    }
?>