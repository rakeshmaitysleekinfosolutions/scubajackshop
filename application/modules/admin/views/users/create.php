<div class="content container-fluid">
<div class="row">
    <div class="col-sm-4 col-xs-3">
        <h4 class="page-title"></h4>
    </div>
    <div class="col-sm-8 col-xs-9 text-right m-b-20">
        <a href="javascript:history.go(-1)" class="btn btn-primary rounded pull-right"><i class="fa fa-back"></i> Back</a>
        <!-- <div class="view-icons">
            <a href="clients.html" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
            <a href="clients-list.html" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
        </div> -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    <form id="frmSignUp" action="<?php echo admin_url('register');?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">First Name <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="firstname" id="input-payment-firstname" autocomplete="off" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label class="control-label">Last Name <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="lastname" id="input-payment-lastname" autocomplete="off" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Email <span class="text-danger">*</span></label>
                    <input class="form-control floating" type="email" name="email" id="input-payment-email" autocomplete="off" required>
                </div>
            </div>
           
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Password <span class="text-danger">*</span></label>
                    <input class="form-control floating" type="email" name="password" id="input-payment-password" autocomplete="off" required>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label class="control-label">Status <span class="text-danger">*</span></label>
                    <select class="select floating" id="input-payment-status" required> 
                        <option value="">Select option</option>
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Confirm Password <span class="text-danger">*</span></label>
                    <input class="form-control floating" type="text" name="confirm" id="input-payment-confirm" autocomplete="off" required>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label class="control-label">Contry <span class="text-danger">*</span></label>
                    <select class="select floating" id="input-payment-country" required> 
                        <option value="">Select option</option>
                        
                    </select>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label class="control-label">State <span class="text-danger">*</span></label>
                    <select class="select floating" id="input-payment-state" required> 
                        <option value="">Select option</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Address 1 <span class="text-danger">*</span></label>
                    <input class="form-control floating" type="text" name="address_1" id="input-payment-address_1" autocomplete="off" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Address 2 <span class="text-danger"></span></label>
                    <input class="form-control floating" type="text" name="address_2" id="input-payment-address_2" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">City <span class="text-danger"></span></label>
                    <input class="form-control floating" type="text" name="city" id="input-payment-city" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">PostCode <span class="text-danger"></span></label>
                    <input class="form-control floating" type="text" name="postcode" id="input-payment-postcode" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Phone <span class="text-danger"></span></label>
                    <input class="form-control floating" type="text" name="phone" id="input-payment-phone" autocomplete="off">
                </div>
            </div>


        </div>
        
        <div class="m-t-20">
            <button class="btn btn-primary">Save</button>
            <a class="btn btn-primary">Cancel</a>
        </div>
        
    </form>
    </div>
</div>
</div>