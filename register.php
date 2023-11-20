<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <title>SignUp</title>
</head>

<body>
    <?php
    require('./header.php');
    require('./validate-sanitize/sanitize.php');
    ?>
    <main>
        <form action="register.php" method="post">
            <h1>Register</h1>
            <div>
                <label for="username">Email*</label>
                <input type="text" name="username" id="username"><span class="error"><?php display_error('username') ?></span>
            </div>
            <div>
                <label for="password">Password*</label>
                <input type="password" name="password" id="password"><span class="error"><?php display_error('password') ?></span>
            </div>
            <div>
                <label for="password2">Password Verification*</label>
                <input type="password" name="password2" id="password2"><span class="error"><?php display_error('password2') ?></span>
            </div>

            <button type="submit" name="submitBtn">New account</button>

        </form>
    </main>
    <footer>Already a member? <a href="./login.php">Login here</a></footer>
</body>

</html>