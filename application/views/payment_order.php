<section class="contuct-us-form-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- breadcrumbs start-->
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>แจ้งชำระเงิน</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
            </div>
        </div>
        <div class="" style="padding-top:30px;">
            <div class="row">
                <div class="col-sm-6">
                <?php if (isset($is_error)): ?>
                     <?php if ($is_error): ?>
                        <p class="texe-danger">
                             <?php echo $error;?>
                        </p>

                    <?php else: ?>
                        <?php echo $txt_res;?>

                    <?php endif ?>
                <?php endif ?>

                <?php if (isset($member_order['order_id'])): ?>
                    <div class="well">
                        <strong>แจ้งชำระเงิน : #</strong> <span><?php echo $member_order['order_id'] ?></span><br>
                        <strong>จำนวนเงิน : </strong> <span><?php echo $member_order['total'] ?> บาท</span><br>
                        <?php if (isset($member_order['bank_name'])): ?>
                            <hr>
                            <h3>ได้แจ้งชำระเงินแล้ว</h3>
                            <strong>จำนวนเงิน : </strong> <span><?php echo $member_order['amount'] ?> </span><br>
                            <strong>ธนาคาร : </strong> <span><?php echo $member_order['bank_name'] ?> </span><br>
                            <strong>วันที่โอน : </strong> <span><?php echo $member_order['inform_date_time'] ?></span><br><br>
                             <?php if (isset($member_order['comment'])): ?>
                                <strong>หมายเหตุ : </strong> <span><?php echo $member_order['comment'] ?></span><br><br>
                              <?php endif ?>
                            <img src="<?php echo base_url().$member_order['image_slip_customer'] ?>" class="img-responsive"  alt="Image">
                        <?php endif ?>

                    </div>

                    <?php if (!isset($member_order['bank_name'])): ?>
                          <?php echo form_open_multipart('payment/save_order');?>
                            <fieldset>
                              <input name="member_id" type="text"   value="<?php echo $member_order['customer_id'] ?>"  hidden="true">
                              <input name="order_id" type="text"   value="<?php echo $member_order['order_id'] ?>"  hidden="true">
                              <input name="ref_id" type="text"   value="<?php echo $member_order['ref_id'] ?>"  hidden="true">
                            <div class="form-group">
                                <label for="textinput">เลือกธนาคาร  *</label>
                                <select  name="bank_name"  class="form-control" required="required">
                                    <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="textinput">จำนวนเงิน *</label>
                                <input id="textinput"  name="amount" type="number" placeholder="จำนวนเงิน" class="form-control input-md" value="<?php echo $member_order['total'] ?>"  required="required">
                            </div>

                            <div class="form-group">
                            <label for="textinput">วันที่โอน  *</label>
                                <div class='input-group date' id='datepicker'>
                                    <input type='text' class="form-control" name="inform_date" placeholder="วันที่"  required="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                               </div>

                            <div class="form-group">
                            <label for="textinput">เวลาที่โอน  *</label>
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input id="timepicker1" type="text" name="inform_time" class="form-control input-small" required="true"/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                             </div>



                            <div class="form-group">
                                <label for="textinput">แนบไฟล์ *</label>
                                <input id="userfile" name="userfile" type="file" class="form-control input-md" required="required">
                            </div>

                            <div class="form-group">
                                <label for="textinput">หมายเหตุ</label>
                                <textarea  name="comment" class="form-control input-md" ></textarea>
                            </div>


                            <div class="form-group">
                                <label for="filebutton"></label>
                                <button type="submit" value="upload"  class="btn btn-success ">แจ้งชำระ</button>
                            </div>
                    </fieldset>

                    </form>

                    <?php endif ?>

                <?php endif ?>

                </div>
                <div class="col-sm-6">
                    <div class="row bank-payment">
                        <div class="col-sm-3" style=" margin:0 auto;">
                            <img src="<?php echo base_url('theme'); ?>/img/thaipanit.jpg" class="img-responsive img-rounded" alt="Image">
                        </div>
                        <div class="col-sm-9">
                            <h4>ธนาคารไทยพาณิชย์</h4>
                            <p>เลขที่บัญชี : 935-229047-8
                                <br> ชื่อบัญชี : บริษัท เอ็กไซ ไฮเทค จำกัด
                                <br>
                        </div>
                    </div>          
                    <div class="" style="padding-top:30px;">
                        <p><strong>แนบสลิปผ่านทางเว็บไซต์</strong></p>
                    </div>
                    <div class="">
                        <p><strong>แจ้งชำระเงินผ่านทาง line : </strong>
                            <span class="fa fa-comment"></span> LINE ID : <?php echo $this->config->item('line_id') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="padding-top: 50px;"></div>
