<?php
//dd($_SESSION);
?>
<div class="content container-fluid" id="my-container">
    <form id="frm" action="<?php echo admin_url('resetpassword/updatePassword');?>" method="post">
        <input type="hidden" name="userId" value="<?php echo getSession('sess_data')['id'];?>">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-sm-8">
<!--                <h4 class="page-title">Add Features Product</h4>-->
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo (isset($back)) ? $back : '';?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card-box">
                    <h3 class="card-title">Reset Password</h3>
                    <div class="experience-box">
                        <div class="form-group">
                            <label>Old password</label>
                            <input id="input-old" name="old" type="password" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>New password</label>
                            <input id="input-password" name="password" type="password" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input id="input-confirm" name="confirm" type="password" class="form-control" required/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>

    </form>
</div>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';

</script>