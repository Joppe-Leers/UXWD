<a href="<?=base_url()?>/addGroupMembers/<?=$groupID?>/<?=$groupName?>" class="btn btn-lg btn-primary btn-block my-3 w-100" style="max-width:400px">Add friends to <?=$groupName?></a>

<?php foreach ($groupmembers as $member): ?>

    <?php if(session()->get('id') != $member->id): ?>
    <a class="w-100 active" style="color: black;" href="<?=base_url()?>/otheruserprofile/<?= $member->id?>">
    <?php else:?>
    <a class="w-100 active" style="color: black;" href="<?=base_url()?>/profile">
    <?php endif?>
        <div class="card my-2 shadow-sm d-flex flex-row" style="width:100%;max-width:600px">
            <div class="d-flex flex-row">
                <?php if(isset($member->p_imagedata)&&isset($member->p_imagetype)): ?>
                    <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70" style="object-fit: cover;" alt="Bootstrap Image Preview" src="<?='data:' . $member->p_imagetype . ';base64,' . base64_encode($member->p_imagedata)?>">
                <?php else:?>
                    <img class="personCardPhoto card-header ml-1 my-1 p-1 rounded-circle" width = "70" height="70" alt="Bootstrap Image Preview" src="https://eitrawmaterials.eu/wp-content/uploads/2016/09/person-icon.png">
                <?php endif?>
                <h4 class="my-auto m-3"><?= $member->username?></h4>
            </div>
            <a class="delete_friend material-icons my-auto mx-3" href="<?=base_url()?>/deleteUserFromGroup/<?=$member->id?>/<?=$groupID?>/<?=$groupName?>">clear</a>
        </div>
    </a>
<?php endforeach?>

