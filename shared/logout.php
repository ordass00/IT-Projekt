<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logout</title>
</head>

<body>
    <?php
    session_start();
    unset($_SESSION);
    session_destroy();
    ?>
    <script>window.localStorage.setItem('loggedOut', 'true');</script>
    <?php
    header('Location: ../index/index.php');
    exit;
    ?>
</body>

</html>