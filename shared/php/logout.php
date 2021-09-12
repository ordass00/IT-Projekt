<?php
session_start();
unset($_SESSION);
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logout</title>
</head>

<body>
    <script>window.localStorage.setItem('loggedOut', 'true');
    window.location.href = "../../index/index.html";
    </script>
</body>
</html>