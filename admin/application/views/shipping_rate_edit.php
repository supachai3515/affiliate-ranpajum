<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
          <h1>แก้ไขอัตราค่าจัดส่ง</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('shipping_rate/update/'.$shipping_rate_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $shipping_rate_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="shipping_method_id">หมวดหมู่หลัก</label>
          <div class="col-md-4">
            <select id="shipping_method_id" name="shipping_method_id" class="form-control">
              <?php foreach ($shipping_method_list as $shipping): ?>
                <?php if ($shipping['id']==$shipping_rate_data['shipping_method_id']): ?>
                  <option value="<?php echo $shipping['id']; ?>" selected><?php echo $shipping['name']; ?></option>
                <?php else: ?>
                  <option value="<?php echo $shipping['id']; ?>"><?php echo $shipping['name']; ?></option>
                <?php endif ?>        
              <?php endforeach ?>
            </select>
          </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="from_weight">น้ำหนักเริ่ม</label>
            <div class="col-md-6">
                <input id="from_weight" name="from_weight" type="number" value="<?php echo $shipping_rate_data['from_weight']; ?>" placeholder="from_weight" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="to_weight">น้ำหนักถึง</label>
            <div class="col-md-6">
                <input id="to_weight" name="to_weight" type="number" value="<?php echo $shipping_rate_data['to_weight']; ?>" placeholder="to_weight" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="price">ราคา</label>
            <div class="col-md-6">
                <input id="price" name="price" type="text" value="<?php echo $shipping_rate_data['price']; ?>" placeholder="price" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="description">รายละเอียด</label>
            <div class="col-md-6">
                <input id="description" name="description" type="text" value="<?php echo $shipping_rate_data['description']; ?>" placeholder="description" class="form-control input-md">
            </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($shipping_rate_data['is_active']==1): ?>
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
