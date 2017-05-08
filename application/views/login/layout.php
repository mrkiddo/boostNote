<div class="wrapper">
    <span><?php if(isset($error)): echo $error; endif; ?></span>
    <form action="<?php echo SITE_URL.'/user/login' ?>" method="POST">
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