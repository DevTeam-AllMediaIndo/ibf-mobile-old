<?php
    if(isset($_POST["submit"])){
        if(isset($_POST["oldpass"])){
            if(isset($_POST["newpass"])){
                if(isset($_POST["verpass"])){
                    $oldpass = form_input($_POST["oldpass"]);
                    $newpass = form_input($_POST["newpass"]);
                    $verpass = form_input($_POST["verpass"]);
                    
                    $reg_patt = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?=.*^[^'\"\\\\<>]*$).{8,}$/i";
                    if(preg_match($reg_patt, $newpass)){
                        $SQL_QUERY = mysqli_query($db,'
                            SELECT
                                tb_member.MBR_PASS
                            FROM tb_member
                            WHERE tb_member.MBR_ID = "'.$user1["MBR_ID"].'"
                        ') or die(mysqli_error($db));
                        if(mysqli_num_rows($SQL_QUERY) > 0){
                            $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                            
                            if($oldpass == $RESULT_QUERY["MBR_PASS"]){
                                if($newpass == $verpass){
                                    $EXEC_SQL = mysqli_query($db,'
                                        UPDATE tb_member SET 
                                            tb_member.MBR_PASS                 = "'.$newpass.'"
                                        WHERE tb_member.MBR_ID = "'.$user1["MBR_ID"].'"
                                    ') or die(mysqli_error($db));
                                    die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Berhasil merubah password anda.')."'</script>");
                                }else{
                                    logerr("Password Baru Tidak Sama Dengan Password Konfirmasi", "Ubah Password", $user1["MBR_ID"]);
                                    die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Password baru anda tidak sama dengan konfirmasi password silahkan coba lagi.')."'</script>");
                                };
                            }else{
                                logerr("Password Lama Yang Dimasukan Tidak Sesuai", "Ubah Password", $user1["MBR_ID"]);
                                die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Password lama yang anda masukan salah. Silahkan coba lagi.')."'</script>");
                            };
                        }
                    }else { 
                        logerr("Pola Password Tidak Sesuai", "Ubah Password", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Pola Password Tidak Sesuai')."'</script>"); 
                    }

                }else{
                    logerr("Parameter Ke-3 Tidak Lengkap", "Ubah Password", $user1["MBR_ID"]);
                    die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Parameter Ke-3 Tidak Lengkap')."'</script>"); 
                }
            }else{
                logerr("Parameter Ke-2 Tidak Lengkap", "Ubah Password", $user1["MBR_ID"]);
                die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Parameter Ke-2 Tidak Lengkap')."'</script>"); 
            }
        }else{
            logerr("Parameter Ke-1 Tidak Lengkap", "Ubah Password", $user1["MBR_ID"]);
            die("<script>location.href = 'home.php?page=".$login_page."&notif=".base64_encode('Parameter Ke-1 Tidak Lengkap')."'</script>"); 
        }
    }
?>
<style>
    .eye {
        cursor: pointer;
    }
</style>
<div class="page-title page-title-small">
    <h2>Ubah Password</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<?php
        if(isset($_GET['notif'])){
            $notif = base64_decode($_GET['notif']);
    ?>
        <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
            <span class="alert-icon"><i class="fa fa-bell font-18"></i></span>
            <strong class="alert-icon-text"><?php echo $notif; ?>.</strong>
            <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    <?php }; ?>
<div class="card card-style">
    <div class="content mb-0">
        <form method="post">
            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1">Masukan Password Lama:</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="(Masukan Password Anda Sebelumnya Untuk Verifikasi)" name="oldpass" required autocomplete="off">
                    <div class="input-group-prepend eye">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1">Masukan Password Baru</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="(Tidak Bisa Sama Dengan Password Sebelum Nya)" name="newpass" required autocomplete="off" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?=.*^[^'\x22\\<>]*$).{8,}$" title="Minimal 1 digit angka, 1 huruf kecil, 1 huruf besar, dan 1 karakter spesial(Kecuali ['],[&#8220],[\],[<],[>]). Dan Panjang text minimal harus sebanyak 8 karakter">
                    <div class="input-group-prepend eye">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label for="fullname1" class="color-blue-dark font-10 mt-1">Konfirmasi Ulang Password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="(Ketik Ulang Password Baru Anda)" name="verpass" required autocomplete="off">
                    <div class="input-group-prepend eye">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-m btn-full rounded-sm shadow-xl bg-highlight text-uppercase mb-3 font-900 mt-3">Submit</button>
        </form>
    </div>
</div>
<script>
    Array.from(document.getElementsByClassName('eye')).forEach((el) => {
        el.addEventListener('click', function(e){
            if(!this.className.includes('act')){ 
                this.classList.add('act'); 
                this.innerHTML = `
                    <span class="input-group-text" id="basic-addon1" style="color : cornflowerblue;"><i class="fa fa-eye" aria-hidden="true"></i></span>
                `;
                this.previousElementSibling.type = 'text';
            }else{ 
                this.classList.remove('act'); 
                this.innerHTML = `
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                `;
                this.previousElementSibling.type = 'password';
            }
        });
    });
</script>