<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
            <h1>ใบสั่งซื้อสินค้า</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="<?php echo base_url('orders/search');?>" method="POST" class="form-inline" role="form">

            <div class="form-group">
                <label class="sr-only" for="">เลขที่ใบเสร็จ</label>
                <input type="number" class="form-control" id="order_id" name="order_id" placeholder="เลขที่ใบเสร็จ">
            </div>
            <select id="select_status" name="select_status" class="form-control">
                <?php foreach ($order_status_list as $status): ?>
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
            <table class="table table-striped">
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
                <?php foreach ($orders_list as $orders): ?>
                    <tr>
                        <td>

                           <?php
                            switch ($orders['order_status_id']) {
                            case '1':
                                echo '<strong class="label label-warning"> <i class="fa fa-clock-o" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                                break;
                           case '2':
                            echo '<strong class="label label-info"><i class="fa fa-spinner" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                           break;
                           case '3':
                           echo '<strong class="label label-danger"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                           break;
                               case '4':
                                   echo '<strong class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                                   break;
                                   case '5':
                                   echo '<strong class="label label-default"><i class="fa fa-ban" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                                   break;

                               default:
                                   echo '<strong class="label label-default"><i class="fa fa-repeat" aria-hidden="true"></i> '.$orders['order_status_name'].'</strong><br/>';
                                   break;
                           }
                           ?>
                            <?php if (isset($orders['trackpost']) && $orders['trackpost'] !="") : ?>
                                  <span class="label label-primary">traking : <?php echo $orders['trackpost'];?></span><br/>
                            <?php endif ?>
                            <?php if (isset($orders['image_slip_own']) || isset($orders['image_slip_customer'])): ?>
                                  <a class="label label-info" href="<?php echo base_url('orders/edit/'.$orders['id']) ?>"><i class="fa fa-paper-plane" aria-hidden="true"> สลิป</i></a><br/>
                            <?php endif ?>
                            <?php if ($orders['is_invoice'] == 1): ?>
                                  <a href="<?php echo  base_url('orders/invoice/'.$orders['id']); ?>" class="label label-primary" >ใบกำกับภาษี : <?php echo $orders['invoice_docno'] ?></a><br/>
                            <?php endif ?>
                        </td>
                        <td>
                            <span>เลขที่ใบสั่งซื้อ : <strong>#<?php echo $orders['id'] ?></strong></span><br/>
                            <span>โดย : <strong><?php echo $orders['name'] ?></strong></span><br/>
                            <span>วันที่สร้าง : <i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($orders['date']));?></span><br/>
                            <?php if (isset($orders['user_name'] )): ?>
                              <span>เปิดโดย : <strong><?php echo $orders['user_name'] ?></strong></span><br/>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span><strong><?php echo $orders['quantity'] ?></strong> item</span><br/>
                        </td>
                        <td>
                            <strong>ที่อยู่ : </strong><span><?php echo $orders['address']; ?></span><br/>
                            <strong>วิธีการจัดส่ง : </strong><span><?php echo $orders['shipping']; ?></span><br/>
                            <strong>อีเมลล์ : </strong><span><?php echo $orders['email']; ?></span><br/>
                            <strong>เบอร์โทร : </strong><span><?php echo $orders['tel']; ?></span><br/>
                            <?php if ($orders['is_tax']=="1"): ?>
                                <h4>ออกใบกำภาษี</h4>
                                 <strong>เลขที่ผุ้เสียภาษี : </strong><span><?php echo $orders['tax_id']; ?></span><br/>
                                 <strong>บริษัท : </strong><span><?php echo $orders['tax_company']; ?></span><br/>
                                <strong>ที่อยู่ : </strong><span><?php echo $orders['tax_address']; ?></span><br/>

                            <?php endif ?>

                        </td>

                        <td>
                             <strong ng-bind="<?php echo $orders['total'];?> | currency:'฿':0"></strong>
                        </td>
                        <td>
                          <a class="btn btn-sm btn-warning" href="<?php echo base_url('orders/edit/'.$orders['id']) ?>" role="button"> <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-info" target="_blank"  href="<?php echo  $this->config->item('weburl').'invoice/'.$orders['ref_id'] ?>" role="button">
                            <i class="fa fa-eye"></i>
                          </a>
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
