<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
          <h1>แก้ไขสถานที่พิเศษ</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('special_county/edit/'.$special_county_data['amphur_id']."/".$special_county_data['shipping_method_id']) ?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Select Basic -->

        <div class="form-group">
          <label class="col-md-3 control-label" for="shipping_method_id">หมวดหมู่หลัก</label>
          <div class="col-md-4">
            <select id="shipping_method_id" name="shipping_method_id" class="form-control">
              <?php foreach ($shipping_method_list as $shipping): ?>
                <?php if ($shipping['id']==$special_county_data['shipping_method_id']): ?>
                  <option value="<?php echo $shipping['id']; ?>" selected><?php echo $shipping['name']; ?></option>
                <?php else: ?>
                  <option value="<?php echo $shipping['id']; ?>"><?php echo $shipping['name']; ?></option>
                <?php endif ?>        
              <?php endforeach ?>
            </select>
          </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label" for="province">จังหวัด</label>
            <div class="col-md-4">
                <select id="province" name="province" class="form-control" >
                <?php foreach ($province_list as $province): ?>
                <?php if ($province['id']==$special_county_data['province_id']): ?>
                  <option value="<?php echo $province['id']; ?>" selected><?php echo $province['name']; ?></option>
                <?php else: ?>
                  <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                <?php endif ?>        
              <?php endforeach ?>

                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="amphur_id">อำเภอ</label>
            <div class="col-md-4">
                <select id="amphur_id" name="amphur_id" class="form-control">
                 <?php foreach ($amphur_list as $amphur): ?>
                  <?php if ($amphur['id'] == $special_county_data['amphur_id']): ?>
                    <option value="<?php echo $amphur['id']; ?>" selected><?php echo $amphur['name']; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $amphur['id']; ?>"><?php echo $amphur['name']; ?></option>
                  <?php endif ?>        
                <?php endforeach ?>
                </select>
            </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="price">ราคา</label>
            <div class="col-md-6">
                <input id="price" name="price" type="text" value="<?php echo $special_county_data['price']; ?>" placeholder="price" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="description">รายละเอียด</label>
            <div class="col-md-6">
                <input id="description" name="description" type="text" value="<?php echo $special_county_data['description']; ?>" placeholder="description" class="form-control input-md">
            </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($special_county_data['is_active']==1): ?>
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
