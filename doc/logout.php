<?php
    if (isset($_COOKIE['id'])) {
        unset($_COOKIE['id']); 
        unset($_COOKIE['x']); 

        setcookie('id', null, -1, '/'); 
        setcookie('x', null, -1, '/'); 
        die("<script>location.href = '../../'</script>");
    } else { die("<script>location.href = 'index.html'</script>"); }
?>