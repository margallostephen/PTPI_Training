<?php
include '../../includes/path.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $redirectTo = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "/$systemFolder/pages/dashboard";
    header("Location: $redirectTo");
    exit();
}
?>

<?php include_once '../../includes/header.php'; ?>

<style>
    body#login-body {
        background-image: url('../../images/prima-bg.jpg');
        background-size: cover;
        background-position: bottom;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-responsive {
        margin-bottom: 25px;
    }

    .container.login {
        padding: 10px 5px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 2px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
        width: 100%;
        max-width: 400px;
    }

    #loginBtn {
        margin-top: 20px;
    }
</style>

<body id="login-body">
    <div class="container login">
        <div class="login-container">
            <div class="login-box">
                <img src="../../images/prima-logo.png" alt="prima logo" class="img-responsive center-block">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="user">Email | Username | ID</label>
                        <input type="text" id="user" class="form-control"
                            placeholder="Enter your username, email, or ID">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter your password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" id="loginBtn">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../auth/ajax/loginUser.js<?php echo randomNum() ?>"></script>
</body>