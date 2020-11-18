<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('country/update/'.$id);?>" method="post">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('message');?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h4 class="page-title">Edit Country</h4>
            </div>
            <div class="col-sm-4 text-right m-b-30">
                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Save</button>
                <a href="<?php echo $back;?>" class="btn btn-primary rounded"><i class="fa fa-back"></i> Back</a>
            </div>
        </div>
        <div class="card-box">
            <h3 class="card-title">Country</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label">Select Continent <span class="text-danger">*</span></label>
                                    <select name="continent_id" class="select floating" id="input-continent_id" required>
                                        <?php if($continents) {
                                            foreach ($continents as $continent) { ?>
                                                <option value="<?php echo $continent->id;?>" <?php echo ($continent->id == $continent_id) ? "selected" : "" ?>><?php echo $continent->name;?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" id="input-name" autocomplete="off" value="<?php echo $name;?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Iso Code <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="iso_code_2" id="input-iso_code_2" autocomplete="off" value="<?php echo $iso_code_2;?>" required>
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
</script>