<?php
require('./header.php');
require('./sanitize.php');
?>

<main>
    <form action="login.php" method="post">
        <h1>My Account</h1>
        <div>
            <label for="email">Email*</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password*</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Connexion</button>
    </form>
</main>
</body>

</html>