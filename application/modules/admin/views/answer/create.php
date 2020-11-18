<div class="content container-fluid">
    <form id="frmSignUp" action="<?php echo admin_url('answer/store');?>" method="post">

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
                <h4 class="page-title">Add Answer</h4>
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

                                <div class="form-group">
                                    <label class="control-label">Question <span class="text-danger">*</span></label>
                                    <select name="question" class="select floating" id="input-quiz" >
                                        <?php if(isset($questions)) {
                                            foreach ($questions as $question) {?>
                                                <option value="<?php echo $question->id;?>"><?php echo $question->question;?></option>
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
                                        <option value="0" <?php echo ($isCorrect === 0) ? "selected" : "";?>>NO</option>
                                        <option value="1" <?php echo ($isCorrect === 1) ? "selected" : "";?>>YES</option>
                                    </select>
                                </div>
                                <div class="table-responsive">
                                    <table id="answers" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>

                                            <td class="text-left">Additional Answer</td>
<!--                                            <td class="text-left">Is Correct</td>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        if($answers) {
                                            foreach ($answers as $answer) {?>
                                                <tr id="image-row<?php echo $i?>">

                                                    <td class="text-left"><textarea class="form-control" type="text" name="answers[<?php echo $i?>>][answer]" id="input-answer" autocomplete="off" ><?php echo $answer['text'];?></textarea></td>
                                                    <td>
                                                        <select name="answers[<?php echo $i?>>][is_correct" class="select floating" id="input-is_correct" >
                                                            <option value="0" <?php echo ($answer === 0) ? "selected" : "";?>>NO</option>
                                                            <option value="1" <?php echo ($answer === 1) ? "selected" : "";?>>YES</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-left"><button type="button" onclick="$('#answers-row<?php echo $i;?>').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                </tr>
                                            <?php } ?>
                                            <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-left"><button type="button" id="addAnswerButton" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        </tfoot>
                                    </table>
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