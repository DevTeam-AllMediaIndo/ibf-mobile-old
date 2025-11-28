<?php
    if(isset($_POST['profile_submit'])){
        if(isset($_POST['nama'])){
            if(isset($_POST['phone'])){
                // if(isset($_POST['country'])){
                    if(isset($_POST['zip'])){
                        if(isset($_POST['address'])){
                            if(isset($_POST['s2_dateofbirth'])){
                                if(isset($_POST['tmpt_lahir'])){
                                    if(isset($_POST['type_identitas'])){
                                        if(isset($_POST['no_identitas'])){
                                            if(isset($_POST['city'])){
                                                $phone = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['phone']))));
                                                $zip = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['zip']))));
                                                $address = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['address']))));
                                                $s2_dateofbirth = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['s2_dateofbirth']))));
                                                $tmpt_lahir = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['tmpt_lahir']))));
                                                $type_identitas = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['type_identitas']))));
                                                $no_identitas = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['no_identitas']))));
                                                $city = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['city']))));
                                                $nama = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['nama']))));

                                                    mysqli_query($db, '
                                                        UPDATE tb_member SET
                                                        tb_member.MBR_PHONE = "'.$phone.'",
                                                        tb_member.MBR_NAME = "'.$nama.'",
                                                        tb_member.MBR_ZIP = '.$zip.',
                                                        tb_member.MBR_ADDRESS = "'.$address.'",
                                                        tb_member.MBR_TGLLAHIR = "'.$s2_dateofbirth.'",
                                                        tb_member.MBR_TMPTLAHIR = "'.$tmpt_lahir.'",
                                                        tb_member.MBR_TYPE_IDT = "'.$type_identitas.'",
                                                        tb_member.MBR_NO_IDT = "'.$no_identitas.'",
                                                        tb_member.MBR_CITY = "'.$city.'"
                                                        WHERE tb_member.MBR_ID = '.$user1['MBR_ID'].'
                                                ') or die("<script>alert('please try again or contact support3');location.href = '" . $login_page . "'</script>");
                                                die("<script>alert('Success update data');location.href = 'home.php?page=settings'</script>");

                                            }else{die("<script>alert('please try again or contact support9')location.href = '" . $login_page . "'</script>");};
                                        }else{die("<script>alert('please try again or contact support9')location.href = '" . $login_page . "'</script>");};
                                    }else{die("<script>alert('please try again or contact support8')location.href = '" . $login_page . "'</script>");};
                                }else{die("<script>alert('please try again or contact support7')location.href = '" . $login_page . "'</script>");};
                            }else{die("<script>alert('please try again or contact support6')location.href = '" . $login_page . "'</script>");};
                        }else{die("<script>alert('please try again or contact support4')location.href = '" . $login_page . "'</script>");};
                    }else{die("<script>alert('please try again or contact support3')location.href = '" . $login_page . "'</script>");};
                // }else{die("<script>alert('please try again or contact support1')location.href = '" . $login_page . "'</script>");};
            }else{die("<script>alert('please try again or contact support1')location.href = '" . $login_page . "'</script>");};
        }else{die("<script>alert('please try again or contact support1')location.href = '" . $login_page . "'</script>");};
    } 
