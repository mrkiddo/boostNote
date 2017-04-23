<div class="wrapper">
    <form action="<?php echo $loginPath; ?>" method="POST">
        <div class="input-item">
            <label for="login-email">Email</label>
            <input type="email" name="email" id="login-email">
        </div>
        <div class="input-item">
            <label for="login-password">Password</label>
            <input type="password" name="pwd" id="login-password">
        </div>
        <div class="input-item">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>