<ul class="list-group my-3">
<?php foreach ($comment_list as $comment): ?>
    <li class="list-group-item list-group-item-action justify-content-start bg-secondary">
        <div class="row">
            <p class="font-weight-bold d-inline font-light ml-3 mr-1 mt-0 mb-0"> <?=$comment['username']?>: </p>
            <p class="d-inline font-light mt-0 mb-0"> <?=$comment['message']?> </p>
        </div>
    </li>
<?php endforeach; ?>
</ul>
