<div>
    <div class="d-flex flex-row my-4">
        <?php if(isset($profile_image)): ?>
            <img src="<?=$profile_image?>" class="rounded-circle img-circle"  alt="templatemo easy profile">
        <?php else:?>
            <img class="rounded-circle card-header img-circle" src="https://eitrawmaterials.eu/wp-content/uploads/2016/09/person-icon.png">
        <?php endif?>
        <h3 id="observation_profileName" class="my-auto mx-4"><?=$username?></h3>
    </div>

    <div id="observation_title_description">
        <h2><?=$specie_name?></h2>
        <p><?=$user_note?></p>
    </div>

    <img class="img-fluid" id="observation_picture" src="<?=$encoded_image?>" alt="picture of the observation">
    <div class="d-flex flex-row py-4 justify-content-center">
        <div class="information_container mx-auto">
            <span class="material-icons">event_note</span>
            <p><?=$date?></p>
        </div>
        <div class="information_container mx-auto">
            <span class="material-icons">schedule</span>
            <p><?=$time?></p>
        </div>
        <div class="information_container mx-auto">
            <span class="material-icons">location_on</span>
            <p id="observation_location"><?=$location?></p>


        </div>
    </div>

    <div id="map" class="jumbotron" style="height: 200px" ></div>
    <div>
        <h2  ><?php echo lang('app.Description') ?></h2>
        <p type="button" onclick=show() id="expand"  style="display: block;width: 300px;overflow: hidden; white-space: nowrap;text-overflow: ellipsis;"><?=$description?></p>
        <p type="button" onclick=show() id="expand1" style="display: none" ><?=$description?></p>
    </div>
    <div id="like_and_comment_button " class="d-flex justify-content-center"  >
        <div id="like_button" class=" btn btn-primary btn-block w-10  my-3 mr-1">
            <label>show likes: <?=$likeCount[0]->likeCount?></label>
        </div>
        <div id="comment_button" class="btn btn-primary btn-block w-10 my-3 ml-1">
            <label>show comments: <?=$commentCount[0]->commentCount?></label>
        </div>
    </div>
    <hr>
    <div id="likes_or_comment_placeholder">
        <?=$likes_comments?>
    </div>
</div>

<input type="hidden" id="hidden_variable_filter" value="<?=$id?>"/>
<script>
    function show()
    {
        if(document.getElementById('expand').style.display == 'block')
    {
        document.getElementById('expand1').style.display = 'block';
        document.getElementById('expand').style.display = 'none';
    }else
    {
        document.getElementById('expand').style.display = 'block';
        document.getElementById('expand1').style.display = 'none';

    }
    }
</script>