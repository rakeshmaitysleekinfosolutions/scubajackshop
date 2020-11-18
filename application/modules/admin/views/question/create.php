<div class="content container-fluid">
    <form id="frmSignUp" action="<?php echo admin_url('question/store');?>" method="post">

        <div class="row">
            <?php if($error_warning) { ?>
                <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning;?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Add Question</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Question</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Quiz <span class="text-danger">*</span></label>
                                        <select name="quiz" class="select floating" id="input-quiz" >
                                            <?php if(isset($quizzes)) {
                                                foreach ($quizzes as $quiz) {?>
                                                    <option value="<?php echo $quiz->id;?>"><?php echo $quiz->name;?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Question <span class="text-danger">*</span></label>
                                            <input value="<?php echo $question;?>" class="form-control" type="text" name="question" id="input-question" autocomplete="off" >
                                            <?php if($error_question) { ?>
                                                <div class="text-danger"><?php  echo $error_question;?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="select floating" id="input-payment-status" >
                                            <option value="0" <?php echo ($status == 0) ? 'selected' : '';?>>Inactive</option>
                                            <option value="1" <?php echo ($status == 1) ? 'selected' : '';?>>Active</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Question Images</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">Image</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left"><a href="javascript:void(0);"  type="image" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a> <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <?php
                    /*
                    <div class="table-responsive">
                        <table id="images" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-left">Images</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $imageRow = 0;
                            if($images) {
                                foreach ($images as $image) {?>
                                <tr id="image-row<?php echo $imageRow;?>">
                                    <td class="text-left"><a href="" id="thumb-image<?php echo $imageRow;?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $image['thumb'];?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>>"/></a> <input type="hidden" name="images[<?php echo $imageRow;?>>][image]" value="<?php echo $image['thumb'];?>" id="input-image<?php echo $imageRow;?>>"/></td>
                                    <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $imageRow;?>').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                </tr>
                                <?php } ?>
                            <?php $imageRow++; } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    */?>
                </div>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.filemanager = '<?php echo admin_url('filemanager');?>';
    myLabel.imageRow = '<?php $imageRow;?>';

</script>