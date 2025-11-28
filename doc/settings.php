
<?php

    if(isset($_POST['submit_logout'])){
        die("<script>location.href = 'doc/logout.php'</script>");
    }
    if(!isset($user1['MBR_ID'])){ die("<script>location.href = 'signin.php'</script>"); };
?>
<div class="page-title page-title-small">
    <h2>Setting</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content mt-0 mb-2">
        <div class="list-group list-custom-large">
            <a href="#" data-toggle-theme class="show-on-theme-light">
                <i class="fa font-14 fa-moon bg-brown-dark rounded-sm"></i>
                <span>Dark Mode</span>
                <strong>Auto Dark Mode Available Too</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>     
            <a href="#" data-toggle-theme class="show-on-theme-dark">
                <i class="fa font-14 fa-lightbulb bg-yellow-dark rounded-sm"></i>
                <span>Light Mode</span>
                <strong>Auto Dark Mode Available Too</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>     
            <a style="border-bottom: 0px none;" href="#" data-menu="menu-highlights">
                <i class="fa font-14 fa-brush bg-highlight color-white rounded-sm"></i>
                <span>Color Scheme</span>
                <strong>A tone of Colors, Just for You</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>  
        </div>
    </div>  
</div>
<div class="card card-style">
    <div class="content mb-0 mt-0">
        <div class="list-group list-custom-large">
            <a style="border-bottom: 0px none;" href="home.php?page=profile" data-menu="menu-share">
                <i class="fa font-14 fa-user-circle bg-green-dark rounded-sm"></i>
                <span>Profile</span>
                <strong>Detail Information about your profile!</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>  
        </div>
        <div class="list-group list-custom-large">
            <a style="border-bottom: 0px none;" href="home.php?page=changepass" data-menu="menu-signin">
                <i class="fa font-14 fa-lock bg-blue-dark rounded-sm"></i>
                <span>Ganti Password</span>
                <strong>Form Untuk Pengubahan Password Anda</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>  
        </div>
        <div class="list-group list-custom-large">
            <a style="border-bottom: 0px none;" href="home.php?page=hapus_akun" data-menu="menu-signin">
                <i class="fa font-14 fa-trash bg-red-dark rounded-sm"></i>
                <span>Hapus Akun</span>
                <strong>Form Untuk Menghapus Akun</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>  
        </div>
    </div>  
</div>
<div class="card card-style">
    <div class="content mt-0 mb-2">
        <div class="list-group list-custom-large">
            <a href="home.php?page=ajak_teman">
                <i class="fa font-14 fa-share-square bg-green-dark rounded-sm"></i>
                <span>Ajak Teman</span>
                <strong>Scan QR Code untuk begabung dengan anda</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>  
            <a href="home.php?page=pusat_bantuan">
                <i class="fa font-14 fa-globe bg-blue-dark rounded-sm"></i>
                <span>Pusat Bantuan</span>
                <strong>Dapatkan bantuan ticket untuk pertanyaan anda</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>     
            <a href="home.php?page=disclaimer">
                <i class="far font-14 fas fa-thumbtack bg-yellow-dark rounded-sm"></i>
                <span>Disclaimer</span>
                <strong>Pernyataan persetujuan menggunakan</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>
            <a href="home.php?page=syarat_ketentuan">
                <i class="fa font-14 fas fa-clone bg-green-dark rounded-sm"></i>
                <span>Syarat & Ketentuan</span>
                <strong>Rincian Syarat dan ketentuan</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>
            <a href="home.php?page=faq">
                <i class="fa font-14 fa fa-question-circle bg-blue-dark rounded-sm"></i>
                <span>Faq</span>
                <strong>Tentang IBF dan Regulasinya</strong>
                <i class="fa fa-angle-left me-2"></i>
            </a>
        </div>
    </div>  
</div>
<form method="POST">
    <div class="card card-style">
        <button class="btn btn-full btn-danger rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_logout">Logout.</button>
    </div>
</form>