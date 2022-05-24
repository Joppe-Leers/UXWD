<h5><?php echo lang('app.Observations') ?>:</h5>
<?php foreach ($ob as $o): ?>
    <div>

        <div class="card my-2 shadow-sm mb-3" style="width:100%;max-width:600px">
            <input type = "hidden" name="obID" id = "obID" value = "<?=$o->id?>">
            <input type = "hidden" name="username" id = "username" value = "<?=$o->username?>">
            <a href="<?= base_url()?>/anobservation/<?=$o->id?>">
                <div style="position: relative;">
                    <img class="card-img img-fluid" style="height: 350px; object-fit: cover;" id="observationCardPicture" src="<?= $o->encoded_image ?>" alt="observation picture">
                    <div class="card-img" style="box-shadow: inset 0 -50px 40px -20px black;position: absolute; width: 100%; height: 100%;top: 0; left: 0;"></div>
                    <h4 class="text-white" style="position: absolute; bottom: 0; right: 12px;"><?=$o->username?></h4>
                    <span class="material-icons text-white" style="font-size:30px;position: absolute; bottom: 6px; left: 8px" >favorite</span>
                </div>
            </a>

            <div class="card-body pt-2 pb-0">
                <div class=" d-flex flex-row py-1">
                    <div class="mr-auto">
                        <h5 class="mb-0"><?=$o->specieName?></h5>
                    </div>
                </div>
                <hr class="mt-0 mb-2">
                <div class="my-2">
                    <p class="font-light small mb-1"><?=$o->date?> at <?=$o->time?></p>
                </div>
            </div>

            <div id="dateObject" hidden><?=$o->date?></div>

        </div>

    </div>
<?php endforeach?>