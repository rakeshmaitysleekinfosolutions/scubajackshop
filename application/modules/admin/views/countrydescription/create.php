<div class="content container-fluid">
    <form id="frmSignUp" action="<?php echo admin_url('countrydescription/store');?>" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Add Country Content</h4>
            </div>

            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
            <div class="card-box m-b-0">
                <h3 class="card-title">Image</h3>
                <div class="skills">
                        <div class="">
                            <a href="javascript:void(0);" type="image" href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                            <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/>
                        </div>
                </div>
            </div>
        </div>
            <div class="col-md-9">
            <div class="card-box">
                <h3 class="card-title">Country Description</h3>
                <div class="experience-box">
                    <div class="form-group">
                        <label class="control-label">Country <span class="text-danger">*</span></label>
                        <select name="country" class="select floating" id="input-country>
                            <?php if(!empty($countries)) {
                                foreach ($countries as $country) {?>
                                    <option value="<?php echo $country->id;?>" ><?php echo $country->name;?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Title <span class="text-danger">*</span></label>
                        <input value="<?php echo $title;?>" id="input-title" name="title" type="text" class="form-control" placeholder="" >
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" cols="5" class="form-control summernote" placeholder="Enter your message here"><?php echo $description;?></textarea>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </form>
</div>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.filemanager = '<?php echo admin_url('filemanager');?>';
</script>