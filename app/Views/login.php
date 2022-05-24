<h1 class="text-center pt-5 mt-5 mb-5">snAPP Nature</h1>
<?php if (session()->get('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>
<form class="form" action="login" method="post">
    <?= csrf_field() ?>
    <div class="form-group mb-1">
        <label for="inputEmail"><?php echo lang('app.Email_address') ?></label>
        <input type="email" id="inputEmail" class="form-control" name="email" required autofocus>
    </div>

    <div class="form-group mb-1">
    <label for="inputPassword"><?php echo lang('app.Password') ?></label>
    <input type="password" id="inputPassword" class="form-control" name="password" required>
    </div>

    <div class="d-flex justify-content-between">

        <a class="text-info text-left w-100 mb-3 h6" href="forgotPassword"><?php echo lang('app.Forgot_password?') ?></a>
        <a class="text-info text-right w-100 mb-3 h6" href="register"><?php echo lang('app.Register') ?></a>
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
    <button onclick="location.href='hub'" class="btn btn-lg btn-primary btn-block mt-5" type="submit"><?php echo lang('app.Log_in') ?></button>
</form>

<hr class="mt-2 mb-3 my-3"/>
<button onclick="location.href='addObservationWithoutLogin'" class="btn btn-lg btn-primary btn-block mt-1" type="submit"><?php echo lang('app.Make_an_observation') ?></button>






