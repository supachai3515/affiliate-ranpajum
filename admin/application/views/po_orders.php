<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>ใบเสนอราคา</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="<?php echo base_url('po_orders/search');?>" method="POST" class="form-inline" role="form">

            <div class="form-group">
                <label class="sr-only" for="">เลขที่ใบเสนอราคา</label>
                <input type="number" class="form-control" id="po_order_id" name="po_order_id" placeholder="เลขที่ใบเสนอราคา">
            </div>
            <select id="select_status" name="select_status" class="form-control">
                <?php foreach ($po_order_status_list as $status): ?>
                        <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                <?php endforeach ?>
                <option value="0" selected>ทั้งหมด</option>
            </select>

            <div class="form-group">
                <label class="sr-only" for="">search</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="ชื่อ , tracking">
            </div>

            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>สถานะ</th>
                        <th>#</th>
                        <th>จำนวน</th>
                        <th>ส่งไปยัง</th>
                        <th>รวม</th>
                        <th>ดู</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($po_orders_list as $po_orders): ?>
                    <tr>
                        <td>

                        <strong class="label label-<?php echo $po_orders['priority_color'] ?>"> <i class="<?php echo $po_orders['icon_font'] ?>" aria-hidden="true"></i> <?php echo $po_orders['po_order_status_name'] ?></strong><br/><br/>
                        <?php if ($po_orders['is_invoice']== 0): ?>

                            <a target="_blank" class="btn btn-xs btn-default" href="<?php echo  $this->config->item('weburl').'/po_invoice/'.$po_orders['ref_id'] ?>" role="button">
                                 ใบเสนอราคา
                                </a>
                        <?php else: ?>
                            <a target="_blank" class="btn btn-xs btn-success" href="<?php echo  $this->config->item('weburl').'/po_invoice/'.$po_orders['ref_id'] ?>" role="button">
                                 ใบสั่งซื้อ
                                </a>
                        <?php endif ?>


                        </td>
                        <td>
                            <?php if ($po_orders['is_invoice'] == 0): ?>
                               <span>เลขที่ใบเสนอราคา : <strong>#<?php echo $po_orders['id'] ?></strong></span><br/>
                            <?php else: ?>
                               <span>เลขที่ใบสั่งซื้อ : <strong>#<?php echo $po_orders['invoice_docno'] ?></strong></span><br/>
                            <?php endif ?>
                            <span>โดย : <strong><?php echo $po_orders['name'] ?></strong></span><br/>
                            <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($po_orders['date']));?></span>

                        </td>
                        <td>
                            <span><strong><?php echo $po_orders['quantity'] ?></strong> item</span><br/>
                        </td>
                        <td>
                            <strong>ที่อยู่ : </strong><span><?php echo $po_orders['address']; ?></span><br/>
                            <strong>วิธีการจัดส่ง : </strong><span><?php echo $po_orders['shipping']; ?></span><br/>
                            <strong>อีเมลล์ : </strong><span><?php echo $po_orders['email']; ?></span><br/>
                            <strong>เบอร์โทร : </strong><span><?php echo $po_orders['tel']; ?></span><br/>
                            <?php if ($po_orders['is_tax']=="1"): ?>
                                <h4>ออกใบกำภาษี</h4>
                                 <strong>เลขที่ผุ้เสียภาษี : </strong><span><?php echo $po_orders['tax_id']; ?></span><br/>
                                 <strong>บริษัท : </strong><span><?php echo $po_orders['tax_company']; ?></span><br/>
                                <strong>ที่อยู่ : </strong><span><?php echo $po_orders['tax_address']; ?></span><br/>

                            <?php endif ?>

                        </td>

                        <td>
                             <strong ng-bind="<?php echo $po_orders['total'];?> | currency:'฿':0"></strong>
                        </td>
                        <td>
                        <a class="btn btn-xs btn-info" href="<?php echo base_url('po_orders/edit/'.$po_orders['id']) ?>" role="button"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
