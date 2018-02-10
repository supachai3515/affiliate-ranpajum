<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"ng-controller="purchase_order">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add ใบขอซื้อ
      <small>เพิ่มใบขอซื้อ</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">เพิ่มใบขอซื้อ</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo base_url('purchase_order/add_save');?>" accept-charset="utf-8" enctype="multipart/form-data">
                    <fieldset>



                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="name">เพิ่มสินค้า</label>
                            <div class="col-md-6 well">
                                <input type="text" class="form-control input-md" ng-model="sku" placeholder="รหัสสินค้า" enter><br />
                                <input type="number" class="form-control input-md" ng-model="qty" placeholder="จำนวน" enter><br />
                                <input type="number" class="form-control input-md" ng-model="price" placeholder="ราคา" enter><br />
                                <button type="button"  class="btn btn-primary" ng-click="addpurchase_order()">เพิ่ม</button>
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
                                            <tr ng-repeat="product in product_purchase_order">
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
                                                   <strong> {{ getQtypurchase_order() }}</strong>
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    <strong>{{ getVatpurchase_order()  | currency:'' }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ getTotalpurchase_order() | currency:''  }}</strong>
                                                </td>

                                                <td>
                                                </td>

                                            </tr>

                                        </tfoot>
                                    </table>
                                </div>
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
        <div class="col-md-4">
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error)
                {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php } ?>
            <?php
                $success = $this->session->flashdata('success');
                if($success)
                {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>

            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
