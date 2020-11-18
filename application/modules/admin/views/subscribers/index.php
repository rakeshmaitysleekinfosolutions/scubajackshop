<div class="content container-fluid">
    <div class="row">
        <?php if(hasMessage('warning')) { ?>
            <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i><?php echo getMessage('warning');?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="col-sm-4 col-xs-3">
            <h4 class="page-title">Subscribers</h4>
        </div>
        <div class="col-sm-8 col-xs-9 text-right m-b-20">
            <button class="btn btn-primary rounded pull-right " id="delete"><i class="fa fa-trash"></i> Delete</button>

        </div>
    </div>
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
                        <th>User</th>
                        <th>Plan</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Created At</th>
<!--                        <th class="text-right">Action</th>-->
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl     = '<?php echo base_url();?>';
    myLabel.index       = '<?php echo admin_url('subscribers/onLoadDatatableEventHandler');?>';
    myLabel.delete      = '<?php echo admin_url('subscribers/delete');?>';
</script>