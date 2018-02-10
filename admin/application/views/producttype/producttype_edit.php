<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
          <h1>แก้ไขหมวดสินค้า</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('producttype/update/'.$producttype_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $producttype_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
            
          </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="name">ชื่อ</label>  
          <div class="col-md-6">
            <input id="name" name="name" type="text" value="<?php echo $producttype_data['name']; ?>" placeholder="ชื่อ" class="form-control input-md" required="">
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="name">URL link</label>  
          <div class="col-md-6">
          <input id="slug" name="slug" type="text" value="<?php echo urldecode($producttype_data['slug']); ?>" placeholder="URL link" class="form-control input-md" required="">
            <span class="text-danger">***ถ้ามีการแก้ไขจะทำให้ link สินค้าเปลี่ยน ***</span>
          </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="description">รายละเอียด</label>
          <div class="col-md-8">                     
            <textarea class="form-control" id="detail" name="description"><?php echo $producttype_data['description']; ?></textarea>
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="select_type">หมวดหมู่หลัก</label>
          <div class="col-md-4">
            <select id="select_type" name="select_type" class="form-control">
             <?php if ($producttype_data['parenttype_id']== 0 || !isset($producttype_data['parenttype_id'])): ?>
                <option value="0" selected>*** ไม่มี ***</option>
                <?php else: ?>
                  <option value="0">*** ไม่มี ***</option>
            <?php endif ?>
          <?php foreach ($type_list as $type): ?>
              <?php if ($type['id']==$producttype_data['parenttype_id']): ?>
                <option value="<?php echo $type['id']; ?>" selected><?php echo $type['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
              <?php endif ?>        
            <?php endforeach ?>
            </select>
          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($producttype_data['is_active']==1): ?>
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
