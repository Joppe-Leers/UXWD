
    <div>
        <ul class="list-group my-3">
            <?php if(isset($name_first)):?>
            <a class="w-100 active" href="<?= base_url()?>/otheruserprofile/<?= $id_first?>">
                <li href="#" class="list-group-item list-group-item-action d-flex justify-content-between bg-third">
                        <h5 class="mb-0">1. <?=$name_first?></h5>
                        <h5 class="mb-0"><?=$points_first?></h5>
                </li>
            </a>
            <?php endif?>
            <?php if(isset($name_second)):?>
            <a class="w-100 active" href="<?= base_url()?>/otheruserprofile/<?= $id_second?>">
                <li href="#" class="list-group-item list-group-item-action d-flex justify-content-between bg-secondary">
                    <h5 class="mb-0">2. <?=$name_second?></h5>
                    <h5 class="mb-0"><?=$points_second?></h5>
                </li>
            </a>
            <?php endif?>
            <?php if(isset($name_third)): ?>
            <a class="w-100 active" href="<?= base_url()?>/otheruserprofile/<?= $id_third?>">
                <li href="#" class="list-group-item list-group-item-action d-flex justify-content-between bg-third">
                    <h5 class="mb-0">3. <?=$name_third?></h5>
                    <h5 class="mb-0"><?=$points_third?></h5>
                </li>
            </a>
            <?php endif?>
        </ul>
    </div>

<ul class="list-group my-3">
    <?php $loopcounter = 0;?>
    <?php foreach ($persons_list as $person): ?>
        <a class="w-100 active" href="<?= base_url()?>/otheruserprofile/<?= $person['id']?>">
            <li href="#" class="list-group-item list-group-item-action d-flex justify-content-between bg-secondary">
                <h5 class="mb-0"><?=$person['place']?>. <?=$person['name']?></h5>
                <h5 class="mb-0"><?=$person['point']?></h5>
            </li><?php $loopcounter++;?>
        </a>
        <?php if ($loopcounter == 7) break;?>
    <?php endforeach; ?>
    <?=$user_placeholder?>
</ul>