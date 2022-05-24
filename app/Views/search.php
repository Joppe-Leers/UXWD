
<div class="input-group my-3">
    <div    class="input-group-prepend">
        <button class="btn btn-primary  btn-block material-icons ">search</button>
    </div>
    <input type="text" id="search" name="search" class="form-control" placeholder="<?php echo lang('app.Search') ?>...">
</div>

<h6 class="mb-0" style="width:100%;max-width:600px"><?php echo lang('app.Search_on') ?>:</h6>
<div id="radio_buttons_container" class=" d-flex justify-content-center" style="width:100%;max-width:600px">
    <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="All" value="points" type="radio"><?php echo lang('app.All') ?></button>
    <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="Observations" value="weeklyPoints" type="radio"><?php echo lang('app.Observations') ?></button>
    <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="Groups" value="monthlyPoints" type="radio"><?php echo lang('app.Groups') ?></button>
    <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="Users" value="points" type="radio"><?php echo lang('app.Users') ?></button>
</div>
<div id="search_result_container" style="width:100%;max-width:600px">
    <div id="placeholder_search_message"><?=$placeholder?></div>
    <div id="observations_container"></div>
    <div id="groups_container"></div>
    <div id="users_container"></div
</div>

