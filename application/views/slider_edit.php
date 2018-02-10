<div id="page-wrapper" ng-app="myApp">
    <div class="container-fluid" ng-controller="myCtrl">
        <div class="page-header">
          <h1>แก้ไข slider</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('slider/update/'.$slider_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $slider_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
            
          </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="name">ชื่อ</label>  
          <div class="col-md-6">
            <input id="name" name="name" type="text" value="<?php echo $slider_data['name']; ?>" placeholder="ชื่อ" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="model">รายละเอียด</label>  
          <div class="col-md-6">
          <input id="description" name="description" type="text" value="<?php echo $slider_data['description']; ?>" placeholder="รายละเอียด" class="form-control input-md">           
          </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="model">รายละเอียด1</label>  
          <div class="col-md-6">
          <input id="description1" name="description1" type="text" value="<?php echo $slider_data['description1']; ?>" placeholder="รายละเอียด1" class="form-control input-md">           
          </div>
        </div>

         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="model">name_link</label>  
          <div class="col-md-6">
          <input id="name_link" name="name_link" type="text" value="<?php echo $slider_data['name_link']; ?>" placeholder="name_link" class="form-control input-md">           
          </div>
        </div>


         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="model">image</label>  
          <div class="col-md-6">
          <input id="image" name="image" type="text" value="<?php echo $slider_data['image']; ?>" placeholder="image" class="form-control input-md">           
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="model">link</label>  
          <div class="col-md-6">
          <input id="link" name="link" type="text" value="<?php echo $slider_data['link']; ?>" placeholder="link" class="form-control input-md">           
          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($slider_data['is_active']==1): ?>
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
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
