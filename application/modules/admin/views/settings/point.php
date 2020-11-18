<div class="content container-fluid">
    <form id="frm" action="" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
               
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form>
                        <h3 class="page-title">Points</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Each field trip point <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="Focus Technologies">
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>

    </form>
</div>

<script>
    var myLabel             = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
</script>