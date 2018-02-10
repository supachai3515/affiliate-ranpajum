<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="receive">
        <div class="page-header">
            <h1>ใบรับสินค้า</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>";?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาใบรับสินค้า</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มใบรับสินค้า</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('receive/search');?>" method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="เลขที่เอกสาร">
                        </div>

                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อ</th>
                                    <th>สถานะ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($receive_list as $receive): ?>
                                <tr>
                                    <td>
                                        <span>รหัส : <strong><?php echo $receive['doc_no'] ?></strong></span><br/>
                                        <span>เลขที่เอกสารอ้งอิง : <strong><?php echo $receive['do_ref'] ?></strong></span><br/>
                                        <span>Supplier : <strong><?php echo $receive['supplier'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                        <span>หมายเหตุ : <strong><?php echo $receive['comment'] ?></strong></span><br/>
                                        <span>จำนวนรายการสินค้า : <strong><?php echo $receive['product_id'] ?></strong></span><br/>
                                        <a class="btn btn-sm btn-info"  role="button" ng-click="compare_serial(<?php echo $receive['id'] ?>)"><i class="fa fa-refresh" aria-hidden="true"> ตรวจสอบ Serial</i></a>

                                    </td>
                                    <td>

                                         <span>qty : <strong><?php echo $receive['qty'] ?></strong></span><br/>
                                          <span>vat : <strong><?php echo $receive['vat'] ?></strong></span><br/>
                                           <span>total : <strong><?php echo $receive['total'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($receive['modified_date']));?></span>
                                        <br/>
                                        <?php if ($receive['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                    <a class="btn btn-sm btn-warning" href="<?php echo base_url('receive/edit_serial/'.$receive['id']) ?>" role="button"><i class="fa fa-pencil"></i> Serial</a>

                                    <a class="btn btn-sm btn-warning" ng-click="btnEdit(<?php echo $receive['id'] ?>)" role="button"><i class="fa fa-pencil"></i></a>

  									                 <a target="_blank" class="btn btn-sm btn-warning" href="<?php echo base_url('receive/edit_view/'.$receive['id']) ?>" role="button"><i class="fa fa-eye"></i></a>
                                     <a target="_blank" class="btn btn-sm btn-info" href="<?php echo base_url('receive/view/'.$receive['id']) ?>" role="button"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>

                    <form class="form-horizontal" method="POST" action="<?php echo base_url('receive/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="do_ref">เลขที่อ้างอิง (ใบส่งของ)</label>
                                <div class="col-md-6">
                                    <input id="do_ref" name="do_ref" type="text" placeholder="เลขที่อ้างอิง (ใบส่งของ)" class="form-control input-md" required="">
                                </div>
                            </div>

                              <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="is_vat">คำนวน vat</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="is_vat">
                                            <input type="checkbox" name="is_vat" ng-model="is_vat_rececive" id="is_vat" value="1"> คำนวน vat
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">เพิ่มสินค้า</label>
                                <div class="col-md-6 well">
                                    <input type="text" class="form-control input-md" ng-model="sku" placeholder="รหัสสินค้า" enter><br />
                                    <input type="number" class="form-control input-md" ng-model="qty" placeholder="จำนวน" enter><br />
                                    <input type="number" class="form-control input-md" ng-model="price" placeholder="ราคา" enter><br />
                                    <button type="button"  class="btn btn-primary" ng-click="addReceive()">เพิ่ม</button>
                                    <p class="text-danger">{{msgError}}</p>


                                    <div class="table-responsive">
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="product in product_receive">
                                                    <td>
                                                        <input type="hidden" name="sku[]" value="{{product.sku}}" >
                                                        <input type="hidden" name="id[]" value="{{product.id}}" >
                                                        {{ product.sku }}
                                                    </td>
                                                    <td>
                                                        {{ product.name }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="qty[]" value="{{product.qty}}" >
                                                        {{ product.qty }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="price[]" value="{{product.price }}" >
                                                        {{ product.price | currency:'' }}
                                                    </td>
                                                    <td>
                                                        {{ product.vat }}
                                                    </td>
                                                    <td>
                                                        {{ product.total  | currency:'' }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" ng-click="removeProduct($index)">ลบ</button>
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
                                    <input id="comment" name="comment" type="text" placeholder="หมายเหตุ" class="form-control input-md">
                                </div>
                            </div>


                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="isactive-0">
                                            <input type="checkbox" name="isactive" id="isactive" value="1" checked> ใช้งานสินค้า
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="comment">Supplier</label>
                                <div class="col-md-6">
                                    <input id="supplier" name="supplier" type="text" placeholder="Supplier" class="form-control input-md" value="" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="comment">Warranty</label>
                                <div class="col-md-6">
                                    <input id="warranty" name="warranty" type="text" placeholder="warranty" class="form-control input-md" value="" >
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
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
<!-- /.content -->
