<section class="slider-category-area">
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
                        <li>Dealer</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>
                <div id="message"></div>
                <?php if (!$this->session->userdata('is_logged_in')): ?>
                	<?php $this->load->view('template/dealer-register'); ?>
				<?php else: ?>
				<div class="row">
				    <div class="col-sm-3">
				    	<div class="panel panel-default">
						    <div class="panel-heading">
						      <?php
						        echo '<i class="fa fa-user"></i> '.$this->session->userdata('username');
						      ?>
						    </div>
						    <div class="panel-body">
						        <a class="btn btn-default btn-lg btn-block" href="<?php echo  base_url('dealer'); ?>" role="button">
						            <i class="fa fa-history" aria-hidden="true"></i> ใบสั่งซื้อย้อนหลัง </a>
						        </button>
						        <button type="button" ng-click="editDealerForm_click()" class="btn btn-default btn-lg btn-block">
						            <i class="fa fa-pencil-square-o "></i> แก้ไขข้อมูล
						         </button>
						        <a class="btn btn-default btn-lg btn-block" href="<?php echo  base_url('dealer/logout'); ?>" role="button">
						            <i class="fa fa-sign-out"></i> ออกจากระบบ
						        </a>
						    </div>
						</div>
				    </div>
				    <div class="col-sm-9">
				        <div ng-if="showOrderDealer == true">
				    		<?php if (isset($dealerInfo['verify']) ): ?>
				    			<?php if ($dealerInfo['verify'] == 0): ?>
				    				<?php echo '<p class="text-center"><strong class=" text-danger">กรุณารอทางร้านตรวจสอบการสมัครก่อน หากมีข้อสงสัยกรุณาติดต่อทางร้าน</strong></p>';?>
				    			<?php endif ?>
				        		
				        	<?php endif ?>
					        <?php if (count($orderList) > 0): ?>
					        	<div class="table-responsive">
					        		<table class="table table-condensed">
					        			<thead>
					        				<tr>
					        					<th>#</th>
					        					<th>ข้อมูลการจัดส่ง</th>
					        					<th>ยอดรวม</th>	        					
					        					<th>link</th>
					        				</tr>
					        			</thead>
					        			<tbody>
					        			<?php foreach ($orderList as $value): ?>
					                		<tr>
					                			<td>
					                				<strong>วันที่ : </strong><?php echo $value['date'];?><br/>
					                				<strong>เลขที่ใบสั่งซื้อ : </strong>#<?php echo $value['id'];?><br/>
					                				<a href="<?php echo base_url('status/'.$value['ref_id']);?>" target="_bank">
					                					<strong class="text-success">สะถานะสินค้า <i class="fa fa-angle-double-right" aria-hidden="true"></i></strong>
					                				</a>
					                				<br>

					                				<?php if ($value['order_status_id'] ==  "1"): ?>
					                					<a href="<?php echo base_url('payment/order/'.$value['ref_id']);?>">
						                					<button type="button" class="btn btn-xs btn-warning">แจ้งชำระเงิน</button>
						                				</a> 
					                				<?php endif ?>
					                			</td>
					                			<td>
					                				<strong>ชื่อ : </strong><?php echo $value['name'];?><br/>
					                				<strong>ที่อยู่จัดส่ง : </strong><?php echo $value['address'];?><br/>
					                				<strong>Tracking : </strong><?php echo $value['trackpost'];?><br/>
					                			</td>
					                			<td>
					                				<span class="amount" ng-bind="<?php echo $value["total"];?> | currency:'฿':0"></span>
					                			</td>
					                			<td>
					                				<a href="<?php echo base_url('invoice/'.$value['ref_id']);?>" target="_bank">
					                					<button type="button" class="btn btn-xs btn-default">ดูใบเสร็จ</button>
					                				</a> 
					                				<br>
					                			
					                			</td>
					                		</tr>
						                <?php endforeach ?>
					        			</tbody>
					        		</table>
					        	</div>
					        <?php else: ?>
					        	<?php echo '<p class="text-center"><strong class="text-center">ยังไม่มีรายการสั่งซื้อ</strong></p>';?>
					        <?php endif ?>
				    
				    	</div><!--/order-->
				    	 <div ng-if="editDealerForm == true">
					    	<div class="signup-form">
								<form ng-submit="savedealerEdit()"> 
						            <div class="form-group">
									    <label for="first_name">ชื่อจริง</label>
									    <input ng-model="dealerEdit.first_name" class="form-control"  id="first_name" name="first_name" placeholder="ชื่อจริง"  required="required" type="text" >
									 </div>

									 <div class="form-group">
									    <label for="last_name">นามสกุลจริง</label>
									    <input ng-model="dealerEdit.last_name" class="form-control"  id="last_name" name="last_name" placeholder="นามสกุลจริง"  required="required" type="text">
									 
									 </div>

									 <div class="form-group">
									    <label for="company">ชื่อร้านค้า</label>
									    <input ng-model="dealerEdit.company" class="form-control"  id="company" name="company" placeholder="ชื่อจริง"  required="required" type="text">
									 
									 </div>

									 <div class="form-group">
									    <label for="username">Email / ใช้เป็น Username / ถ้าแก้ไข username จะเปลี่ยนตาม</label>
									    <input ng-model="dealerEdit.email" class="form-control"  id="email" name="email" placeholder="Email"  required="required" type="email">
									 </div>

									 <div class="form-group">
									    <label for="password">Password</label>
									    <input ng-model="dealerEdit.password" class="form-control"  id="password" name="password" placeholder="Password"  required="required" type="password">
									 </div>

									 <div class="form-group">
									    <label for="tel">โทรศัพท์บ้านหรือ Fax</label>
									    <input ng-model="dealerEdit.tel" class="form-control"  id="tel" name="tel" placeholder="โทรศัพท์บ้านหรือ Fax" type="text">
									 </div>

									 <div class="form-group">
									    <label for="mobile">เบอร์มือถึอ</label>
									    <input ng-model="dealerEdit.mobile" class="form-control"  id="mobile" name="mobile" placeholder="เบอร์มือถึอ"  required="required" type="text">
									 </div>


									 <div class="form-group">
									    <label for="address_receipt">ที่อยู่สำหรับส่งสินค้า</label>
									    <textarea ng-model="dealerEdit.address_receipt" class="form-control" id="address_receipt" name="address_receipt" placeholder="ที่อยู่สำหรับส่งสินค้า"  required="required"> </textarea>
									 </div>

									 <div class="form-group">
									    <label for="address_tax">ชื่อและที่อยู่สำหรับออกใบกำกับภาษี</label>
									    <textarea ng-model="dealerEdit.address_tax" class="form-control" id="address_tax" name="address_tax" placeholder="ชื่อและที่อยู่สำหรับออกใบกำกับภาษี"> </textarea>
									 </div>

									 <div class="form-group">
									    <label for="tax_number">เลขประจำตัวผู้เสียภาษี</label>
									    <input ng-model="dealerEdit.tax_number" class="form-control" id="tax_number" name="tax_number" placeholder="เลขประจำตัวผู้เสียภาษี" type="text">
									 </div>       
						            <button  type="submit" class="btn btn-default">แก้ไข</button>
						        </form> <!--/sign up form-->
						        <hr>
					            <div class="form-group" ng-if="isProscess==true">
				                	<hr>
				                    <div class="progress progress-striped active">
				                    	<div class="progress-bar progress-bar-success" style="width:70%"></div>
				                	</div>                 
				                </div>               
					            <h4 class="text-success" ng-bind="message_prosecss"></h4>
							</div>
					    </div>
				    </div>
				</div>
				<?php endif ?>
				<div class="container-fluid">
					<div style="height: 100px;"></div>
				</div>
			</div>
		</div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
