<?php

// CANOPIN SOLUTIONS - CANOPIN 2026

require_once("include/initialize.php");

if(isset($_SESSION['UID'])){
    redirect("index.php");
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Arsuento Solutions | Login</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet"
        href="<?php echo WEB_ROOT;?>plugins/fontawesome-free/css/all.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet"
        href="<?php echo WEB_ROOT;?>dist/css/adminlte.min.css">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto+Condensed:wght@400;500;700&display=swap"
        rel="stylesheet">


<style>

/* =====================================================
   CANOPIN SOLUTIONS
   DARK JOJO-INSPIRED LOGIN
   ===================================================== */


/* BODY */

body.login-page {

    min-height: 100vh;

    margin: 0;

    background:
        radial-gradient(
            circle at 50% 45%,
            rgba(80, 20, 110, 0.16),
            transparent 45%
        ),
        #05030a;

    font-family: 'Roboto Condensed', sans-serif;

    overflow: hidden;

    position: relative;
}


/* SUBTLE DIAGONAL LINES */

body.login-page::before {

    content: "";

    position: absolute;

    inset: 0;

    background:
        repeating-linear-gradient(
            45deg,
            transparent 0px,
            transparent 38px,
            rgba(130, 60, 180, 0.08) 39px,
            transparent 40px
        );

    pointer-events: none;

}


/* DARK VIGNETTE */

body.login-page::after {

    content: "";

    position: absolute;

    inset: 0;

    background:
        radial-gradient(
            ellipse at center,
            transparent 35%,
            rgba(0,0,0,0.65) 100%
        );

    pointer-events: none;

}


/* LOGIN BOX */

.login-box {

    width: 520px;

    max-width: 92%;

    position: relative;

    z-index: 5;

}


/* CARD */

.login-box .card {

    background:
        linear-gradient(
            145deg,
            rgba(13, 7, 20, 0.98),
            rgba(5, 3, 10, 0.98)
        );

    border:

        1px solid rgba(139, 74, 190, 0.8);

    border-radius: 15px;

    box-shadow:

        0 0 0 1px rgba(212,175,55,0.08),

        0 0 30px rgba(90,30,130,0.20),

        0 25px 70px rgba(0,0,0,0.8);

    overflow: hidden;

}


/* GOLD/PURPLE TOP LINE */

.login-box .card::before {

    content: "";

    display: block;

    height: 2px;

    background:

        linear-gradient(
            90deg,
            transparent,
            #6d3b91,
            #d4af37,
            #6d3b91,
            transparent
        );

    opacity: 0.8;

}


/* CARD BODY */

.login-card-body {

    padding: 42px 40px 35px 40px;

    background: transparent !important;

}


/* =====================================================
   LOGO
   ===================================================== */

.logo-container {

    width: 120px;

    height: 120px;

    margin: 0 auto 22px auto;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(120, 20, 100, 0.30),
            rgba(10, 3, 15, 0.90)
        );

    border: 1px solid rgba(212,175,55,0.6);

    box-shadow:

        0 0 20px rgba(120,30,150,0.25),

        inset 0 0 20px rgba(0,0,0,0.7);

}


/* YOUR LOGO */

.logo-container img {

    max-width: 90px;

    max-height: 90px;

    object-fit: contain;

}


/* =====================================================
   TITLE
   ===================================================== */

.login-box-msg {

    color: #d4af37 !important;

    font-family: 'Bebas Neue', sans-serif;

    font-size: 26px;

    letter-spacing: 4px;

    text-align: center;

    margin-bottom: 30px;

    text-shadow:

        0 0 8px rgba(212,175,55,0.25);

}


/* LITTLE GOLD DIVIDER */

.login-box-msg::after {

    content: "◆";

    display: block;

    font-size: 9px;

    color: #d4af37;

    margin-top: 10px;

    opacity: 0.8;

}


/* =====================================================
   INPUTS
   ===================================================== */

.input-group {

    margin-bottom: 18px !important;

}


.form-control {

    height: 54px !important;

    background: rgba(4,2,8,0.85) !important;

    color: #eeeeee !important;

    border:

        1px solid #713d91 !important;

    border-right: none !important;

    border-radius: 5px 0 0 5px !important;

    font-family: 'Roboto Condensed', sans-serif;

    font-size: 15px;

    letter-spacing: 1px;

    transition: 0.25s;

}


.form-control::placeholder {

    color: #77717e;

    opacity: 1;

}


.form-control:focus {

    border-color: #a866cc !important;

    box-shadow:

        0 0 10px rgba(140,70,180,0.15) !important;

}


/* INPUT ICON AREA */

.input-group-text {

    height: 54px;

    background: rgba(4,2,8,0.85) !important;

    color: #d4af37 !important;

    border:

        1px solid #713d91 !important;

    border-left: none !important;

    border-radius: 0 5px 5px 0 !important;

}


