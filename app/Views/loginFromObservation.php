<div class="addObservationContainer">
    <div style="text-align:center">
        <br/>
        <br/>
        <h1>Welcome snAPP</h1>
        <br/>
        <br/>
        <div>
            <span style="font-size: 200px" class="material-icons"> account_box </span>
            <form method="post">
                <div class="txt_field">
                    <input type="text" name="Username/email">
                    <span></span>
                    <label><?php echo lang('app.Email') ?>:</label>
                </div>

                <div class="txt_field">
                    <input type="text" name="Password" required>
                    <span></span>
                    <label><?php echo lang('app.Password') ?>:</label>
                </div>
            </form>
            <div>
                <button id="custom-btn"><?php echo lang('app.Log_in') ?></button>
                <button id="custom-btn"><?php echo lang('app.New_User?') ?></button>
            </div>
        </div>
        <button id="custom-btn"><?php echo lang('app.Cancel') ?> </button>
    </div>
</div>