<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>รายงาน
            <?php if($this->uri->segment(2) != ''){?><small style="float:right"><a href="<?php echo base_url('report');?>"><button style="color:#000;">โชว์ข้อมูลทั้งหมด</button></a></small><?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="<?php echo base_url('report/search');?>" method="POST" class="form-inline" role="form">

            <div class="form-group">
                <label class="sr-only" for="">search</label>
                <input type="text" class="form-control" id="date" name="date" placeholder="เวลา">
            </div>

            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>รายละเอียด</th>
                        <th>ที่อยู่</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($members_list as $member): ?>
                    <tr>
                        <td>
                            <strong>Name: </strong><?php echo $member['first_name'].' '.$member['last_name']; ?><br/>
                            <strong>Username: </strong><?php echo $member['username']; ?><br/>
                            <strong>Password: </strong><?php echo $member['password']; ?>

                        </td>
                        <td>
                            <strong>Mobile: </strong><?php echo $member['mobile']; ?><br/>
                            <strong>Tel: </strong><?php echo $member['tel']; ?><br/>
                            <strong>Email: </strong><?php echo $member['email']; ?>
                        </td>
                        <td>
                            <b>ที่อยู่จัดส่งสินค้า</b> <br/>
                            <span><?php echo $member['address_receipt']; ?></span>
                            <hr/>
                            <b>ที่อยู่ใบกำกับภาษี</b> <br/>
                            <span><?php echo $member['address_tax']; ?></span><br/>
                            <?php if (isset($member['tax_number'])): ?>
                                 <b>Tax number :</b>  <span><?php echo $member['tax_number']; ?></span>
                            <?php endif ?>

                        </td>
                        <td>
                             <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($member['date']));?></span>
							<br/>
                               <?php if ($member['verify']=="1"): ?>
                                <span class="text-success"><i class="fa fa-check"></i> ยืนยันแล้ว</span>
                                <br/>
                            <?php else: ?>
                                <span class="text-danger"><i class="fa fa-times"></i> ยังไม่ได้ยืนยัน</span>
                                <br/>
                                <a class="btn btn-xs btn-info" href="<?php echo base_url('members/confirm/'.$member['id']) ?>" role="button"> ยืนยัน Dealer</a><br/>
                            <?php endif ?>

                               <?php if ($member['is_active']=="1"): ?>
                                <span><i class="fa fa-check"></i> ใช้งาน</span>
                                <br/>
                            <?php else: ?>
                                <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                <br/>
                            <?php endif ?>

                             <?php if ($member['is_lavel1']=="1"): ?>
                                <span><i class="fa fa-check"></i> Dealer fanshine</span>
                            <?php endif ?>

                        </td>
                        <td><a class="btn btn-xs btn-info" href="<?php echo base_url('members/edit/'.$member['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
<!-- /.content -->
