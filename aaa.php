<?php

    
$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
if(isset($_FILES["s5_6_doc1"]) && $_FILES["s5_6_doc1"]["error"] == 0){
                        
    $s5_6_doc1_name = $_FILES["s5_6_doc1"]["name"];
    $s5_6_doc1_type = $_FILES["s5_6_doc1"]["type"];
    $s5_6_doc1_size = $_FILES["s5_6_doc1"]["size"];
    
    $s5_6_doc1_ext = pathinfo($s5_6_doc1_name, PATHINFO_EXTENSION);
    
    if(array_key_exists($s5_6_doc1_ext, $allowed)){
        if(in_array($s5_6_doc1_type, $allowed)){
            if($s5_6_doc1_size < 200000) {
                $s5_6_doc1_new = 'doc1__'.round(microtime(true)).'.'.$s5_6_doc1_ext;
                if(move_uploaded_file($_FILES["s5_6_doc1"]["tmp_name"], "upload/" . $s5_6_doc1_new)){
                    echo $_FILES["s5_6_doc1"]["size"];
                } else { echo 'failed0'; }
            } else { echo 'failed1 '.$s5_6_doc1_size; }
        } else { echo 'failed2'; }
    } else { echo 'failed3'; }
};
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="s5_6_doc1">
    <input type="submit" name="submit">
</form>