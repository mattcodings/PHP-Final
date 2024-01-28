<?php
include 'includes/header.php';
?>
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
    <p>Already have an account? <a href="login.php">Log In Here</a></p>
</div>