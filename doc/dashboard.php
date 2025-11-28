<div class="card-body ">
    <?php
        if(isset($_GET['notif'])){
            $notif = base64_decode($_GET['notif']);
    ?>
        <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
            <span class="alert-icon"><i class="fa fa-bell font-18"></i></span>
            <strong class="alert-icon-text"><?php echo $notif; ?>.</strong>
            <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
        <style>
            div.menu-box-modal {
                border-style: solid;
                border-width: 4px 4px 4px 4px;
                border-radius: 0.3rem;
            }
        </style>
        <!-- <div id="menu-success-1" class="menu menu-box-modal rounded-m menu-active" data-menu-height="600" data-menu-width="310" style="display: block; width: 310px; height: 300px;">
            <h1 class="text-center mt-3 font-700">Pemberitahuan</h1>
            <p class="boxed-text-l">
                Kepada Yth.<br>
                Nasabah<br>
                PT. International Business Futures<br>
                di tempat<br>
            </p>
            <p class="boxed-text-l text-center">
                <h6 class="text-center">Perihal:</h6><br>
                <h6 class="text-center"> 
                    Libur Pemilihan Umum (PEMILU) <br>
                </h6>
            </p>
            <p class="boxed-text-l">
                Bertepatan dengan Libur Pemilihan Umum, Rabu tanggal 14 Februari 2024.<br>
                Disertai pengumuman libur pelayanan perbankan dan kliring bank pada hari<br>
                tersebut. Maka sehubungan dengan hal tersebut diatas, kami informasikan<br>
                beberapa hal sebagai berikut:<br>
            </p>
            <p class="boxed-text-l">
                <ul>
                    <li>Seluruh proses penarikan Dana (withdrawal) <strong>akan ditiadakan 
                        sementara pada tanggal 14 Februari 2024.</strong> Formulir yang masuk 
                        pada periode tanggal tersebut tetap kami terima dan akan kami 
                        proses di hari kerja berikutnya.
                    </li>
                    <li>
                    Untuk proses penambahan dana (deposit/top up) akan berjalan<br>
                    seperti biasa. 
                    </li>
                </ul>
            </p>
            <p class="boxed-text-l">Demikian yang dapat kami sampaikan, terima kasih atas perhatian dan kerjasamanya.</p>
            <p class="boxed-text-l">
                Hormat Kami,<br>
                Management<br>
            </p>
            <p class="boxed-text-l">
                PT. International Business Futures
            </p>
            <center>
                <p>
                    PT. INTERNATIONAL BUSINESS FUTURES<br>
                    Paskal Hyper Square Blok D No. 45-46 Bandung, Jawa Barat – 40181 <br>
                    | Tel +62 2286061128 | Fax. +62 228606112<br>
                </p>
            </center>
            <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light" style="margin-bottom: 10px;">Mengerti</a>
        </div> -->
    <?php }; ?>
    <div class="splide single-slider slider-no-arrows slider-no-dots homepage-slider" id="single-slider-1">
        <div class="splide__track">
            <div class="splide__list">
                <!--<div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320" style="background-image: url('<?php echo convertToBase64('assets/img/bg/tahun-baru-islam.jpg'); ?>');"> 
                        <div class="card-bottom">
                            <p class="boxed-text-xl">
                                Selamat Tahun Baru Islam 1447 H
                            </p>
                        </div>
                        <div class="card-overlay bg-gradient-fade"></div>
                    </div>
                </div>-->
                <!--<div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320" style="background-image: url('assets/img/fix-anniversary-11-ibf.webp');">
                        <div class="card-bottom">
                            <p class="boxed-text-xl">
                                Anniversary 11th <b><a href="https://instagram.com/ibf.trader?igshid=Yzg5MTU1MDY=">@ibf.trader</a> Terimakasih atas kepercayaan seluruh nasabah!</b>
                            </p>
                        </div>
                        <div class="card-overlay"></div>
                    </div>
                </div>-->
                <div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320" style="background-image: url('assets/img/slide5.webp');"> 
                        <div class="card-bottom">
                            <p class="boxed-text-xl">
                                Salah Satu Dari 10 Pialang Ter-Aktif di Indonesia.
                            </p>
                        </div>
                        <div class="card-overlay bg-gradient-fade"></div>
                    </div>
                </div>
                <!--<div class="splide__slide">
                    <div class="card rounded-l mx-2 text-center shadow-l" data-card-height="320" style="background-image: url('<?php echo convertToBase64('assets/img/bg/nataru-apk-ibf.jpg'); ?>');">
                        <div class="card-bottom">
                            <p class="boxed-text-xl">
                                Selamat Natal dan<br> Tahun Baru 2025
                            </p>
                        </div>
                        <div class="card-overlay"></div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
        
    <div class="content mt-0">
        <div class="row">
            <div class="col-12">
                <a href="home.php?page=account" class="btn btn-full btn-m rounded-s text-uppercase font-700 shadow-xl bg-highlight">Create Account</a>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content text-center">
            <h2>TEREGULASI</h2>
            <p class="boxed-text-xl">
                PT. International Business Futures TD PSE (Tanda Daftar Penyelenggara Sistem Elektronik) dengan <br> PB-UMKU: 022020689174200020001
            </p>
        </div>
        <div class="divider divider-small mb-3 bg-highlight"></div>
        
        <div class="content">            
            <div class="mb-4 pb-3">
                <div class="text-center">
                    <img src="<?php echo convertToBase64('assets/img/td-pse-mobile.png'); ?>"> <br><br>
                    <h5 class="font-16 font-600">&nbsp;</h5>
                    <a href="assets/doc/TD-PSE-IBF.pdf" target="blank">
                        (Click Here View Document)
                    </a>
                </div>
            </div>
            <div class="mb-4 pb-3">
                <div class="text-center">
                    <img src="<?php echo convertToBase64('assets/img/logo-iso-fix.png'); ?>" style="width: 95%;"> <br><br>
                    <h5 class="font-16 font-600">&nbsp;</h5>
                    <!-- <a href="assets/doc/TD-PSE-IBF.pdf" target="blank">
                        (Click Here View Document)
                    </a> -->
                </div>
            </div>
                        
        </div>
    </div>

    <div class="content mb-2">
        <h5 class="float-start font-16 font-500">Financial Operations</h5>
        <div class="clearfix"></div>
    </div>

    <div style="    margin: 0px 15px 30px 15px;">
        <div class="content">
            <div class="row">
                <a href="home.php?page=profile" class="col-4">
                    <div class="">
                        <div class="bg-blue-light back-to-top-icon-circle text-center" data-card-height="100">
                        <img src="<?php echo convertToBase64('assets/img/icon-profile.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">Profil</h5>
                    </div>
                </a>
                <a href="home.php?page=account" class="col-4">
                    <div class="">
                        <div class="bg-mint-light back-to-top-icon-circle  text-center" data-card-height="100">
                        <img src="<?php echo convertToBase64('assets/img/revisi-icon-dpwd.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">Deposit</h5>
                    </div>
                </a>
                <a href="home.php?page=account" class="col-4">
                    <div class="">
                        <div class="bg-red-light back-to-top-icon-circle  text-center" data-card-height="90">
                        <img src="<?php echo convertToBase64('assets/img/revisi-icon-dpwd.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">Withdrawal</h5>
                    </div>
                </a>
                <a href="home.php?page=account" class="col-4">
                    <div class="">
                        <div class="bg-teal-light back-to-top-icon-circle  text-center" data-card-height="100">
                        <img src="<?php echo convertToBase64('assets/img/icon-document1.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">Dokumen</h5>
                    </div>
                </a>
                <a href="home.php?page=pusat_bantuan" class="col-4">
                    <div class="">
                        <div class="bg-green-light back-to-top-icon-circle  text-center" data-card-height="100">
                        <img src="<?php echo convertToBase64('assets/img/icon-ticket.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">Ticket</h5>
                    </div>
                </a>
                <a href="home.php?page=faq" class="col-4">
                    <div class="">
                        <div class="bg-pink-light back-to-top-icon-circle  text-center" data-card-height="90">
                        <img src="<?php echo convertToBase64('assets/img/ask3.png'); ?>" width="100%" align="center">
                        </div>
                        <h5 class="font-11 text-center">FAQ</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    

