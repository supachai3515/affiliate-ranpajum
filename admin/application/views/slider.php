<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>slider<small></small></h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ</th>
                        <th>รายละเอียด</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($slider_list as $slider): ?>
                    <tr>
                        <td>
                            <span>รหัส : <strong><?php echo $slider['id'] ?></strong></span><br/>

                        </td>
                        <td>
                            <span>name : <strong><?php echo $slider['name'] ?></strong></span><br/>
                        </td>
                        <td>
                            <span><?php echo $slider['description']; ?></span>
                           
                        </td>
                           
                        <td>
                             <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($slider['modified_date']));?></span>
                            <br/>
                            <?php if ($slider['is_active']=="1"): ?>
                                <span><i class="fa fa-check"></i> ใช้งาน</span>
                                <br/>
                            <?php else: ?>
                                <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                <br/>
                            <?php endif ?>
                        </td>
                        <td><a class="btn btn-xs btn-info" href="<?php echo base_url('slider/edit/'.$slider['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>       
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