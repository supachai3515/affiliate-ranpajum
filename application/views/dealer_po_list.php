<section class="slider-category-area">
    <div class="container" ng-controller="mainCtrl_po">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- breadcrumbs start-->
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo  base_url('dealer'); ?>">Dealer</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>ใบเสนอราคาย้อนหลัง</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>

                <div class="row">
                    <div class="col-sm-3">
                        <?php $this->load->view('template/dealer-menu', $data); ?>
                    </div>
                    <div class="col-sm-9">
                         <?php if (isset($dealerInfo['verify']) ): ?>
                        <?php if ($dealerInfo['verify'] == 0): ?>
                            <?php echo '<p class="text-center"><strong class=" text-danger">กรุณารอทางร้านตรวจสอบการสมัครก่อน หากมีข้อสงสัยกรุณาติดต่อทางร้าน</strong></p>';?>
                        <?php endif ?>
                        
                        <?php endif ?>
                        <?php if (count($po_orderList) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ข้อมูลการจัดส่ง</th>
                                            <th>ยอดรวม</th>                             
                                            <th>link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($po_orderList as $value): ?>
                                        <tr>
                                            <td>
                                                <strong>วันที่ : </strong><?php echo $value['date'];?><br/>
                                                <strong>เลขที่ใบสั่งซื้อ : </strong>#<?php echo $value['id'];?><br/>
                                                <a href="<?php echo base_url('po_status/'.$value['ref_id']);?>" target="_bank">
                                                    <strong class="text-success">สะถานะสินค้า <i class="fa fa-angle-double-right" aria-hidden="true"></i></strong>
                                                </a>
                                            </td>
                                            <td>
                                                <strong>ชื่อ : </strong><?php echo $value['name'];?><br/>
                                                <strong>ที่อยู่จัดส่ง : </strong><?php echo $value['address'];?><br/>
                                                <strong>Tracking : </strong><?php echo $value['trackpost'];?><br/>
                                            </td>
                                            <td>
                                                <span class="amount"><?php echo number_format($value["total"]); ?></span>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('po_invoice/'.$value['ref_id']);?>" target="_bank">
                                                    <button type="button" class="btn btn-xs btn-default">ดูใบเสร็จ</button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <?php echo '<p class="text-center"><strong class="text-center">ยังไม่มีรายการสั่งซื้อ</strong></p>';?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="container-fluid">
                    <div style="height: 100px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
