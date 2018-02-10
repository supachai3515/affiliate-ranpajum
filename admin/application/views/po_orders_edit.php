<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
        <?php if ($po_orders_data['is_invoice']== 0): ?>
            <h1>ใบเสนอราคา <strong>#<?php echo $po_orders_data['id'] ?></h1>
        <?php else: ?>
            <h1>ใบสั่งซื้อสินค้า <strong>#<?php echo $po_orders_data['invoice_docno'] ?></h1>
        <?php endif ?>
        </div>
        <div style="padding-top:30px;"></div>
        <div class="row">
            <div class="col-md-6">
                <form action="<?php echo base_url('po_orders/update_status/'.$po_orders_data['id']); ?>" method="POST" class="form-inline" role="form">
                    <div class="form-group">
                        <label class="sr-only" for="">สถานะ</label>
                        <select id="select_status" name="select_status" class="form-control">
                            <?php foreach ($po_order_status_list as $status): ?>
                            <?php if ($status['id'] == $po_orders_data['po_order_status_id']): ?>
                            <option value="<?php echo $status['id']; ?>" selected>
                                <?php echo $status['name']; ?>
                            </option>
                            <?php else: ?>
                            <option value="<?php echo $status['id']; ?>">
                                <?php echo $status['name']; ?>
                            </option>
                            <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="">description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด">
                    </div>
                    <button type="submit" class="btn btn-primary">เปลี่ยน</button>
                </form>
                <br/>
            </div>
            <div class="col-md-6">
            <?php if ($po_orders_data['is_invoice']== 1): ?>
               <form action="<?php echo base_url('po_orders/update_tracking/'.$po_orders_data['id']); ?>" method="POST" class="form-inline" role="form">
                    <div class="form-group">
                        <label class="sr-only" for="">tracking</label>
                        <input type="text" class="form-control" id="tracking" name="tracking" <?php if (isset($po_orders_data[ 'trackpost'])): ?> value="<?php echo $po_orders_data['trackpost']; ?>"<?php endif ?> placeholder="tracking number">
                    </div>
                    <button type="submit" class="btn btn-primary">ส่งรหัส tracking</button>
                </form>
                <br/> 
            <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">ข้อมูลการสั่งซื้อ</div>
                    <div class="panel-body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>สถานะ</th>
                                        <th>#</th>
                                        <th>จำนวน</th>
                                        <th>รวม</th>
                                        <th>เอกสาร</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong><?php echo $po_orders_data['po_order_status_name'];?></strong>
                                            <br/>
                                            <?php if (isset($po_orders_data['trackpost'])) : ?>
                                            <?php if ($po_orders_data['trackpost'] !=""): ?>
                                            <span>traking : </span> <strong><?php echo $po_orders_data['trackpost'];?></strong>
                                            <br/>
                                            <?php endif ?>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($po_orders_data['is_invoice']== 0): ?>
                                                <span>เลขที่ใบเสนอราคา : <strong>#<?php echo $po_orders_data['id'] ?></strong></span>
                                            <?php else: ?>
                                                <span>เลขที่ใบสั่งซื้อ : <strong>#<?php echo $po_orders_data['invoice_docno'] ?></strong></span>
                                            <?php endif ?>
                                            
                                            <br/>
                                            <span>โดย : <strong><?php echo $po_orders_data['name'] ?></strong></span>
                                            <br/>
                                            <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($po_orders_data['date']));?></span>
                                        </td>
                                        <td>
                                            <span><strong><?php echo $po_orders_data['quantity'] ?></strong> item</span>
                                            <br/>
                                        </td>
                                        <td>
                                            <strong ng-bind="<?php echo $po_orders_data['total'];?> | currency:'฿':0"></strong>
                                        </td>
                                        <td>
                                        <form class="form-inline" action="<?php echo base_url('po_orders/update_invoice/'.$po_orders_data['id']); ?>" method="POST" role="form">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label for="isactive-0">
                                                        <input type="checkbox" name="is_invoice" id="is_invoice" value="1" <?php if ($po_orders_data[ 'is_invoice']==1): ?>
                                                        <?php echo "checked"; ?>
                                                        <?php endif ?> > ออกใบสั่งซื้อ
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-xs btn-primary">บันทึก</button>
                                        </form>

                                            <?php if ($po_orders_data['is_invoice']== 0): ?>
                                                <a target="_blank" class="btn btn-xs btn-default" href="<?php echo  $this->config->item('weburl').'po_invoice/'.$po_orders_data['ref_id'] ?>" role="button">    
                                                     ใบเสนอราคา
                                                    </a>
                                            <?php else: ?>
                                                <a target="_blank" class="btn btn-xs btn-success" href="<?php echo  $this->config->item('weburl').'po_invoice/'.$po_orders_data['ref_id'] ?>" role="button">    
                                                     ใบสั่งซื้อ
                                                    </a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">ที่อยู่จัดส่ง</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="<?php echo base_url('po_orders/update_info/'.$po_orders_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="">ที่อยู่</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="ที่อยู่"><?php echo $po_orders_data['address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">วิธีการจัดส่ง</label>
                                    <input type="text" class="form-control" id="shipping" name="shipping" value="<?php echo $po_orders_data['shipping']; ?>" placeholder="วิธีการจัดส่ง">
                                </div>
                                <div class="form-group">
                                    <label for="">อีเมลล์</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $po_orders_data['email']; ?>" placeholder="อีเมลล์">
                                </div>
                                <div class="form-group">
                                    <label for="">เบอร์โทร</label>
                                    <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $po_orders_data['tel']; ?>" placeholder="เบอร์โทร">
                                </div>
                                <button type="submit" class="btn btn-primary">SAVE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($po_orders_data['is_tax']=="1"): ?>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">ใบกำกับภาษี</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="<?php echo base_url('po_orders/update_tax_info/'.$po_orders_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="">เลขที่ผู้เสียภาษี</label>
                                    <input type="text" class="form-control" id="tax_id" name="tax_id" value="<?php echo $po_orders_data['tax_id']; ?>" placeholder="เลขที่ผู้เสียภาษี">
                                </div>
                                <div class="form-group">
                                    <label for="">บริษัท</label>
                                    <input type="text" class="form-control" id="tax_company" name="tax_company" value="<?php echo $po_orders_data['tax_company']; ?>" placeholder="บริษัท">
                                </div>
                                <div class="form-group">
                                    <label for="">ที่อยู่</label>
                                    <textarea class="form-control" id="tax_address" name="tax_address" placeholder="ที่อยู่"><?php echo $po_orders_data['tax_address']; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">SAVE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">รายละเอียดสินค้า</div>
                    <div class="panel-body">
                        <form class="form-inline" action="<?php echo base_url('po_orders/update_tax/'.$po_orders_data['id']); ?>" method="POST" role="form">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="isactive-0">
                                        <input type="checkbox" name="is_tax" id="isactive-0" value="1" <?php if ($po_orders_data[ 'is_tax']==1): ?>
                                        <?php echo "checked"; ?>
                                        <?php endif ?> > ภาษี 7 %
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-xs btn-primary">บันทึก</button>
                        </form>
                        <hr>
                        <form class="form-inline" action="<?php echo base_url('po_orders/update_order_add/'.$po_orders_data['id']); ?>" method="POST" role="form">
                            <label>sku</label>  <input type="text" class="form-control" id="sku" name="sku" value="">
            
                              <button type="submit" class="btn btn-xs btn-primary">เพิ่มสินค้า</button>
                                        
                              </form>
                               <hr>
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
                                        <td>action</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $sum_price=0; foreach ($po_orders_detail as $value): ?>
                                    <tr>

                                        <form class="form-inline" action="<?php echo base_url('po_orders/update_order_item/'.$po_orders_data['id'].'/'.$value['product_id']); ?>" method="POST" role="form">
                                         <td>
                                            <?php echo  $value['sku'] ?>
                                        </td>
                                        <td>
                                            <?php echo  $value['product_name'] ?>
                                        </td>
                                        <td>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $value['quantity']; ?>">
                                        </td>
                                        <td>
                                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $value['price']; ?>">
                                        </td>
                                        <td>
                                            <?php echo  $value['vat'] ?>
                                        </td>
                                        <td>
                                            <?php echo  $value['total']?>
                                        </td>
                                        <td>
                                         <button type="submit" class="btn btn-xs btn-primary">save</button>
                                         <a href="<?php echo base_url('po_orders/update_delete_item/'.$po_orders_data['id'].'/'.$value['product_id']); ?>"><span class="label label-danger">ลบ</span>  </a>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php $sum_price = $sum_price+($value['total']-$value['vat']); endforeach ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                 <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><strong>รวม</strong></td>
                                        <td class="text-right">
                                            <ins>
                                                <?php echo  $sum_price ?>
                                            </ins>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>vat</strong></td>
                                        <td class="text-right">
                                            <ins>
                                                <?php echo  $po_orders_data['vat'] ?>
                                            </ins>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>ค่าจัดส่ง</strong></td>
                                        <td class="text-right">
                                        <form class="form-inline" action="<?php echo base_url('po_orders/update_shipping_charge/'.$po_orders_data['id']); ?>" method="POST" role="form">
                                            <input type="text" class="form-control" id="shipping_charge" name="shipping_charge" value="<?php echo  $po_orders_data['shipping_charge'] ?>">
                            
                                              <button type="submit" class="btn btn-xs btn-primary">save</button>
                                                        
                                              </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>รวมทั้งหมด</strong></td>
                                        <td class="text-right">
                                            <ins class="text-right">
                                                <?php echo  $po_orders_data['total'] ?>
                                            </ins>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">สถานะสินค้า</div>
                    <div class="panel-body">
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
                                    <?php foreach ($po_order_status_history_list as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo  $value['po_order_status_name'] ?>
                                        </td>
                                        <th>
                                            <?php echo  $value['description'] ?>
                                        </th>
                                        <th>
                                            <?php echo date("d-m-Y H:i", strtotime($value['create_date']));?>
                                        </th>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
