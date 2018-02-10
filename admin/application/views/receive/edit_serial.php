<div class="content-wrapper">
  <section class="content">
    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title" ng-bind="product_serial[0].sku +' : '+ product_serial[0].product_name">Stock สินค้า </h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" novalidate>

                  <div class="form-group">
                        <label class="col-md-2 control-label"><p class="text-center">ลำดับ</p></label>
                        <label class="col-md-4 control-label"><p class="text-center">Serial Number</p></label>
                        <label class="col-md-2 control-label"><p class="text-center">ถูกใช้แล้ว</p></label>
                        <label class="col-md-4 control-label"><p class="text-center">วันที่บันทึก</p></label>

                    </div>


                <!-- Text input-->
                <div ng-repeat="value in product_serial">
                    <div class="form-group">
                        <label class="col-md-2 control-label"><span ng-bind="value.line_number"></span></label>
                        <div class="col-md-4">
                          <div ng-if="value.count_use != 1">
                            <input type="text" class="form-control input-md" ng-model="product_serial.serial_number[value.line_number]"  ng-init="product_serial.serial_number[value.line_number] = value.serial_number " enter>
                          </div>
                          <div ng-if="value.count_use == 1 ">
                            <input readonly="true" type="text" class="form-control input-md" ng-model="product_serial.serial_number[value.line_number]"  ng-init="product_serial.serial_number[value.line_number] = value.serial_number " enter>
                          </div>

                            
                        </div>
                        <label class="col-md-2 control-label">
                          <span ng-if="value.count_use == 1" class="label label-success"><i class="fa fa-check" aria-hidden="true"></i></span>
                          <span ng-if="value.count_use == 0" class="label"></span>
                        </label>
                        <label class="col-md-4 control-label"><span ng-bind="value.create_date"></span></label>
            
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                      <p class="text-danger">{{txtError}}</p>
                      <p class="text-success">{{txtSuccess}}</p>
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-3 control-label" for="save"></label>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" ng-click="save_serial()">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>

    <div class="container-fluid box" ng-controller="receive">
        <div class="page-header">
          <h1>แก้ไข Serial Number</h1>
        </div>

        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('receive/update/'.$receive_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-2">
          <input id="id" name="id" type="hidden" disabled="true" value="<?php echo $receive_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $receive_data['doc_no']; ?>" placeholder="รหัส" class="form-control input-md" required="">
           
          </div>
        </div>


          <!-- Multiple Checkboxes -->
          <div class="form-group">
              <label class="col-md-3 control-label" for="is_vat">คำนวน vat</label>
              <div class="col-md-3">
                  <div class="checkbox">
                      <label for="is_vat">
                          <input type="checkbox" name="is_vat" ng-model="is_vat_rececive"  ng-checked="<?php echo $receive_data['is_vat']; ?>"  value="1" <?php if ($receive_data['is_vat']==1): ?>
                            <?php echo "checked"; ?>
                          <?php endif ?>
                           disabled="true"> คำนวน vat
                      </label>
                  </div>
              </div>
          </div>
          <!-- Button -->

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="comment">รายการสินค้า</label>
              <div class="col-md-6">
                  <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                  <th>
                                      sku
                                  </th>
                                  <th>
                                      name
                                  </th>
                                  <th>
                                      qty
                                  </th>
                                  <th>
                                      price
                                  </th>
                                  <th>
                                      vat
                                  </th>
                                  <th>
                                      total
                                  </th>
                                  <th>
                                  </th>
                                  <th>
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr ng-repeat="product in product_receive">
                                  <td>
                                      {{ product.sku }}
                                  </td>
                                  <td>
                                      {{ product.name }}
                                  </td>
                                  <td>

                                      {{ product.qty }}
                                  </td>
                                  <td>
                                      {{ product.price | currency:'' }}
                                  </td>
                                  <td>
                                      {{ product.vat }}
                                  </td>
                                  <td>
                                      {{ product.total  | currency:'' }}
                                  </td>
                                  <td>
                                      <button type="button" class="btn btn-warning" ng-click="open(product.sku,product.qty,<?php echo $receive_data['id']; ?>)">ใส่ serial</button>
                                  </td>
                              </tr>
                          </tbody>
                          <tfoot>
                              <tr>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                     <strong> {{ getQtyReceive() }}</strong>
                                  </td>
                                  <td>
                                      
                                  </td>
                                  <td>
                                      <strong>{{ getVatReceive()  | currency:'' }}</strong>
                                  </td>
                                  <td>
                                      <strong>{{ getTotalReceive() | currency:''  }}</strong>
                                  </td>

                                  <td>
                                  </td>
                                   
                              </tr>
                                 
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>

           <!-- Text input-->
          <div class="form-group">
              <label class="col-md-3 control-label" for="comment">หมายเหตุ</label>
              <div class="col-md-6">
                  <input id="comment" name="comment" type="text" placeholder="หมายเหตุ" class="form-control input-md" value="<?php echo $receive_data['comment']; ?>" disabled="true" >
              </div>
          </div>


        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($receive_data['is_active']==1): ?>
                <?php echo "checked"; ?>
              <?php endif ?>
              disabled="true">
              ใช้งาน
            </label>
            </div>
          </div>
        </div>
        </fieldset>
        </form>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
