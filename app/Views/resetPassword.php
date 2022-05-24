<h1 class="text-center"><?php echo lang('app.Reset_Password') ?></h1>
<?php  $uri = service('uri'); ?>

<form class="form" action='<?= base_url()?>/resetPassword/<?=session()->get('id')?>' method="post">
    <?= csrf_field() ?>
    <div class="form-group mb-1">
    <label for="newPassword"><?php echo lang('app.New_Password') ?></label>
    <input type="password" id="newPassword" class="form-control" placeholder="" name="newPassword" required autofocus>
    </div>

    <div class="form-group mb-1">
    <label for="password_confirm"><?php echo lang('app.Confirm_New_Password') ?></label>
    <input type="password" id="password_confirm" class="form-control" placeholder="" name="password_confirm" required>
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
    <button class="btn btn-lg btn-primary btn-block mt-5" type="submit"><?php echo lang('app.Create_a_new_password') ?></button>
</form>
<button onclick=location.href='<?= base_url()?>/resetPassword/<?=session()->get('id')?>' class="btn btn-lg btn-primary w-100 my-4" type="submit"><?php echo lang('app.Cancel') ?></button>