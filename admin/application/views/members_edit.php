<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
          <h1>แก้ไขสมาชิก dealer</h1>
        </div>

     	<div style="padding-top:30px;"></div>
    	<form class="form-horizontal" method="POST"  action="<?php echo base_url('members/update/'.$member_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="id">รหัส</label>  
		  <div class="col-md-4">
		  <input id="id" name="id" type="text" disabled="true" value="<?php echo $member_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
		    
		  </div>
		</div>


		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="name">ชื่อ</label>  
		  <div class="col-md-6">
		  	<input id="first_name" name="first_name" type="text" value="<?php echo $member_data['first_name']; ?>" placeholder="ชื่อ" class="form-control input-md" required="">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">สกุล</label>  
		  <div class="col-md-6">
		  <input id="last_name" name="last_name" type="text" value="<?php echo $member_data['last_name']; ?>" placeholder="สกุล" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">ชื่อร้านค้า</label>  
		  <div class="col-md-6">
		  <input id="company" name="company" type="text" value="<?php echo $member_data['company']; ?>" placeholder="ชื่อรา้นค้า" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">username</label>  
		  <div class="col-md-6">
		  <input id="username" name="username" type="text" value="<?php echo $member_data['username']; ?>" placeholder="username" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">password</label>  
		  <div class="col-md-6">
		  <input id="password" name="password" type="text" value="<?php echo $member_data['password']; ?>" placeholder="password" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">email</label>  
		  <div class="col-md-6">
		  <input id="email" name="email" type="email" value="<?php echo $member_data['email']; ?>" placeholder="email" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">mobile</label>  
		  <div class="col-md-6">
		  <input id="mobile" name="mobile" type="text" value="<?php echo $member_data['mobile']; ?>" placeholder="mobile" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">tel</label>  
		  <div class="col-md-6">
		  <input id="tel" name="tel" type="text" value="<?php echo $member_data['tel']; ?>" placeholder="tel" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">เลขประจำตัวผู้เสียภาษี</label>  
		  <div class="col-md-6">
		  <input id="tax_number" name="tax_number" type="text" value="<?php echo $member_data['tax_number']; ?>" placeholder="เลขประจำตัวผู้เสียภาษี" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="detail">ที่อยู่สำหรับส่งสินค้า</label>
		  <div class="col-md-8">                     
		    <textarea class="form-control" id="address_receipt" name="address_receipt"><?php echo $member_data['address_receipt']; ?></textarea>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="detail">ที่อยู่ออกใบกำกับภาษี</label>
		  <div class="col-md-8">                     
		    <textarea class="form-control" id="address_tax" name="address_tax"><?php echo $member_data['address_tax']; ?></textarea>
		  </div>
		</div>


		<!-- Multiple Checkboxes -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="verify">ยืนยัน Dealer</label>
		  <div class="col-md-4">
		  <div class="checkbox">
		    <label for="verify-0">
		      <input type="checkbox" name="verify" id="verify-0" value="1" 
		      <?php if ($member_data['verify']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ใช้งาน
		    </label>
			</div>
		  </div>
		</div>

		<!-- Multiple Checkboxes -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="is_lavel1">ยืนยัน Dealer fanshine </label>
		  <div class="col-md-4">
		  <div class="checkbox">
		    <label for="verify-0">
		      <input type="checkbox" name="is_lavel1" id="is_lavel1-0" value="1" 
		      <?php if ($member_data['is_lavel1']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ใช้งาน
		    </label>
			</div>
		  </div>
		</div>

		<!-- Multiple Checkboxes -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
		  <div class="col-md-4">
		  <div class="checkbox">
		    <label for="isactive-0">
		      <input type="checkbox" name="isactive" id="isactive-0" value="1" 
		      <?php if ($member_data['is_active']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ใช้งาน
		    </label>
			</div>
		  </div>
		</div>

		<!-- Button -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="save"></label>
		  <div class="col-md-4">
		    <button type="submit" class="btn btn-primary">บันทึก</button>
		  </div>
		</div>


		</fieldset>
		</form>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
