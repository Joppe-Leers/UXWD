<?php if (count($requests)): ?>
<h4><?php echo lang('app.Friend_request') ?></h4>
<?php endif;?>
<?php foreach ($requests as $r): ?>
<a class="w-100 active" style="color: black;" href="<?=$base_url?>/otheruserprofile/<?= $r->userID?>">
    <div class="card my-2 shadow-sm d-flex flex-row" style="width:100%;max-width:600px">
        <div class="ml-3 mr-auto my-2">
            <h4><?= $r->username?></h4>
        </div>
        <div class="d-flex flex-row" value="<?= $r->mappingID?>">
            <a type="button" class="accept_friend material-icons my-auto mx-3" style="font-size: 40px" >check</a>
            <a type="button" class="decline_friend material-icons my-auto mx-3" style="font-size: 40px">clear</a>
        </div>
    </div>
</a>
<?php endforeach?>
<?php if (count($requests)): ?>
<h4><?php echo lang('app.Friend_List') ?></h4>
<?php endif;?>

<?php foreach ($friends as $f): ?>
<a class="w-100 active" style="color: black;" href="<?=$base_url?>/otheruserprofile/<?= $f->id?>">
    <div class="card my-2 shadow-sm d-flex flex-row" style="width:100%;max-width:600px">
        <div class="d-flex flex-row">
            <?php if(isset($f->p_imagedata)&&isset($f->p_imagetype)): ?>
                <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70" style="object-fit: cover;" alt="Bootstrap Image Preview" src="<?=$f->encoded_image; ?>">
            <?php else:?>
                <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70" alt="Bootstrap Image Preview" src="https://eitrawmaterials.eu/wp-content/uploads/2016/09/person-icon.png">
            <?php endif?>
            <h4 class="my-auto m-3"><?= $f->username?></h4>
        </div>
        <a type="button" class="delete_friend material-icons my-auto mx-3" value="<?= $f->mappingID?>" style="font-size: 40px;">clear</a>
    </div>
</a>
<?php endforeach?>

