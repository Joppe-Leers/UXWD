<h1 class="text-center"><?php echo lang('app.Forgot_password?') ?></h1>

<form class="form" action="forgotPassword" method="post">
    <?= csrf_field() ?>
    <div class="form-group mb-1">
    <label for="email"><?php echo lang('app.Email_address') ?></label>
    <input type="email" id="email" class="form-control" name="email" required autofocus>
    </div>

    <div class="form-group mb-1">
    <label for="username"><?php echo lang('app.Username') ?></label>
    <input type="text" id="username" class="form-control" name="username" required>
    </div>

    <?php if ( isset($validation)): ?>
        <div class="alert alert-danger" role="alert">
            <?= \Config\Services::validation()->listErrors(); ?>
        </div>
    <?php endif; ?>
    <?php if ( isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_message?>
        </div>
    <?php endif; ?>

    <button class="btn btn-lg btn-primary btn-block my-3" type="submit"><?php echo lang('app.Create_a_new_password') ?></button>
</form>