<div class="card card-style">
    <div class="content mb-2 mt-3">
        <h5 class="float-start font-16">Tutorial</h5>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-6 text-center">
            <div class="card">
                <div class="card-body">
                    <a href="https://www.youtube.com/embed/rMoYVqHb7RE">
                        <img width="100%" src="<?php echo convertToBase64('images/pictures/thumbnai-ibf-2.jpg'); ?>">
                    </a>
                    <div style="color:black">Cara Buat Demo dan Live Account</div>
                </div>
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="card"> 
                <div class="card-body">
                    <a href="https://www.youtube.com/embed/oGPDckcvS4o">
                        <img width="100%" src="<?php echo convertToBase64('images/pictures/thumbnail-ibf-1.jpg'); ?>">
                    </a>
                    <div style="color:black">Cara Deposit dan Withdrawal Account</div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="card preload-img" data-src="<?php echo convertToBase64('images/pictures/20s.jpg'); ?>">
        <div class="card-body">
            <h4 class="color-white">Our Product</h4>
            <p class="color-white">
               PT. International Business Futures menyediakan berbagai pilihan product yang bisa anda transaksikan
            </p>
            <div class="card card-style ms-0 me-0 bg-theme">
                <div class="row mt-3 pt-1 mb-3">
                    <div class="col-6">
                        <i class="float-start ms-3 me-3" 
                            data-feather="dollar-sign" 
                            data-feather-line="1" 
                            data-feather-size="35" 
                            data-feather-color="blue-dark" 
                            data-feather-bg="blue-fade-light">
                        </i>
                        <h5 class="color-theme float-start font-13 font-500 line-height-s pb-3 mb-3">Forex<br>Exchange</h5>
                    </div>
                    <div class="col-6">
                        <i class="float-start ms-3 me-3" 
                            data-feather="compass" 
                            data-feather-line="1" 
                            data-feather-size="35" 
                            data-feather-color="dark-dark" 
                            data-feather-bg="dark-fade-light">
                        </i>
                        <h5 class="color-theme float-start font-13 font-500 line-height-s pb-3 mb-3">Metal &<br>Energy</h5>
                    </div>
                    <div class="col-6">
                        <i class="float-start ms-3 me-3" 
                            data-feather="activity" 
                            data-feather-line="1" 
                            data-feather-size="35" 
                            data-feather-color="brown-dark" 
                            data-feather-bg="brown-fade-light">
                        </i>
                        <h5 class="color-theme float-start font-13 font-500 line-height-s">Index<br>Asia</h5>
                    </div>
                    <div class="col-6">
                        <i class="float-start ms-3 me-3" 
                            data-feather="award" 
                            data-feather-line="1" 
                            data-feather-size="35" 
                            data-feather-color="green-dark" 
                            data-feather-bg="green-fade-light">
                        </i>
                        <h5 class="color-theme float-start font-13 font-500 line-height-s">US<br>Index</h5>
                    </div>
                
                </div>
            </div>
        </div>
        <div class="card-overlay bg-highlight opacity-90"></div>
        <div class="card-overlay dark-mode-tint"></div>
    </div>

    <div class="card card-style">
        <div class="content text-center">
            <h2>Metatrader 4</h2>
            <p class="boxed-text-xl">
                PT. International Business Futures menggunakan Metatrader 4 sebagai sarana untuk bertransaksi. Metatrader 4 merupakan aplikasi yang paling banyak di gunakan di dunia sebagai sarana bertransaksi dalam foreign exchange.
            </p>
        </div>
        <div class="divider divider-small mb-3 bg-highlight"></div>
        
        <div class="content">            
            <div class="mb-4 pb-3">
                <div class="text-center">
                    <img src="<?php echo convertToBase64('assets/img/logo-mt4.png'); ?>" width="20%"><br>
                    <h5 class="font-16 font-600">&nbsp;</h5>
                    <a href="https://download.mql5.com/cdn/mobile/mt4/android?server=IntBusinessFutures-Demo,IntBusinessFutures-Real">
                        (Click Here Download Metatrader 4)
                    </a>
                </div>
            </div>            
        </div>
    </div>
