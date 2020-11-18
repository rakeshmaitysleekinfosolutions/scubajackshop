<div class="content container-fluid">
    <form id="frm" action="<?php echo admin_url('settings');?>" method="post">
        <input type="hidden" value="<?php echo $id;?>" name="id">
        <input type="hidden" value="<?php echo $action;?>" name="action">
        <div class="row">
            <?php if(hasMessage('message')) { ?>
                <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo getMessage('message');?>
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

                        <h3 class="page-title">Application Settings</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input name="company_name" class="form-control" type="text" value="<?php echo $company_name;?>" required>
                                </div>
                                
                            </div>
                            <div class="col-sm-6">
                                
                                <div class="form-group">
                                    <label>Contact Person<span class="text-danger">*</span></label>
                                    <input name="contact_person" class="form-control " value="<?php echo $contact_person;?>" type="text" required>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input name="email" class="form-control" value="<?php echo $email;?>" type="email" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email 2</label>
                                <input name="email_2" class="form-control" value="<?php echo $email_2;?>" type="email">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Phone Number 1 <span class="text-danger">*</span></label>
                                <input name="phone_1" class="form-control" value="<?php echo $phone_1;?>" type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Phone Number 2 </label>
                                <input name="phone_2" class="form-control" value="<?php echo $phone_2;?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group">
                               <label>Each Field Trip Point <span class="text-danger">*</span></label>
                                <input name="point" class="form-control" type="number" min="1" value="<?php echo $point;?>" required>      
                        </div>
                       </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Address 1<span class="text-danger">*</span></label>
                                    <input name="address_1" class="form-control " value="<?php echo $address_1;?>" type="text" required>
                                </div>
                                
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <input name="address_2" class="form-control " value="<?php echo $address_2;?>" type="text">
                                </div>
                                
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Postal Code<span class="text-danger">*</span></label>
                                    <input name="postal_code" class="form-control" value="<?php echo $postal_code;?>" type="text" required>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-4">
                                
                                 <div class="form-group">
                                    <label>Country<span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-control select" required>
                                        <?php if(!empty($countries)) {
                                            foreach ($countries as $country) {?>
                                                <option value="<?php echo $country->id;?>" <?php echo ($country_id == $country->id) ? "selected" : "";?>><?php echo $country->name;?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">

                                <div class="form-group">
                                    <label>State/Province<span class="text-danger">*</span></label>
                                    <select name="state_id" class="form-control select" required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>City<span class="text-danger">*</span></label>
                                    <input name="city" class="form-control" value="<?php echo $city;?>" type="text" required>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                    <label>Logo<span class="text-danger">*</span></label>
                                    <a href="javascript:void(0);" id="thumb-image" data-toggle="image" class="img-thumbnail" type="image"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                                    <input type="hidden" name="logo" value="<?php echo $logo;?>" id="input-image" />
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Currency<span class="text-danger">*</span></label>
                                <select class="form-control" id="currency" name="currency" required>
                                    <?php
                                    if(!empty($currencies)) {
                                        foreach($currencies as $c) {
                                            ?>
                                            <option value="<?php echo $c['code'];?>" <?php echo ($c['code'] == $currency) ? "selected" : '';?>><?php echo $c['name'].'('.$c['code'].')';?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Youtube URL <span class="text-danger">*</span></label>
                                <input value="<?php echo $youtubeUrl;?>" id="videoInputBox" name="youtubeUrl" type="text" class="form-control" autocomplete="off" required>
                                <div id="iframe">
                                    <!--                                <iframe src="--><?php //echo $youtubeThumb;?><!--">-->
                                    <!--                                    <meta http-equiv="refresh" content="0;url=">-->
                                    <!--                                </iframe>-->
                                    <?php if($youtubeUrl) {?>
                                        <div id="iframe">
                                            <video controls controlsList="nofullscreen nodownload" src="<?php echo $youtubeUrl;?>" poster="<?php echo $youtubeThumb;?>"preload="none"> </video>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" value="<?php echo $youtubeThumb;?>" id="youtubeThumb" name="youtubeThumb">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h3 class="page-title">Mail Configuration Settings</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mail Protocol<span class="text-danger">*</span></label>
                                <select name="protocol" id="protocol" class="form-control" required>
                                    <option value="mail" <?php echo ($protocol == 'mail') ? "selected" : "" ;?>>MAIL</option>
                                    <option value="smtp" <?php echo ($protocol == 'smtp') ? "selected" : "" ;?>>SMTP</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mail Parameter</label>
                                <input name="parameter" class="form-control " value="<?php echo $parameter;?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mail SMTP Host<span class="text-danger">*</span></label>
                                <input name="smtp_hostname" class="form-control" type="text" value="<?php echo $smtp_hostname;?>" required>
                            </div>
                            <div class="form-group">
                                <label>Mail SMTP User<span class="text-danger">*</span></label>
                                <input name="smtp_username" class="form-control " value="<?php echo $smtp_username;?>" type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mail SMTP Password<span class="text-danger">*</span></label>
                                <input name="smtp_password" class="form-control" type="text" value="<?php echo $smtp_password;?>" required>
                            </div>
                            <div class="form-group">
                                <label>Mail SMTP Port<span class="text-danger">*</span></label>
                                <input name="smtp_port" class="form-control " value="<?php echo $smtp_port;?>" type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mail SMTP Timeout<span class="text-danger">*</span></label>
                                <select name="smtp_timeout" id="protocol" class="form-control" required>
                                    <?php for ($i = 1; $i <= 30; $i++) {?>
                                        <option value="<?php echo $i;?>" <?php echo ($smtp_timeout == $i) ? "selected" : "" ;?>><?php echo $i;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sender Email<span class="text-danger">*</span></label>
                                <input name="sender_email" class="form-control" type="text" value="<?php echo $sender_email;?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sender Name<span class="text-danger">*</span></label>
                                <input name="sender_name" class="form-control" type="text" value="<?php echo $sender_name;?>" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Meta Data-->
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h3 class="page-title">Meta Data</h3>
                    <div class="row">
                        <div class="form-group">
                            <label>Meta Title<span class="text-danger">*</span></label>
                            <input name="meta_title" class="form-control" placeholder="Meta Tag Title" value="<?php echo $meta_title;?>" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>Meta Tag Keywords</div></label>
                            <textarea name="meta_keywords" rows="5" placeholder="Meta Tag Keywords" class="form-control" ><?php echo $meta_keywords;?></textarea>
                        <div class="form-group">
                            <label>Meta Tag Description</label>
                            <textarea name="meta_description" rows="5" placeholder="Meta Tag Description" class="form-control"><?php echo $meta_description;?></textarea>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
    var myLabel             = myLabel || {};
    myLabel.baseUrl         = '<?php echo base_url();?>';
    myLabel.states          = '<?php echo admin_url('users/states');?>';
    myLabel.filemanager     = '<?php echo admin_url('filemanager');?>';
    myLabel.state_id        = '<?php echo $state_id;?>';
</script>