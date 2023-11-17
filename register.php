<?php
require('./header.php');
require('./validate-sanitize/sanitize.php');
?>
<main>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <div>
            <label for="email">Email*</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="password">Password*</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2">Password Verification*</label>
            <input type="password" name="password2" id="password2">
        </div>

        <button type="submit">New account</button>

    </form>
</main>
<footer>Already a member? <a href="./login.php">Login here</a></footer>
</body>

</html>