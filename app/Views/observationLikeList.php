<ul class="list-group my-3">

<?php foreach ($like_list as $like): ?>
    <li class="list-group-item list-group-item-action justify-content-start bg-secondary">
        <img class="rounded-circle img-circle"  alt="templatemo easy profile" style="width: 50px; height: 50px;" src="<?=$like['pic']?>">
        <p class="font-weight-bold d-inline font-light ml-1 mt-0 mb-0"><?=$like['username']?></p>
    </li>
<?php endforeach; ?>

</ul>
