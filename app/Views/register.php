<h1 class="text-center mb-5"><?php echo lang('app.Register') ?></h1>

<form class="form" action="register" method="post"  autocomplete="on">
    <?= csrf_field() ?>
    <div class="form-group mb-1">
        <label for="username"><?php echo lang('app.Username') ?></label>
        <input type="txt" class="form-control" name="username" value="<?= set_value('username')?>">
    </div>

    <div class="form-group mb-1">
        <label for="email"><?php echo lang('app.Email') ?></label>
        <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email')?>" />
    </div>

    <div class="form-group mb-1">
        <label for="password"><?php echo lang('app.Password') ?></label>
        <input type="password" class="form-control" name="password">
    </div>

    <div class="form-group mb-5">
        <label for="password_confirm"><?php echo lang('app.Confirm_Password') ?></label>
        <input type="password" class="form-control" name="password_confirm">
    </div>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger" role="alert">
            <?= \Config\Services::validation()->listErrors(); ?>
        </div>
    <?php endif; ?>

    <div>
        <input type="submit" name="submit" class="btn btn-lg btn-primary w-100" value="<?php echo lang('app.Create_your_account') ?>" />
    </div>
    <a class="text-info" href="login"><?php echo lang('app.Already_have_an_account?') ?></a>
</form>

