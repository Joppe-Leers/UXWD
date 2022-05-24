<?php if (count($friends) == 0):?>
<div id="selectFriendToAdd"><?php echo lang('app.You_have_no_more_friends_to_add_to') ?> <a href="<?=base_url()?>/group/<?=$groupName?>"><?=$groupName?></a></div>
<?php else:; ?>
<div id="selectFriendToAdd"><?php echo lang('app.Select_friends_to_add_to') ?> <a href="<?=base_url()?>/group/<?=$groupName?>"><?=$groupName?></a></div>
<?php endif;?>

<script type="text/javascript">
    let php_groupName = "<?php echo $groupName; ?>";
</script>

<ul class="list-group w-100" id="list-tab" id="myList" role="tablist" style="max-width:400px">
    <?php foreach ($friends as $f): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center" value="<?=$f->username?>" id="listItem">
            <div id="friendName"><?=$f->username?></div>

            <?php $userName = strval($f->username);?>

            <button id="addButton" class="btn badge badge-primary badge-pill"><?php echo lang('app.Add') ?></button>
        </li>
<?php endforeach?>
</ul>
