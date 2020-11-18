<div class="content container-fluid">
<div class="row">
    <?php if(hasMessage('warning')) { ?>
        <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('warning');?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php } ?>
</div>
    <div class="row">
        <div class="col-sm-8">
            <h4 class="page-title">Manage Country Content</h4>
        </div>
        <div class="col-sm-4 text-right m-b-30">
            <button class="btn btn-primary rounded pull-right " id="delete"><i class="fa fa-remove"></i> Delete</button>
            <a href="<?php echo admin_url('countrydescription/create');?>" class="btn btn-primary rounded pull-right"><i class="fa fa-plus"></i> Add</a>
        </div>
    </div>
<?php 
/*
<div class="row filter-row">
    <div class="col-sm-3 col-xs-6">  
        <div class="form-group form-focus">
            <label class="control-label">Client ID</label>
            <input type="text" class="form-control floating" />
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">  
        <div class="form-group form-focus">
            <label class="control-label">Client Name</label>
            <input type="text" class="form-control floating" />
        </div>
    </div>
    <div class="col-sm-3 col-xs-6"> 
        <div class="form-group form-focus select-focus">
            <label class="control-label">Company</label>
            <select class="select floating"> 
                <option value="">Select Company</option>
                <option value="">Global Technologies</option>
                <option value="1">Delta Infotech</option>
            </select>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">  
        <a href="#" class="btn btn-success btn-block"> Search </a>  
    </div>     
</div>
*/?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 2%;">
                            <label class="css-control css-control-primary css-checkbox py-0">
                                <input type="checkbox" class="css-control-input" id="checkAll" name="checkAll">
                                <span class="css-control-indicator"></span>
                            </label>
                        </th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Country</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
</div>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.index   = '<?php echo admin_url('countrydescription/onLoadDatatableEventHandler');?>';
    myLabel.blog   = '<?php echo admin_url('countrydescription/blog/');?>';
    myLabel.status   = '<?php echo admin_url('countrydescription/onClickStatusEventHandler');?>';
    myLabel.delete   = '<?php echo admin_url('countrydescription/delete');?>';
    myLabel.edit    = '<?php echo admin_url('countrydescription/edit/');?>';
</script>