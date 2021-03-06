<?php
include "vendor/autoload.php";
use App\MiddleWare\Auth;
use App\Controller\AuthController;
session_start();
$auth = new Auth();
$auth->isLogin();
$authController = new AuthController();
$data = $authController->getByid();
?>
<?php ob_start() ?>
<!doctype html>
<html lang="en">
<head>
    <title>H.T.T Motel Manager</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="Public/Css/view.css">
    <link rel="shortcut icon" href="Public/Image/icon2.png">
</head>
<body>
<div class="container" style="height: auto" id="header">
    <header class="row">
        <div class="col-12 col-md-12 shopping-mall">
            <h1>H.T.T Motel Manager</h1>
            <h5 style="color: white">The center point of the professional managing</h5>
        </div>
    </header>
    <?php include "View/core/navbar.php" ?>
</div>
<div class="container" style="height: auto">
    <div class="row">
        <article class="col-12 col-sm-9 mt-2" >
            <div class="col-12 col-sm-12 row mb-2" style="height: 700px; overflow: auto ">
                <?php include "router.php" ?>
            </div>
        </article>
        <aside class="col-12 col-sm-3">
            <?php include "View/core/sidebar.php" ?>
        </aside>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="Public/Js/roomJs.js"></script>

</body>
</html>
