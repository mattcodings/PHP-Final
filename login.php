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
                            header('Location: index.php');
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
                    header("Location: index.php");
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
            <p>Don't have an account? <a href="sign-up.php">Sign Up Here</a></p>
        </div>

    </section>
<?php
include "includes/footer.php";
?>