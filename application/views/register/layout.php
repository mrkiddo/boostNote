<div class="wrapper">
    <form action="<?php echo $registerPath ?>" method="POST">
        <div class="input-item">
            <label for="register-email">Email</label>
            <input type="email" name="email" id="register-email" class="email">
        </div>
        <div class="input-item">
            <label for="register-first-name">First Name</label>
            <input type="text" name="first_name" id="register-first-name" class="first-name">
        </div>
        <div class="input-item">
            <label for="register-last-name">Last Name</label>
            <input type="text" name="last_name" id="register-last-name" class="last-name">
        </div>
        <div class="input-item">
            <label for="register-password">Password</label>
            <input type="password" name="pwd" id="register-password" class="password">
        </div>
        <div class="input-item">
            <label for="register-password-confirm">Confirm Password</label>
            <input type="password" id="register-password-confirm" class="password-confirm">
        </div>
        <div class="input-item">
            <input type="submit" value="Submit" class="submit">
        </div>
    </form>
</div>