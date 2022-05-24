
<div id="preloader">
    <div id="status">
    </div>
</div>
<input type="hidden" id="hidden_variable_filter" value="<?=$leaderboard_filter?>"/>
<div id="leaderboard_overall_container" class="jumbotron w-100" style ="background:transparent !important; max-width: 400px;">
    <h3 class="page_title d-flex justify-content-center"><?=$leaderboard_filter?></h3>
    <div id="radio_buttons_container" class=" d-flex justify-content-center">
            <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="weekly" value="weeklyPoints" type="radio"><?php echo lang('app.Daily') ?></button>
            <button class="active btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="monthly" value="monthlyPoints" type="radio"><?php echo lang('app.Monthly') ?></button>
            <button class="btn btn-primary btn-block mr-1 ml-1 my-3" name="size" id="overall" value="points" type="radio"><?php echo lang('app.Yearly') ?></button>
    </div>
    <div id="leaderboard_container">
        <?=$leaderboard_content?>
    </div>
</div>