<div class="card card-style mb-3">
    <div class="content mb-2 mt-3">
        <h5 class="float-start font-16">Fundamental & technical Analys</h5>
        <div class="clearfix"></div>
    </div>
    <div class="splide double-slider slider-no-arrows slider-no-dots " id="double-slider-2">
        <div class="splide__track">
            <div class="splide__list">
                <?php
                    $region = 'ap-southeast-1';
                    $bucketName = 'allmediaindo-2';
                    $folder = 'ibftrader';
                    $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
                    $IAM_SECRET = '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';

                    $SQL_QUERY = mysqli_query($db, '
                        SELECT
                            tb_blog.ID_BLOG,
                            tb_blog.BLOG_TITLE,
                            tb_blog.BLOG_IMG
                        FROM tb_blog
                        WHERE tb_blog.BLOG_TYPE = 4
                        ORDER BY tb_blog.BLOG_DATETIME DESC
                        LIMIT 1
                    ');
                    if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
                        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                ?>
                <div class="splide__slide">
                    <a href="home.php?page=blog-detail&id=<?php echo md5(md5($RESULT_QUERY['ID_BLOG']))?>">
                        <div data-card-height="250" class="card mx-3 rounded-m shadow-l" style="background-image: url('<?php echo 'https://'.$bucketName.'.s3.'.$region.'.amazonaws.com/'.$folder.'/'.$RESULT_QUERY['BLOG_IMG']; ?>');">
                            <div class="card-bottom p-1">
                                <h4 class="color-white font-200"><?php echo substr(mysqli_real_escape_string($db, addslashes(strip_tags(stripslashes($RESULT_QUERY['BLOG_TITLE'])))), 0, 35) ?>...</h4>
                            </div>
                            <div class="card-overlay bg-gradient opacity-80"></div>
                        </div>
                    </a>
                </div>
                <?php };}; ?>
            </div>
        </div>
    </div>

    <div class="content mb-2">
        <h5 class="float-start font-16">News Corner</h5>
        <div class="clearfix"></div>
    </div>
    <div class="splide double-slider slider-no-arrows slider-no-dots " id="double-slider-3">
        <div class="splide__track">
            <div class="splide__list">
                <?php
                    $SQL_QUERY = mysqli_query($db, '
                        SELECT
                            tb_blog.ID_BLOG,
                            tb_blog.BLOG_TITLE,
                            tb_blog.BLOG_IMG
                        FROM tb_blog
                        WHERE tb_blog.BLOG_TYPE = 5
                        ORDER BY tb_blog.BLOG_DATETIME DESC
                        LIMIT 5
                    ');
                    if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
                        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                ?>
                <div class="splide__slide">
                    <a href="home.php?page=blog-detail&id=<?php echo md5(md5($RESULT_QUERY['ID_BLOG']))?>">
                        <div data-card-height="250" class="card mx-3 rounded-m shadow-l" style="background-image: url('<?php echo 'https://'.$bucketName.'.s3.'.$region.'.amazonaws.com/'.$folder.'/'.$RESULT_QUERY['BLOG_IMG']; ?>');">
                            <div class="card-bottom p-1">
                                <h4 class="color-white font-200"><?php echo substr(mysqli_real_escape_string($db, addslashes(strip_tags(stripslashes($RESULT_QUERY['BLOG_TITLE'])))), 0, 35) ?>...</h4>
                            </div>
                            <div class="card-overlay bg-gradient opacity-80"></div>
                        </div>
                    </a>
                </div>
                <?php };}; ?>
            </div>
        </div>
    </div>
    <!-- <a href="home.php?page=racc/aplikasipembukaanrekening11&id=bb225d2e111239b79c8fbab5790e5778">O2</a> -->
</div>