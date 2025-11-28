<?php
    $SQL_QUER = mysqli_query($db,"
        SELECT
        *
        FROM tb_member
        WHERE tb_member.MBR_NAME LIKE QUOTE('\"')
    ");
    if($SQL_QUER){
        if(mysqli_num_rows($SQL_QUER) > 0){
            echo mysqli_num_rows($SQL_QUER);
        } else { echo '1.2'; };
    } else { echo '1.1'; };
    
?>