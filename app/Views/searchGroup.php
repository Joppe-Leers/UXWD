<h5><?php echo lang('app.Groups') ?>:</h5>
<?php foreach ($group as $g): ?>
    <div class="card my-2 shadow-sm" style="width:100%;max-width:600px">
        <a class="w-100 "  style="color:black" href="<?=base_url()?>/group/<?=$g->name?>">
            <div  class="d-flex flex-row">
                <div class="ml-3 mr-auto mb-2 mt-3">
                    <h3 class="font-light"><?= $g->name?></h3>
                    <p class="mb-1"><?=$g->description?></p>
                </div>
                <span class="material-icons my-auto mx-3" style="font-size: 40px">navigate_next</span>
            </div>
        </a>
        <a class="px-3 pb-3" href="<?=base_url()?>/groupmembers/<?=$g->name?>"><?php echo lang('app.members') ?></a>
    </div>
<?php endforeach?>

