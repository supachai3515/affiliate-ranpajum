<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
          <h1>แก้ไขสินค้า <a class="btn btn-success" href="<?php echo $this->config->item('weburl').'product/'.$product_data['slug']; ?>" role="button" target="_blank">ดูสินค้า</a></h1>
        </div>

     	<div style="padding-top:30px;"></div>
    	<form class="form-horizontal" method="POST"  action="<?php echo base_url('products/update/'.$product_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
		<fieldset>
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="id">รหัสสินค้า</label>  
		  <div class="col-md-4">
		  <input id="id" name="id" type="text" disabled="true" value="<?php echo $product_data['id']; ?>" placeholder="รหัสสินค้า" class="form-control input-md" required="">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="sku">รหัส</label>  
		  <div class="col-md-4">
		  <input id="sku" name="sku" type="text" value="<?php echo $product_data['sku']; ?>" placeholder="รหัสสินค้า" class="form-control input-md" required="">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="name">ชื่อ</label>  
		  <div class="col-md-6">
		  <input id="name" name="name" type="text" value="<?php echo $product_data['name']; ?>" placeholder="ชื่้อสินค้า" class="form-control input-md" required="">
		    
		  </div>
		</div>
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="name">URL link</label>  
		  <div class="col-md-6">
		  <input id="slug" name="slug" type="text" value="<?php echo urldecode($product_data['slug']); ?>" placeholder="URL link" class="form-control input-md" required="">
		    <span class="text-danger">***ถ้ามีการแก้ไขจะทำให้ link สินค้าเปลี่ยน ***</span>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="model">Model</label>  
		  <div class="col-md-6">
		  <input id="model" name="model" type="text" value="<?php echo $product_data['model']; ?>" placeholder="model" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="select_brand">ยี่ห้อสินค้า</label>
		  <div class="col-md-4">
		    <select id="select_brand" name="select_brand" class="form-control">
			<?php foreach ($brands_list as $brand): ?>
	    		<?php if ($brand['id']==$product_data['product_brand_id']): ?>
	    			<option value="<?php echo $brand['id']; ?>" selected><?php echo $brand['name']; ?></option>
	    		<?php else: ?>
	    			<option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
	    		<?php endif ?>	    	
		    <?php endforeach ?>
		    </select>
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="select_type">หมวดสินค้า</label>
		  <div class="col-md-4">
		    <select id="select_type" name="select_type" class="form-control">
			<?php foreach ($type_list as $type): ?>
	    		<?php if ($type['id']==$product_data['product_type_id']): ?>
	    			<option value="<?php echo $type['id']; ?>" selected><?php echo $type['name']; ?></option>
	    		<?php else: ?>
	    			<option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
	    		<?php endif ?>	    	
		    <?php endforeach ?>
		    </select>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="price">ราคา</label>  
		  <div class="col-md-4">
		  <input id="price" name="price" type="number" value="<?php echo $product_data['price']; ?>" placeholder="ราคา" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="dis_price">ลดราคา</label>  
		  <div class="col-md-4">
		  <input id="dis_price" name="dis_price" type="number" value="<?php echo $product_data['dis_price']; ?>" placeholder="ราคาส่วนลด" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="member_discount">ราคา Dealer</label>
            <div class="col-md-4">
                <input id="member_discount" name="member_discount" type="number" value="<?php echo $product_data['member_discount']; ?>" placeholder="ราคา fanshine" class="form-control input-md">
            </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="member_discount_lv1">ราคา dealer fanshine</label>
            <div class="col-md-4">
                <input id="member_discount_lv1" name="member_discount_lv1" type="number" value="<?php echo $product_data['member_discount_lv1']; ?>" placeholder="ราคา Dealer" class="form-control input-md">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="warranty">ระยะประกัน</label>
            <div class="col-md-4">
                <input id="warranty" name="warranty" type="text" value="<?php echo $product_data['warranty']; ?>" placeholder="ระยะประกัน" class="form-control input-md">
            </div>
        </div>


		<!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="weight">น้ำหนัก</label>
            <div class="col-md-4">
                <input id="weight" name="weight" type="number" value="<?php echo $product_data['weight']; ?>" placeholder="น้ำหนัก" class="form-control input-md">
            </div>
        </div>


		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="stock">สินค้าคงเหลือ</label>  
		  <div class="col-md-4">
		  <input id="stock" name="stock" type="number" value="<?php echo $product_data['stock']; ?>" placeholder="สินค้าคงเหลือ" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Multiple Checkboxes -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="promotion">โปรโมชั่น</label>
		  <div class="col-md-4">
		  <div class="checkbox">
		    <label for="is_promotion">
		      <input type="checkbox" name="is_promotion" id="is_promotion" value="1" 
		      <?php if ($product_data['is_promotion']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ลดราคา
		    </label>
			</div>
		  <div class="checkbox">
		    <label for="is_sale">
		      <input type="checkbox" name="is_sale" id="is_sale" value="1" 
		      <?php if ($product_data['is_sale']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      แนะนำ
		    </label>
			</div>
		  <div class="checkbox">
		    <label for="is_hot">
		      <input type="checkbox" name="is_hot" id="is_hot" value="1"
		      <?php if ($product_data['is_hot']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ได้รับความนิยม
		    </label>
			</div>
		  </div>
		</div>


		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="detail">รายละเอียด</label>
		  <div class="col-md-8">                     
		    <textarea class="form-control" id="detail" name="detail"><?php echo $product_data['detail']; ?></textarea>
		  </div>
		</div>

		<!-- File Button --> 
		<div class="form-group">
		  <label class="col-md-3 control-label" for="image_field">รูปตัวอย่าง</label>
		  <div class="col-md-6">
		    <p><input id="image_field" name="image_field" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>
	    	
		  </div>
		</div>

		<!-- File Button --> 
		<div class="form-group">
		  <label class="col-md-3 control-label" for="image_field_mul">รูปสินค้า</label>
		  <div class="col-md-6">
		  	<?php foreach ($images_list as $image): ?>
			  	<p> 
		    		<input type="checkbox" name="is_active_<?php echo $image['line_number']; ?>" id="is_active_ <?php echo $image['line_number']; ?>" value="1"
			      		<?php if ($image['is_active'] ==1){echo "checked";} ?>
			      	> ใช้งานรูปภาพ <br/>
		    		<input id="image_field_<?php echo $image['line_number']; ?>" name="image_field_<?php echo $image['line_number']; ?>" class="file-loading" type="file" 
		    		data-show-upload="false" data-min-file-count="1">
		    	</p><br/>
		  	
		  	<?php endforeach ?>
			</div>
		</div>

		<!-- Multiple Checkboxes -->
		<div class="form-group">
		  <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
		  <div class="col-md-4">
		  <div class="checkbox">
		    <label for="isactive-0">
		      <input type="checkbox" name="isactive" id="isactive-0" value="1" 
		      <?php if ($product_data['is_active']==1): ?>
		      	<?php echo "checked"; ?>
		      <?php endif ?>
		      >
		      ใช้งานสินค้า
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
