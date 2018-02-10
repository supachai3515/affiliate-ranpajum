<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
          <h1>แก้ไขรายการซ่อม</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('fix/update/'.$fix_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $fix_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
            
          </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="name">ชื่อ</label>  
          <div class="col-md-6">
            <input id="name" name="name" type="text" value="<?php echo $fix_data['name']; ?>" placeholder="ชื่อ" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="description">รายละเอียด</label>  
          <div class="col-md-6">
            <input id="description" name="description" type="text" value="<?php echo $fix_data['description']; ?>" placeholder="รายละเอียด" class="form-control input-md" required="">
          </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="duration">ระยะเวลา</label>  
          <div class="col-md-3">
            <input id="duration" name="duration" type="text" value="<?php echo $fix_data['duration']; ?>" placeholder="ระยะเวลา" class="form-control input-md" required="">
          </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="price">ราคา</label>  
          <div class="col-md-3">
            <input id="price" name="price" type="number" value="<?php echo $fix_data['price']; ?>" placeholder="ราคา" class="form-control input-md" required="">
          </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="orderby">เรียงลำดับ</label>  
          <div class="col-md-3">
            <input id="orderby" name="orderby" type="number" value="<?php echo $fix_data['orderby']; ?>" placeholder="เรียงลำดับ" class="form-control input-md" required="">
          </div>
        </div>


        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($fix_data['is_active']==1): ?>
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