/* =====================================================
   LOGIN BUTTON
   ===================================================== */

.login-button-area {

    display: flex;

    justify-content: flex-end;

    margin-top: 25px;

}


.btn-login {

    width: 145px;

    height: 55px;

    background: transparent !important;

    color: #d4af37 !important;

    border:

        1px solid #a27a18 !important;

    border-radius: 5px;

    font-family: 'Bebas Neue', sans-serif;

    font-size: 19px;

    letter-spacing: 2px;

    transition: 0.25s;

}


.btn-login i {

    margin-right: 7px;

}


.btn-login:hover {

    background: rgba(212,175,55,0.08) !important;

    color: #f0cf5c !important;

    border-color: #d4af37 !important;

    box-shadow:

        0 0 15px rgba(212,175,55,0.15);

    transform: translateY(-2px);

}


/* =====================================================
   FOOTER
   ===================================================== */

.company-name {

    margin-top: 35px;

    padding-top: 20px;

    border-top:

        1px solid rgba(130,70,170,0.25);

    text-align: center;

    color: #8060a0;

    font-family: 'Bebas Neue', sans-serif;

    font-size: 17px;

    letter-spacing: 6px;

}


.company-name span {

    color: #a88730;

    margin: 0 7px;

}


/* =====================================================
   MOBILE
   ===================================================== */

@media (max-width: 500px) {

    .login-card-body {

        padding: 35px 25px 30px 25px;

    }

    .login-box-msg {

        font-size: 22px;

    }

    .logo-container {

        width: 105px;

        height: 105px;

    }

}

</style>

</head>


<body class="hold-transition login-page">


<div class="login-box">

    <div class="card">

        <div class="card-body login-card-body">


            <!-- LOGO -->

            <div class="logo-container">

                <img
                    src="golden.png"
                    alt="Arsuento Solutions Logo"
                >

            </div>


            <!-- TITLE -->

            <p class="login-box-msg">

                ENTER YOUR SESSION

            </p>


            <!-- LOGIN FORM -->

            <form action="#" method="post">


                <!-- USERNAME -->

                <div class="input-group">

                    <input
                        type="text"
                        class="form-control"
                        name="username"
                        placeholder="USERNAME"
                        autocomplete="username"
                    >

                    <div class="input-group-append">

                        <div class="input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="input-group">

                    <input
                        type="password"
                        class="form-control"
                        name="userpass"
                        placeholder="PASSWORD"
                        autocomplete="current-password"
                    >

                    <div class="input-group-append">

                        <div class="input-group-text">

                            <span class="fas fa-lock"></span>

                        </div>

                    </div>

                </div>


                <!-- LOGIN BUTTON -->

                <div class="login-button-area">

                    <button
                        type="submit"
                        name="btnLogin"
                        class="btn btn-login"
                    >

                        <i class="fas fa-sign-in-alt"></i>

                        LOG IN

                    </button>

                </div>


            </form>


            <!-- COMPANY -->

            <div class="company-name">

                CANOPIN

                <span>•</span>

                SOLUTIONS

            </div>


        </div>

    </div>

</div>


<!-- jQuery -->

<script src="plugins/jquery/jquery.min.js"></script>


<!-- Bootstrap -->

<script src="<?php echo WEB_ROOT;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- AdminLTE -->

<script src="<?php echo WEB_ROOT;?>dist/js/adminlte.min.js"></script>


</body>
</html>


<?php

/* =====================================================
   LOGIN PROCESS
   ===================================================== */

if(isset($_POST['btnLogin'])){

    $email = trim($_POST['username']);
    $upass = trim($_POST['userpass']);
    $h_upass = sha1($upass);

    /* EMPTY FIELDS */
    if ($email == '' OR $upass == '') {

        message("Invalid Username and Password!", "error");
        redirect("login.php");

    } else {

        /* CREATE USER OBJECT */
        $user = new User();

        /* AUTHENTICATE */
        $res = $user::AuthenticateUser($email, $h_upass);

        /* SUCCESS */
        if ($res == true) {

            if (
                $_SESSION['TYPE'] == 'Administrator' ||
                $_SESSION['TYPE'] == 'Doctor' ||
                $_SESSION['TYPE'] == 'Staff'
            ) {

                ?>
                <script>
                    window.location.href = "index.php";
                </script>
                <?php

            } elseif ($_SESSION['TYPE'] == 'Nurse') {

                ?>
                <script>
                    window.location.href = "module/nurse/dashboard.php";
                </script>
                <?php

            } else {

                echo "
                <script>
                    alert('Account type not authorized.');
                    window.location.href = 'login.php';
                </script>
                ";

            }

        } else {

            echo "
            <script>
                alert('Account does not exist! Contact Administrator.');
                window.location.href = 'login.php';
            </script>
            ";

        }

    }

}

?>