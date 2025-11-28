<?php
	if(isset($_GET['id'])){
		$id = htmlentities(str_replace('%', '', str_replace(' ', '_', stripslashes(($_GET['id'])))), ENT_QUOTES, 'WINDOWS-1252');
		$SQL_QUERY = mysqli_query($db, "
			SELECT *
			FROM tb_blog 
			WHERE MD5(MD5(ID_BLOG)) = '" . $id . "'
			LIMIT 1
		");
		if(mysqli_num_rows($SQL_QUERY) > 0){
			$RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);

		} else { die("<script>alert('please login.4');location.href = './'</script>"); };
	}

    $region = 'ap-southeast-1';
    $bucketName = 'allmediaindo-2';
    $folder = 'ibftrader';
    $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
    $IAM_SECRET = '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';
?>
<div class="page-title page-title-small">
    <h2>News</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content">
        <h1 class="font-600 font-18 line-height-m"><?php echo preg_replace('/\\\\/','',$RESULT_QUERY["BLOG_TITLE"]) ?></h1>
        <span class="d-block mb-3"><?php echo date_format(date_create($RESULT_QUERY['BLOG_DATETIME']), "d-M-Y")?> <span class="copyright-year"></span>, <?php echo date_format(date_create($RESULT_QUERY['BLOG_DATETIME']), "H:i:s")?></span>
    </div>
    <img src="<?php echo 'https://'.$bucketName.'.s3.'.$region.'.amazonaws.com/'.$folder.'/'.$RESULT_QUERY['BLOG_IMG']; ?>" alt="image" class="imaged img-fluid">
    <span class="d-block text-end font-10 pe-3 opacity-60 mt-n4 color-white">Image Source: Pixabay</span>
    <div class="content">
        <p>
            <?php echo $RESULT_QUERY['BLOG_MESSAGE']?>
        </p>
    </div>
</div>