?>
<div class="page-title page-title-small">
    <h2>Profile</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content mb-0">
        <form method="post">
            <h4>Profile Form</h4>
            <p>
                This form is allow you to change your personal data(except email).
            </p>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-user"></i>Name:</label>
                <input type="text" class="form-control" value="<?php echo $user1['MBR_NAME'] ?>" name="nama" required autocomplete="off">
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-at"></i>Email:</label>
                <input type="text" class="form-control" value="<?php echo msqrade($user1['MBR_EMAIL']) ?>" name="email" required autocomplete="off" readonly>
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-calendar"></i>Tanggal lahir:</label>
                <input type="date" class="form-control validate-text" max="<?php echo date('Y-m-d', strtotime('-21 years')) ?>" value="<?php echo $user1['MBR_TGLLAHIR'] ?>" name="s2_dateofbirth" autocomplete="off" required>
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-map-marker"></i>Tempat lahir:</label>
                <input type="text" class="form-control" value="<?php echo $user1['MBR_TMPTLAHIR'] ?>" name="tmpt_lahir"  required autocomplete="off">
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-address-card"></i>Type identitas:</label>
                <select class="form-control custom-select" id="idt_type" onchange="GetSelectedTextValue2(this)" required name="type_identitas">
                    <option value="">Jenis Identitas</option>
                    <option <?php if($user1['MBR_TYPE_IDT'] == 'KTP'){ echo 'selected'; } ?> value="KTP">KTP</option>
                    <option <?php if($user1['MBR_TYPE_IDT'] == 'Passport'){ echo 'selected'; } ?> value="Passport">Passport</option>
                </select>
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-id-card "></i>No.Identitas:</label>
                <input type="text" class="form-control" id="no_idt" maxlength="15" minlength="8" value="<?php echo msqrade($user1['MBR_NO_IDT']) ?>" placeholder="Masukkan nomor identitas" required name="no_identitas" autocomplete="off">
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-phone "></i>Phone number:</label>
                <input type="text" class="form-control" value="<?php if($user1['MBR_PHONE'] == ""){ echo '62';} else { echo msqrade($user1['MBR_PHONE']); }; ?>" name="phone" placeholder="Pastikan nomor anda memiliki nomor whatsapp" required autocomplete="off">
            </div>

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-id-card"></i>ZIP code:</label>
                <input type="number" class="form-control" min="10000" max="99999" value="<?php echo $user1['MBR_ZIP'] ?>" name="zip" required autocomplete="off">
            </div>


            <!-- <div class="col-12">
                <label for="form5" class="color-highlight"><i class="fa fa-globe"></i>Country:</label>
                <select class="form-control custom-select" id="form5" required name="country">
                    <option disabled selected value>Country</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Afghanistan'){ echo 'selected'; }; ?>>Afghanistan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Albania'){ echo 'selected'; }; ?>>Albania</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Algeria'){ echo 'selected'; }; ?>>Algeria</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'American Samoa'){ echo 'selected'; }; ?>>American Samoa</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Andorra'){ echo 'selected'; }; ?>>Andorra</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Angola'){ echo 'selected'; }; ?>>Angola</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Anguilla'){ echo 'selected'; }; ?>>Anguilla</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Antarctica'){ echo 'selected'; }; ?>>Antarctica</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Antigua and Barbuda'){ echo 'selected'; }; ?>>Antigua and Barbuda</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Argentina'){ echo 'selected'; }; ?>>Argentina</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Armenia'){ echo 'selected'; }; ?>>Armenia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Aruba'){ echo 'selected'; }; ?>>Aruba</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Australia'){ echo 'selected'; }; ?>>Australia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Austria'){ echo 'selected'; }; ?>>Austria</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Azerbaijan'){ echo 'selected'; }; ?>>Azerbaijan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bahamas'){ echo 'selected'; }; ?>>Bahamas</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bahrain'){ echo 'selected'; }; ?>>Bahrain</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bangladesh'){ echo 'selected'; }; ?>>Bangladesh</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Barbados'){ echo 'selected'; }; ?>>Barbados</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Belarus'){ echo 'selected'; }; ?>>Belarus</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Belgium'){ echo 'selected'; }; ?>>Belgium</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Belize'){ echo 'selected'; }; ?>>Belize</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Benin'){ echo 'selected'; }; ?>>Benin</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bermuda'){ echo 'selected'; }; ?>>Bermuda</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bhutan'){ echo 'selected'; }; ?>>Bhutan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bolivia'){ echo 'selected'; }; ?>>Bolivia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bosnia and Herzegovina'){ echo 'selected'; }; ?>>Bosnia and Herzegovina</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Botswana'){ echo 'selected'; }; ?>>Botswana</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bouvet Island'){ echo 'selected'; }; ?>>Bouvet Island</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Brazil'){ echo 'selected'; }; ?>>Brazil</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'British Indian Ocean Territory'){ echo 'selected'; }; ?>>British Indian Ocean Territory</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Brunei Darussalam'){ echo 'selected'; }; ?>>Brunei Darussalam</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Bulgaria'){ echo 'selected'; }; ?>>Bulgaria</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Burkina Faso'){ echo 'selected'; }; ?>>Burkina Faso</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Burundi'){ echo 'selected'; }; ?>>Burundi</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cambodia'){ echo 'selected'; }; ?>>Cambodia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cameroon'){ echo 'selected'; }; ?>>Cameroon</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Canada'){ echo 'selected'; }; ?>>Canada</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cape Verde'){ echo 'selected'; }; ?>>Cape Verde</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cayman Islands'){ echo 'selected'; }; ?>>Cayman Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Central African Republic'){ echo 'selected'; }; ?>>Central African Republic</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Chad'){ echo 'selected'; }; ?>>Chad</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Chile'){ echo 'selected'; }; ?>>Chile</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'China'){ echo 'selected'; }; ?>>China</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Christmas Island'){ echo 'selected'; }; ?>>Christmas Island</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cocos (Keeling) Islands'){ echo 'selected'; }; ?>>Cocos (Keeling) Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Colombia'){ echo 'selected'; }; ?>>Colombia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Comoros'){ echo 'selected'; }; ?>>Comoros</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Congo'){ echo 'selected'; }; ?>>Congo</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Congo, Democratic Republic of'){ echo 'selected'; }; ?>>Congo, Democratic Republic of</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cook Islands'){ echo 'selected'; }; ?>>Cook Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Costa Rica'){ echo 'selected'; }; ?>>Costa Rica</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Croatia (Hrvatska)'){ echo 'selected'; }; ?>>Croatia (Hrvatska)</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cuba'){ echo 'selected'; }; ?>>Cuba</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Cyprus'){ echo 'selected'; }; ?>>Cyprus</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Czech Republic'){ echo 'selected'; }; ?>>Czech Republic</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Denmark'){ echo 'selected'; }; ?>>Denmark</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Djibouti'){ echo 'selected'; }; ?>>Djibouti</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Dominica'){ echo 'selected'; }; ?>>Dominica</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Dominican Republic'){ echo 'selected'; }; ?>>Dominican Republic</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'East Timor'){ echo 'selected'; }; ?>>East Timor</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ecuador'){ echo 'selected'; }; ?>>Ecuador</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Egypt'){ echo 'selected'; }; ?>>Egypt</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'El Salvador'){ echo 'selected'; }; ?>>El Salvador</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Equatorial Guinea'){ echo 'selected'; }; ?>>Equatorial Guinea</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Eritrea'){ echo 'selected'; }; ?>>Eritrea</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Estonia'){ echo 'selected'; }; ?>>Estonia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ethiopia'){ echo 'selected'; }; ?>>Ethiopia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Falkland Islands (Malvinas)'){ echo 'selected'; }; ?>>Falkland Islands (Malvinas)</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Faroe Islands'){ echo 'selected'; }; ?>>Faroe Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Fiji'){ echo 'selected'; }; ?>>Fiji</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Finland'){ echo 'selected'; }; ?>>Finland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'France'){ echo 'selected'; }; ?>>France</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'French Guiana'){ echo 'selected'; }; ?>>French Guiana</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'French Polynesia'){ echo 'selected'; }; ?>>French Polynesia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'French Southern Territories'){ echo 'selected'; }; ?>>French Southern Territories</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Gabon'){ echo 'selected'; }; ?>>Gabon</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Gambia'){ echo 'selected'; }; ?>>Gambia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Georgia'){ echo 'selected'; }; ?>>Georgia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Germany'){ echo 'selected'; }; ?>>Germany</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ghana'){ echo 'selected'; }; ?>>Ghana</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Gibraltar'){ echo 'selected'; }; ?>>Gibraltar</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Greece'){ echo 'selected'; }; ?>>Greece</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Greenland'){ echo 'selected'; }; ?>>Greenland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Grenada'){ echo 'selected'; }; ?>>Grenada</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guadeloupe'){ echo 'selected'; }; ?>>Guadeloupe</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guam'){ echo 'selected'; }; ?>>Guam</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guatemala'){ echo 'selected'; }; ?>>Guatemala</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guernsey'){ echo 'selected'; }; ?>>Guernsey</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guinea'){ echo 'selected'; }; ?>>Guinea</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guinea-Bissau'){ echo 'selected'; }; ?>>Guinea-Bissau</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Guyana'){ echo 'selected'; }; ?>>Guyana</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Haiti'){ echo 'selected'; }; ?>>Haiti</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Heard and Mc Donald Islands'){ echo 'selected'; }; ?>>Heard and Mc Donald Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Honduras'){ echo 'selected'; }; ?>>Honduras</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Hong Kong'){ echo 'selected'; }; ?>>Hong Kong</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Hungary'){ echo 'selected'; }; ?>>Hungary</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Iceland'){ echo 'selected'; }; ?>>Iceland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'India'){ echo 'selected'; }; ?>>India</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Indonesia'){ echo 'selected'; }; ?>>Indonesia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Iran (Islamic Republic of)'){ echo 'selected'; }; ?>>Iran (Islamic Republic of)</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Iraq'){ echo 'selected'; }; ?>>Iraq</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ireland'){ echo 'selected'; }; ?>>Ireland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Isle of Man'){ echo 'selected'; }; ?>>Isle of Man</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Israel'){ echo 'selected'; }; ?>>Israel</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Italy'){ echo 'selected'; }; ?>>Italy</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ivory Coast'){ echo 'selected'; }; ?>>Ivory Coast</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Jamaica'){ echo 'selected'; }; ?>>Jamaica</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Japan'){ echo 'selected'; }; ?>>Japan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Jersey'){ echo 'selected'; }; ?>>Jersey</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Jordan'){ echo 'selected'; }; ?>>Jordan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Kazakhstan'){ echo 'selected'; }; ?>>Kazakhstan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Kenya'){ echo 'selected'; }; ?>>Kenya</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Kiribati'){ echo 'selected'; }; ?>>Kiribati</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Korea, Democratic Peoples Republic of '){ echo 'selected'; }; ?>>Korea, Democratic People' s Republic of </option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Korea, Republic of'){ echo 'selected'; }; ?>>Korea, Republic of</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Kuwait'){ echo 'selected'; }; ?>>Kuwait</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Kyrgyzstan'){ echo 'selected'; }; ?>>Kyrgyzstan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Lao Peoples Democratic Republic '){ echo 'selected'; }; ?>>Lao People' s Democratic Republic </option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Latvia'){ echo 'selected'; }; ?>>Latvia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Lebanon'){ echo 'selected'; }; ?>>Lebanon</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Lesotho'){ echo 'selected'; }; ?>>Lesotho</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Liberia'){ echo 'selected'; }; ?>>Liberia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Libyan Arab Jamahiriya'){ echo 'selected'; }; ?>>Libyan Arab Jamahiriya</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Liechtenstein'){ echo 'selected'; }; ?>>Liechtenstein</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Lithuania'){ echo 'selected'; }; ?>>Lithuania</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Luxembourg'){ echo 'selected'; }; ?>>Luxembourg</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Macau'){ echo 'selected'; }; ?>>Macau</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Yugoslavia'){ echo 'selected'; }; ?>>Yugoslavia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Madagascar'){ echo 'selected'; }; ?>>Madagascar</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Malawi'){ echo 'selected'; }; ?>>Malawi</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Malaysia'){ echo 'selected'; }; ?>>Malaysia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Maldives'){ echo 'selected'; }; ?>>Maldives</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mali'){ echo 'selected'; }; ?>>Mali</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Malta'){ echo 'selected'; }; ?>>Malta</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Marshall Islands'){ echo 'selected'; }; ?>>Marshall Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Martinique'){ echo 'selected'; }; ?>>Martinique</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mauritania'){ echo 'selected'; }; ?>>Mauritania</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mauritius'){ echo 'selected'; }; ?>>Mauritius</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mayotte'){ echo 'selected'; }; ?>>Mayotte</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mexico'){ echo 'selected'; }; ?>>Mexico</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Micronesia, Federated States of'){ echo 'selected'; }; ?>>Micronesia, Federated States of</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Moldova, Republic of'){ echo 'selected'; }; ?>>Moldova, Republic of</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Monaco'){ echo 'selected'; }; ?>>Monaco</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mongolia'){ echo 'selected'; }; ?>>Mongolia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Montenegro'){ echo 'selected'; }; ?>>Montenegro</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Montserrat'){ echo 'selected'; }; ?>>Montserrat</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Morocco'){ echo 'selected'; }; ?>>Morocco</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Mozambique'){ echo 'selected'; }; ?>>Mozambique</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Myanmar'){ echo 'selected'; }; ?>>Myanmar</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Namibia'){ echo 'selected'; }; ?>>Namibia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Nauru'){ echo 'selected'; }; ?>>Nauru</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Nepal'){ echo 'selected'; }; ?>>Nepal</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Netherlands'){ echo 'selected'; }; ?>>Netherlands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'New Caledonia'){ echo 'selected'; }; ?>>New Caledonia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'New Zealand'){ echo 'selected'; }; ?>>New Zealand</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Nicaragua'){ echo 'selected'; }; ?>>Nicaragua</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Niger'){ echo 'selected'; }; ?>>Niger</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Nigeria'){ echo 'selected'; }; ?>>Nigeria</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Niue'){ echo 'selected'; }; ?>>Niue</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Norfolk Island'){ echo 'selected'; }; ?>>Norfolk Island</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Northern Mariana Islands'){ echo 'selected'; }; ?>>Northern Mariana Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Norway'){ echo 'selected'; }; ?>>Norway</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Oman'){ echo 'selected'; }; ?>>Oman</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Pakistan'){ echo 'selected'; }; ?>>Pakistan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Palau'){ echo 'selected'; }; ?>>Palau</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Palestine'){ echo 'selected'; }; ?>>Palestine</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Panama'){ echo 'selected'; }; ?>>Panama</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Papua New Guinea'){ echo 'selected'; }; ?>>Papua New Guinea</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Paraguay'){ echo 'selected'; }; ?>>Paraguay</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Peru'){ echo 'selected'; }; ?>>Peru</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Philippines'){ echo 'selected'; }; ?>>Philippines</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Pitcairn'){ echo 'selected'; }; ?>>Pitcairn</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Poland'){ echo 'selected'; }; ?>>Poland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Portugal'){ echo 'selected'; }; ?>>Portugal</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Puerto Rico'){ echo 'selected'; }; ?>>Puerto Rico</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Qatar'){ echo 'selected'; }; ?>>Qatar</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Reunion'){ echo 'selected'; }; ?>>Reunion</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Romania'){ echo 'selected'; }; ?>>Romania</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Russian Federation'){ echo 'selected'; }; ?>>Russian Federation</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Rwanda'){ echo 'selected'; }; ?>>Rwanda</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Saint Kitts and Nevis'){ echo 'selected'; }; ?>>Saint Kitts and Nevis</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Saint Lucia'){ echo 'selected'; }; ?>>Saint Lucia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Saint Vincent and the Grenadines'){ echo 'selected'; }; ?>>Saint Vincent and the Grenadines</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Samoa'){ echo 'selected'; }; ?>>Samoa</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'San Marino'){ echo 'selected'; }; ?>>San Marino</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Sao Tome and Principe'){ echo 'selected'; }; ?>>Sao Tome and Principe</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Saudi Arabia'){ echo 'selected'; }; ?>>Saudi Arabia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Senegal'){ echo 'selected'; }; ?>>Senegal</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Serbia'){ echo 'selected'; }; ?>>Serbia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Seychelles'){ echo 'selected'; }; ?>>Seychelles</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Sierra Leone'){ echo 'selected'; }; ?>>Sierra Leone</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Singapore'){ echo 'selected'; }; ?>>Singapore</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Slovakia'){ echo 'selected'; }; ?>>Slovakia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Slovenia'){ echo 'selected'; }; ?>>Slovenia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Solomon Islands'){ echo 'selected'; }; ?>>Solomon Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Somalia'){ echo 'selected'; }; ?>>Somalia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'South Africa'){ echo 'selected'; }; ?>>South Africa</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'South Georgia South Sandwich Islands'){ echo 'selected'; }; ?>>South Georgia South Sandwich Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Spain'){ echo 'selected'; }; ?>>Spain</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Sri Lanka'){ echo 'selected'; }; ?>>Sri Lanka</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'St. Helena'){ echo 'selected'; }; ?>>St. Helena</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'St. Pierre and Miquelon'){ echo 'selected'; }; ?>>St. Pierre and Miquelon</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Sudan'){ echo 'selected'; }; ?>>Sudan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Suriname'){ echo 'selected'; }; ?>>Suriname</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Svalbard and Jan Mayen Islands'){ echo 'selected'; }; ?>>Svalbard and Jan Mayen Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Swaziland'){ echo 'selected'; }; ?>>Swaziland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Sweden'){ echo 'selected'; }; ?>>Sweden</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Switzerland'){ echo 'selected'; }; ?>>Switzerland</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Syrian Arab Republic'){ echo 'selected'; }; ?>>Syrian Arab Republic</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Taiwan'){ echo 'selected'; }; ?>>Taiwan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tajikistan'){ echo 'selected'; }; ?>>Tajikistan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tanzania, United Republic of'){ echo 'selected'; }; ?>>Tanzania, United Republic of</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Thailand'){ echo 'selected'; }; ?>>Thailand</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Togo'){ echo 'selected'; }; ?>>Togo</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tokelau'){ echo 'selected'; }; ?>>Tokelau</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tonga'){ echo 'selected'; }; ?>>Tonga</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Trinidad and Tobago'){ echo 'selected'; }; ?>>Trinidad and Tobago</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tunisia'){ echo 'selected'; }; ?>>Tunisia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Turkey'){ echo 'selected'; }; ?>>Turkey</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Turkmenistan'){ echo 'selected'; }; ?>>Turkmenistan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Turks and Caicos Islands'){ echo 'selected'; }; ?>>Turks and Caicos Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Tuvalu'){ echo 'selected'; }; ?>>Tuvalu</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Uganda'){ echo 'selected'; }; ?>>Uganda</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Ukraine'){ echo 'selected'; }; ?>>Ukraine</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'United Arab Emirates'){ echo 'selected'; }; ?>>United Arab Emirates</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'United Kingdom'){ echo 'selected'; }; ?>>United Kingdom</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'United States'){ echo 'selected'; }; ?>>United States</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'United States minor outlying islands'){ echo 'selected'; }; ?>>United States minor outlying islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Uruguay'){ echo 'selected'; }; ?>>Uruguay</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Uzbekistan'){ echo 'selected'; }; ?>>Uzbekistan</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Vanuatu'){ echo 'selected'; }; ?>>Vanuatu</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Vatican City State'){ echo 'selected'; }; ?>>Vatican City State</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Venezuela'){ echo 'selected'; }; ?>>Venezuela</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Vietnam'){ echo 'selected'; }; ?>>Vietnam</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Virgin Islands (British)'){ echo 'selected'; }; ?>>Virgin Islands (British)</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Virgin Islands (U.S.)'){ echo 'selected'; }; ?>>Virgin Islands (U.S.)</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Wallis and Futuna Islands'){ echo 'selected'; }; ?>>Wallis and Futuna Islands</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Western Sahara'){ echo 'selected'; }; ?>>Western Sahara</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Yemen'){ echo 'selected'; }; ?>>Yemen</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Zambia'){ echo 'selected'; }; ?>>Zambia</option>
                    <option <?php //if($user1['MBR_COUNTRY'] == 'Zimbabwe'){ echo 'selected'; }; ?>>Zimbabwe</option>
                </select>
            </div> -->

            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-id-badge"></i>Alamat:</label>
                <input type="text" class="form-control" value="<?php echo $user1['MBR_ADDRESS'] ?>" name="address" required autocomplete="off">
            </div>

            <div class="col-12">
                <label for="form44" class="color-highlight"><i class="fa fa-building"></i>City:</label>
                <input type="text" class="form-control" value="<?php echo $user1['MBR_CITY'] ?>" name="city" required autocomplete="off">
            </div>
            <!-- <div class="col-12 mt-3">
                <button type="submit" name="profile_submit" class="btn btn-m btn-full rounded-sm shadow-xl bg-highlight text-uppercase mb-3 font-900">Submit</button>
            </div> -->
        </form>
        
    </div>
</div>
<script>
    function GetSelectedTextValue2(idt_type) {
        var selVal = idt_type.value;
        var no_idt = document.getElementById("no_idt");
        if(selVal == 'Passport'){
            document.getElementById('no_idt').type='text';
        } else {
            document.getElementById('no_idt').type='number';
            document.getElementById("no_idt").max = "9999999999999999";
            document.getElementById("no_idt").min = "1000000000000000";
        }
    };
    let idttyp = ('<?php echo $user1['MBR_TYPE_IDT'] ?>' == 'KTP') ? 'number' : 'text';
    document.querySelector('#no_idt').addEventListener('focus', function(el){
        this.value = (idttyp == 'number') ? this.value.replace(/\D+/i, '') : this.value;
        this.type  = idttyp;
    }, {once : true});
</script>