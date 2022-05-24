<div id="preloader">
    <div id="status">
    </div>
</div>
<div class="py-4 container-fluid w-100 pt-5" style="width: 400px; font-size: 1.5rem">

    <div class="wrapper card w-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <div class="previewImage" id="previewImageDiv">
            <img class="img-fluid" id="uploadImageTag" src=""/>
        </div>
        <div class="content d-flex flex-column align-items-center">
            <div class="material-icons" id="backupIcon" style="font-size:40px;color: #25AC71;">backup</div>
            <div class="text" id="noFileText"><?php echo lang('app.No_picture_made,_yet!') ?></div>
        </div>
    </div>

    <button class="btn btn-primary w-100 my-3" id="takePictureButton"><h4><?php echo lang('app.Take_picture') ?></h4></button>
    <div id="processingText">
        <h2 hidden><?php echo lang('app.Processing...') ?></h2>
    </div>
    <?php if(session()->get("isLoggedIn")): ?>
    <form action="addObservation" method="post" enctype="multipart/form-data">
        <?php else:?>
        <form action="login" method="get" enctype="multipart/form-data">
            <?php endif?>
            <input id="inputFile" type="file" name="picture" onchange="getUploadedPicture(this)" hidden>



            <div class="d-flex flex-row mt-0 w-100">
                <div id="probabilityText"><?php echo lang('app.Probability') ?>: </div>
                <div class="font-weight-bold" id="probability"></div>
            </div>

            <div class="txt_field mt-3">
                <label class="mb-0"><?php echo lang('app.Plant_name') ?></label>
                <span></span>
                <input readonly type="text" class="form-control" id="speciesNamePlaceholder" name="specieName" required value="<?= set_value('scientificName')?>">
            </div>

            <div class="txt_field">
                <label class="mb-0"><?php echo lang('app.Scientific_name') ?></label>
                <span></span>
                <input readonly type="text" class="form-control" id="scientificNamePlaceholder" name="scientificName" required value="<?= set_value('specieName')?>">
            </div>

            <div class="txt_field mt-3">
                <label class="mb-0"><?php echo lang('app.Description') ?></label>
                <span></span>
                <textarea type="text" class="form-control mt-0" style="min-height: 120px;" id="DescriptionPlaceholder" name="description" required value="<?= set_value('description')?>"></textarea>
            </div>


        </form>
        <button onclick=location.href='addObservationWithoutLogin' class="btn btn-primary w-100 my-2 mt-3" style="font-size:25px" ><?php echo lang('app.Create_Another_Observation') ?></button>
        <hr class="mt-2 mb-3 my-3"/>
        <button onclick=location.href='login' class="btn btn-primary w-100 my-2 mt-3" style="font-size:25px" ><?php echo lang('app.Back_to_log_in') ?></button>
</div>
