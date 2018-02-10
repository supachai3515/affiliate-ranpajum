<div class="content-wrapper">
  <section class="content">

    <script type="text/ng-template" id="myModalContent_credit.html">
        <div class="modal-header">
            <h4>เลือกใบสั่งซื้อ</h4>
        </div>
        <div class="modal-body">
        <form class="form-inline" role="form" ng-submit="searchOrder(search_order)">
            <div class="form-group">
                <label class="sr-only" for="">รหัสสินค้า , เลขที่ใบสั่งซื้อ</label>
                <input type="text" class="form-control"  ng-model="search_order" ng-init="search_order =''" placeholder="รหัสสินค้า , เลขที่สั่งซื้อ" >
            </div>
            <button type="submit" class="btn btn-primary" >ค้นหา</button>
        </form>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial Number</th>
                            <th>วันที่ออกใบลดหนี้</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="value in order_data">
                            <td>
                                เลขที่ใบสั่งซื้อ : <span ng-bind="value.order_id"></span>/<span ng-bind="value.invoice_no"></span><br/>
                                เลขที่ใบลดหนี้ : <span ng-bind="value.credit_note_id"></span>/<span ng-bind="value.credit_note_docno"></span>
                            </td>
                            <td>
                                <span ng-bind="value.serial_number"></span><br>
                            </td>
                            <td><span ng-bind="value.create_date"></span></td>
                            <td>
                                SKU : <span ng-bind="value.sku"></span><br>
                                NAME : <span ng-bind="value.product_name"></span>
                            </td>
                            <td ng-if="value.is_payment == 0"><button type="button" class="btn btn-info btn-xs"  ng-click="selectOrder(value.credit_note_id,value.credit_note_docno)">เลือก</button></td>
                              <td ng-if="value.is_payment == 1"><span class="label label-default">ใช้อ้างอิงแล้ว</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>

    <div class="container-fluid box" ng-controller="order">

          <script type="text/ng-template" id="myModalContent.html">
          <div class="modal-header">
              <h3 class="modal-title" ng-bind="product_serial[0].sku +' : '+ product_serial[0].product_name">Stock สินค้า </h3>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" novalidate>

                    <div class="form-group">
                          <label class="col-md-2 control-label"><p class="text-center">ลำดับ</p></label>
                          <label class="col-md-6 control-label"><p class="text-center">Serial Number</p></label>
                          <label class="col-md-4 control-label"><p class="text-center">วันที่บันทึก</p></label>

                      </div>


                  <!-- Text input-->
                  <div ng-repeat="value in product_serial">
                      <div class="form-group">
                          <label class="col-md-2 control-label"><span ng-bind="value.line_number"></span></label>
                          <div class="col-md-6">
                              <input type="text" class="form-control input-md" ng-model="product_serial.serial_number[value.line_number]"  ng-init="product_serial.serial_number[value.line_number] = value.serial_number " enter>
                          </div>
                          <label class="col-md-4 control-label"><span ng-bind="value.modified_date_order"></span></label>

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


        <div class="page-header">
          <h1>ใบสั่งซื้อสินค้า <strong>#<?php echo $orders_data['id'] ?></h1>
        </div>
        <div style="padding-top:30px;"></div>

        <form action="<?php echo base_url('orders/update_status/'.$orders_data['id']); ?>" method="POST" class="form-inline" role="form">
          <div class="form-group">
            <label class="sr-only" for="">สถานะ</label>
             <select id="select_status" name="select_status" class="form-control">
            <?php
             switch ($orders_data['order_status_id']) {
               case '1':
                  ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "1" || $status['id'] == "2" || $status['id'] == "5" ): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
                 break;

               case '2':
                 ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "2" || $status['id'] == "3" || $status['id'] == "4" || $status['id'] == "6" ): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
                break;

               case '3':
                ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "3" || $status['id'] == "4" || $status['id'] == "6" ): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
                break;

               case '4':
                ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "4"): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
                break;

               case '5':
                ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "5"): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
               break;

               case '6':
                ?>
                  <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "6" || $status['id'] == "1"): ?>
                        <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
                <?php
               break;

               default:
                 ?>
                 <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                        <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                    <?php endif ?>
                <?php endforeach ?>
                 <?php
                 break;
             }
             ?>
             </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="">description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด">
          </div>

          <button type="submit" class="btn btn-primary">เปลี่ยน</button>
        </form>

        <div class="row">
          <div class="col-md-8">
            <h4 class="text-info">ข้อมูลการสั่งซื้อ</h4>
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>สถานะ</th>
                          <th>#</th>
                          <th>จำนวน</th>
                          <th>ส่งไปยัง</th>
                          <th>รวม</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>
                              <strong><?php echo $orders_data['order_status_name'];?></strong><br/>
                               <?php if (isset($orders_data['trackpost'])) : ?>
                                <?php if ($orders_data['trackpost'] !=""): ?>
                                   <span>traking : </span>  <strong><?php echo $orders_data['trackpost'];?></strong><br/>
                                <?php endif ?>
                              <?php endif ?>
                          </td>
                          <td>
                              <span>เลขที่ใบเสร็จ : <strong>#<?php echo $orders_data['id'] ?></strong></span><br/>
                              <span>โดย : <strong><?php echo $orders_data['name'] ?></strong></span><br/>
                              <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($orders_data['date']));?></span>

                          </td>
                          <td>
                              <span><strong><?php echo $orders_data['quantity'] ?></strong> item</span><br/>
                          </td>
                          <td>
                              <strong>ที่อยู่ : </strong><span><?php echo $orders_data['address']; ?></span><br/>
                              <strong>วิธีการจัดส่ง : </strong><span><?php echo $orders_data['shipping']; ?></span><br/>
                              <strong>อีเมลล์ : </strong><span><?php echo $orders_data['email']; ?></span><br/>
                              <strong>เบอร์โทร : </strong><span><?php echo $orders_data['tel']; ?></span><br/>
                              <?php if ($orders_data['is_tax']=="1"): ?>
                                <h4>ออกใบกำภาษี</h4>
                                 <strong>เลขที่ผุ้เสียภาษี : </strong><span><?php echo $orders_data['tax_id']; ?></span><br/>
                                 <strong>บริษัท : </strong><span><?php echo $orders_data['tax_company']; ?></span><br/>
                                <strong>ที่อยู่ : </strong><span><?php echo $orders_data['tax_address']; ?></span><br/>

                            <?php endif ?>

                          </td>

                          <td>
                               <strong ng-bind="<?php echo $orders_data['total'];?> | currency:'฿':0"></strong>
                          </td>
                      </tr>
                  </tbody>
              </table>

            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">แก้ไขที่อยู่ลูกค้า</h3>
              </div>
              <div class="panel-body">
                <form action="<?php echo base_url('orders/update_address/'.$orders_data['id']); ?>" method="POST"  role="form">
                  <legend>ที่อยู่จัดส่ง</legend>

                  <div class="form-group">
                    <label for="">ที่อยู่</label>
                    <input type="text" class="form-control" name="address" placeholder="ที่อยู่" value="<?php echo $orders_data['address']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">วิธีการจัดส่ง</label>
                    <input type="text" class="form-control" name="shipping" placeholder="วิธีการจัดส่ง" value="<?php echo $orders_data['shipping']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">email</label>
                    <input type="text" class="form-control" name="email" placeholder="email" value="<?php echo $orders_data['email']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">เบอร์โทร</label>
                    <input type="text" class="form-control" name="tel" placeholder="tel" value="<?php echo $orders_data['tel']; ?>">
                  </div>

                  <legend>ที่อยู่ออกใบกำกับภาษี</legend>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="is_tax" value="1"
                      <?php if ($orders_data['is_tax']==1): ?>
                          <?php echo "checked"; ?>
                        <?php endif ?>
                        >
                      ออกใบกำกับภาษี
                    </label>
                  </div>
                  <div class="form-group">
                    <label for="">เลขที่ผุ้เสียภาษี</label>
                    <input type="text" class="form-control" name="tax_id" placeholder="เลขที่ผุ้เสียภาษี" value="<?php echo $orders_data['tax_id']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">บริษัท</label>
                    <input type="text" class="form-control" name="tax_company" placeholder="บริษัท" value="<?php echo $orders_data['tax_company']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">ที่อยู่</label>
                    <input type="text" class="form-control" name="tax_address" placeholder="ที่อยู่" value="<?php echo $orders_data['tax_address']; ?>">
                  </div>

                  <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
              </div>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">รายละเอียดสินค้า</h3>
            </div>
            <div class="panel-body">
              <div class="box-body table-responsive no-padding">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>sku</th>
                  <th>name</th>
                  <td>quantity</td>
                  <td>price</td>
                  <td>vat</td>
                  <td>total</td>
                </tr>
              </thead>
              <tbody>
              <?php  $sum_price=0; foreach ($orders_detail as $value): ?>
                <tr>
                  <td><?php echo  $value['sku'] ?></td>
                  <td>
                    <?php echo  $value['product_name'] ?> <br/>
                    <button type="button" class="btn btn-info btn-xs" ng-click="open(<?php echo  $value['product_id'] ?>,<?php echo  $value['quantity'] ?>,<?php echo $orders_data['id'] ?>)">Serial Number</button>
                  </td>
                  <td><?php echo  $value['quantity'] ?></td>
                  <td><?php echo  $value['price'] ?></td>
                  <td><?php echo  $value['vat'] ?></td>
                  <td><?php echo  $value['total']?></td>
                </tr>

              <?php $sum_price = $sum_price+($value['total']-$value['vat']); endforeach ?>

                <tr>
                  <td colspan="5" class="text-right"><strong>รวม</strong></td>
                  <td class="text-right"><ins ><?php echo  $sum_price ?></ins></td>
                </tr>

                <tr>
                  <td colspan="5" class="text-right"><strong>vat</strong></td>
                  <td class="text-right"><ins ><?php echo  $orders_data['vat'] ?></ins></td>
                </tr>
                <tr>
                  <td colspan="5" class="text-right"><strong>ค่าจัดส่ง</strong></td>
                  <td class="text-right"><ins class="text-right"><?php echo  $orders_data['shipping_charge'] ?></ins></td>
                </tr>
                 <tr>
                  <td colspan="5" class="text-right"><strong>รวมทั้งหมด</strong></td>
                  <td class="text-right"><ins class="text-right"><?php echo  $orders_data['total'] ?></ins></td>
                </tr>

              </tbody>
            </table>
              <?php if ($orders_data['order_status_id'] >= "2" && $orders_data['order_status_id'] < "5"): ?>
                  <form action="<?php echo base_url('orders/update_tracking/'.$orders_data['id']); ?>" method="POST" class="form-inline" role="form">
              <div class="form-group">
                <label class="sr-only" for="">tracking</label>
                <input type="text" class="form-control" id="tracking" name="tracking"
                <?php if (isset($orders_data['trackpost'])): ?>
                  value="<?php echo $orders_data['trackpost']; ?>"
                <?php endif ?>
                 placeholder="tracking number" required="true">
              </div>
              <div class="form-group">
                 <select id="select_status" name="select_status" class="form-control" readonly="true">
                <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "4"): ?>
                        <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="">description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด" >
          </div>


              <button type="submit" class="btn btn-primary">ส่งรหัส tracking</button>
            </form>


              <?php endif ?>
          </div>
            </div>
          </div>


            <div class="well">

               <form class="form-horizontal" method="POST" action="<?php echo base_url('orders/save_slip/'.$orders_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
               <div class="form-group">
                  <legend>การชำระเงิน</legend>
                </div>

                 <input hidden="true"  value="<?php echo $orders_data['member_id']; ?>"  name="member_id" >
                 <input type="hidden" name="credit_note_id" id="credit_note_id" value="">
                <div class="form-group">

                    <label class="col-md-3 control-label" for="textinput">เลือกธนาคาร  *</label>
                    <div class="col-md-6">
                      <select  name="bank_name"  class="form-control" required="required">

                          <?php if ($orders_data['bank_name'] == "ธนาคารไทยพาณิชย์"): ?>
                            <option value="ธนาคารไทยพาณิชย์" selected>ธนาคารไทยพาณิชย์</option>
                          <?php else: ?>
                            <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                          <?php endif ?>
                      </select>
                     </div>
                </div>

              <div class="form-group">
                  <label class="col-md-3 control-label" for="textinput">จำนวนเงิน *</label>
                  <div class="col-md-6">
                    <input value="<?php echo $orders_data['amount']; ?>"  name="amount" type="number" placeholder="จำนวนเงิน" class="form-control input-md" required="required">
                   </div>
              </div>

              <div class="form-group">
              <label class="col-md-3 control-label" for="textinput">วันที่โอน  *</label>
                <div class="col-md-6">
                    <div class='input-group date' id='datepicker'>
                        <input type='text' class="form-control" name="inform_date" placeholder="วันที่" value="<?php echo $orders_data['inform_date']; ?>"  required="true" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                   </div>
                  </div>

                <div class="form-group">
                <label class="col-md-3 control-label" for="textinput">เวลาที่โอน  *</label>
                <div class="col-md-6">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="timepicker1" type="text" name="inform_time" class="form-control input-small" value="<?php echo $orders_data['inform_time']; ?>"   required="true"/>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                 </div>
                  </div>


                  <div class="form-group">
                      <label class="col-md-3 control-label" for="textinput">หมายเหตุ</label>
                      <div class="col-md-6">
                        <textarea  name="comment" class="form-control input-md" ><?php echo $orders_data['comment']; ?></textarea>
                    </div>
                    </div>


                <!-- File Button -->
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="image_field">รูปสำหรับลูกค้า</label>
                    <div class="col-md-6">
                      <p><input id="image_field" name="image_field" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>

                    </div>
                  </div>

                  <!-- File Button -->
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="image_field1">รูปสำหรับเจ้าหน้าที่</label>
                    <div class="col-md-6">
                      <p><input id="image_field1" name="image_field1" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>

                    </div>
                  </div>

                <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" value="upload"  class="btn btn-success">บันทึก slip</button>
                  </div>
                </div>
            </form>

            </div>

          </div>


          <div class="col-md-4">
            <a href="<?php echo $this->config->item('weburl').'invoice/'.$orders_data['ref_id']; ?>" target="_blank"><button type="button" class="btn btn-success">ใบสั่งซื้อ</button></a>

            <?php if ($orders_data['order_status_id'] >= 2): ?>
                <?php if ($orders_data['is_invoice'] == 1): ?>
                  <a href="<?php echo  base_url('orders/invoice/'.$orders_data['id']); ?>" ><button type="button" class="btn btn-info">ใบกำกับภาษี</button></a> <span><?php echo $orders_data['invoice_docno'] ?></span>
                <?php else: ?>
                  <a href="<?php echo base_url('orders/invoice/'.$orders_data['id']); ?>"><button type="button" class="btn btn-warning">ออกใบกำกับภาษี</button></a>
                <?php endif ?>


            <?php endif ?>

            <h4 class="text-info">สถานะสินค้า</h4>
            <div class="well">
              <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>status</th>
                    <th>description</th>
                    <th>วันที่</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($order_status_history_list as $value): ?>
                  <tr>
                    <td><?php echo  $value['order_status_name'] ?></td>
                    <th><?php echo  $value['description'] ?></th>
                    <th><?php echo date("d-m-Y H:i", strtotime($value['create_date']));?></th>
                  </tr>
                <?php endforeach ?>

                </tbody>
              </table>
            </div>

            </div>

          </div>
        </div>

    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
