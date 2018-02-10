<div class="content-wrapper">
  <section class="content">

  <script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
      <h4>เลือกใบสั่งซื้อ</h4>
    </div>
    <div class="modal-body">
      <form class="form-inline" role="form" ng-submit="searchOrder(search_order)">
        <div class="form-group">
          <label class="sr-only" for="">รหัสสินค้า , เลขที่ใบสั่งซื้อ</label>
          <input type="text" class="form-control" ng-model="search_order" ng-init="search_order =''" placeholder="รหัสสินค้า , เลขที่สั่งซื้อ">
        </div>
        <button type="submit" class="btn btn-primary">ค้นหา</button>
      </form>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Serial Number</th>
              <th>วันที่</th>
              <th>Products</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="value in order_data">
              <td>
                ใบรับคืน : <span ng-bind="value.return_id"></span>/<span ng-bind="value.return_docno"></span>
                <br> ใบสั่งซื้อ : <span ng-bind="value.order_id"></span>/<span ng-bind="value.invoice_no"></span>
                <br>
              </td>
              <td>
                <span ng-bind="value.serial_number"></span>
                <br>
              </td>
              <td><span ng-bind="value.create_date"></span></td>
              <td>
                SKU : <span ng-bind="value.sku"></span>
                <br> NAME : <span ng-bind="value.product_name"></span>
              </td>
              <td ng-if="value.is_return == 0">
                <button type="button" class="btn btn-info btn-xs" ng-click="selectOrder(value.order_id,value.return_id,value.serial_number)">เลือก</button>
              </td>
              <td ng-if="value.is_return == 1"><span class="label label-default">ทำใบลดหนี้แล้ว</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
    </div>
  </script>

  <div class="container-fluid box" ng-controller="credit_note">
    <div class="page-header">
      <h2>ใบลดหนี้ <?php echo $credit_note_data['docno']; ?></h2>
    </div>
    <div style="padding-top:30px;"></div>
    <form class="form-horizontal" method="POST" action="<?php echo base_url('credit_note/update/'.$credit_note_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
      <fieldset>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>
          <div class="col-md-2">
            <input type="text" name="docno" hidden="true" value="<?php echo $credit_note_data['docno']; ?>">
            <input id="id" name="id" type="text" readonly="true" value="<?php echo $credit_note_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
          </div>
          <label class="col-md-3" ><?php echo $credit_note_data['docno']; ?></label>

        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="return_id">เลขที่ใบรับคืน</label>
          <div class="col-md-2">
              <input id="return_id" name="return_id" type="text" placeholder="เลขที่ใบรับคืน" class="form-control input-md" ng-model="return_id" ng-init="return_id = items.return_id" required="" readonly="true" readonly="true">
          </div>
          <label class="col-md-3">
            <?php echo $credit_note_data['invoice_docno']; ?>
          </label>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="order_id">เลขที่ใบสั่งซื้อ</label>
          <div class="col-md-6">
            <input id="order_id" name="order_id" type="text" placeholder="เลขที่ใบสั่งซื้อ" class="form-control input-md" ng-model="order_id" ng-init="order_id = items.order_id" required="" readonly="true">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="product_id">รหัสสินค้า</label>
          <div class="col-md-6">
            <input id="product_id" name="product_id" type="text" placeholder="รหัสสินค้า" class="form-control input-md" ng-model="product_id" ng-init="product_id = items.product_id" required="" readonly="true">
            <p><strong>Product Name: </strong>
              <?php echo $credit_note_detail['product_name']; ?>
                <br>
                <strong>Price : </strong>
                <?php echo $credit_note_detail['price']; ?>
            </p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="serial">serial number</label>
          <div class="col-md-6">
            <input id="serial" name="serial" type="text" placeholder="serial number" class="form-control input-md" ng-model="serial" ng-init="serial = items.serial" required="" readonly="true">
          </div>
        </div>



        <div class="form-group">
          <label class="col-md-3 control-label" for="comment">หมายเหตุ</label>
          <div class="col-md-6">
            <textarea class="form-control" name="comment"><?php echo $credit_note_data['comment']; ?></textarea>
          </div>
        </div>


        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
            <div class="checkbox">
              <label for="isactive-0">
                <input type="checkbox" name="is_active" id="isactive-0" value="1" <?php if ($credit_note_data[ 'is_active']==1): ?>
                <?php echo "checked"; ?>
                  <?php endif ?>
                    > ใช้งาน
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">คืนเงิน</label>
          <div class="col-md-4">
            <div class="checkbox">
              <label for="isactive">
                <input type="checkbox" name="is_refund" id="is_refund" value="1" <?php if ($credit_note_data['is_refund']==1): ?>
                <?php echo "checked"; ?>
                  <?php endif ?>
                    > คืนเงิน
              </label>
            </div>
          </div>
        </div>
        <div class="form-group" id="imgshow">
          <label class="col-md-3 control-label" for="image_fieldedit">รูปสลิป</label>
          <div class="col-md-6">
            <p><input id="image_fieldedit" name="image_fieldedit" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>

          </div>
        </div>
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="save"></label>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">เปลี่ยนแปลงข้อมูล</button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <!-- /.container-fluid -->
</section>
</div>
