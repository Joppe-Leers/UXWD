<h5><?php echo lang('app.Users') ?>:</h5>
<?php foreach ($user as $u): ?>
<a class="w-100 active" style="color: black;" href="<?=base_url()?>/otheruserprofile/<?= $u->id?>">
    <div class="card my-2 shadow-sm d-flex flex-row" style="width:100%;max-width:600px">
        <?php if(isset($u->p_imagedata)&&isset($u->p_imagetype)): ?>
            <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70"  style="object-fit: cover;" alt="Bootstrap Image Preview" src="<?=$u->encoded_image; ?>">
        <?php else:?>
            <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70" alt="Bootstrap Image Preview" src="https://eitrawmaterials.eu/wp-content/uploads/2016/09/person-icon.png">
        <?php endif?>
        <h4 class="my-auto m-3"><?= $u->username?></h4>
    </div>
</a>
<?php endforeach?>