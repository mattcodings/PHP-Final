<?php
include 'includes/header.php';
?>
<section class="auth-section">

    <div class="col-md-3 login-section">
        <div>
        <h3 class="login-title">Login</h3>
        <?php
        if (isset($_POST['login'])) {
            // get form values
            $email = $_POST['email'];
            $password = $_POST['password'];

            // TODO: get user record from database and check login
            $query = "SELECT email, password, role FROM foodAuthUsers WHERE email = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_bind_result($stmt, $email, $hashed_password, $role);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_fetch($stmt);

            if($email && $hashed_password){
                if(password_verify($password, $hashed_password)){
                    if(password_needs_rehash($hashed_password, PASSWORD_DEFAULT)){
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    }
                    // password was correct, store the login in the session
                    $_SESSION['foodAuthUser']['email'] = $email;
                    $_SESSION['foodAuthUser']['role'] = $role;

                    // redirect to the secure page
                    header('Location: menu.php');
                }
            }

            // email / password was incorrect
            echo '<div class="alert alert-danger">Email or password was incorrect.</div>';
        }

        // logout and redirect to login page
        if (isset($_GET['logout'])) {
            // remove session data
            unset($_SESSION['foodAuthUser']);

            // destroy the session (and cookie)
            // session high-jacking can occur if session and cookie are not destroyed
            session_destroy();

            // redirect
            header("Location: login.php");
        }

        ?>
        <?php if (isset($_SESSION['foodAuthUser'])): ?>
            <form method="get">
                <input type="submit" name="logout" class="btnSubmit" value="Log Out">
            </form>
        <?php else: ?>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                     </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>

                <div class="form-group">
                    <input type="submit" name="login" class="btnSubmit" value="Login">
                </div>
            </form>
        <?php endif; ?>
    </div>
    </div>
    <div class="col-md-3 login-section">
        <h3>Sign Up</h3>
        <?php
        $accountCreated = false;
        if (isset($_POST['signup'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = 'user';

//        validate email and password

//        encrypt password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO `foodAuthUsers` 
    (`id`, `email`, `password`, `role`) 
    VALUES 
    (NULL, ?, ?, ?);";

            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "sss", $email, $hashed_password, $role);
            mysqli_stmt_execute($stmt);
            if(mysqli_insert_id($db)){
                $accountCreated = true;
                echo '<div class="alert alert-success">
<b>Account Created!</b><br>Please log in.</div>';
            }else {
                echo '<div class="alert alert-danger">
                          <b>Error creating account!</b><br> (Tell the user what to do...email already used?)
                        </div>';
            }
        }
        ?>
        <?php if (!$accountCreated): ?>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Your Email *" value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Your Password *"
                           value="">
                </div>
                <div class="form-group">
                    <input type="submit" name="signup" class="btnSubmit" value="Sign Up">
                </div>
            </form>
        <?php endif; ?>
    </div>
    </section>
<?php
include "includes/footer.php";
?>