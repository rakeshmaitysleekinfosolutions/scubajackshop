<div class="content container-fluid">
    <form id="frmSignUp" action="<?php echo admin_url('answer/update/'.$primaryKey);?>" method="post">

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
                <h4 class="page-title">Edit Answer</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Answer</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="">
                            <div class="row">

                                <div class="form-group">
                                    <label class="control-label">Question <span class="text-danger">*</span></label>
                                    <select name="question" class="select floating" id="input-quiz" >
                                        <?php if(isset($questions)) {
                                            foreach ($questions as $question) {?>
                                                <option <?php echo ($question->id == $questionId) ? "selected" : "";?> value="<?php echo $question->id;?>"><?php echo $question->question;?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Answer <span class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" name="answer" id="input-question" autocomplete="off" ><?php echo $answer;?></textarea>
                                    <?php if($error_answer) { ?>
                                        <div class="text-danger"><?php  echo $error_answer;?></div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Is Correct <span class="text-danger">*</span></label>
                                    <select name="isCorrect" class="select floating" id="input-isCorrect" >
                                        <option value="0" <?php echo ($isCorrect == 0) ? "selected" : "";?>>NO</option>
                                        <option value="1" <?php echo ($isCorrect == 1) ? "selected" : "";?>>YES</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.filemanager = '<?php echo admin_url('filemanager');?>';
    myLabel.increment = '<?php echo $i;?>';

</script>