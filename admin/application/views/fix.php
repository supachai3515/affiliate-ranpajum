<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>รายการซ่อม</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหารายการซ่อม</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มรายการซ่อม</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('fix/search');?>" method="POST" class="form-inline" role="form">
                    
                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="ชื่อ">
                        </div>
                
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อ</th>
                                    <th>สถานะ</th>
                                    <th>เรียงลำดับ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fix_list as $fix): ?>
                                <tr>
                                    <td>
                                        <span>รหัส : <strong><?php echo $fix['id'] ?></strong></span><br/>
                    
                                    </td>
                                    <td>
                                        <span>name : <strong><?php echo $fix['name'] ?></strong></span><br/>
                                        <span>ระยะเวลา : <strong><?php echo $fix['duration'] ?></strong></span><br/>
                                        <span>ราคา : <strong><?php echo $fix['price'] ?></strong></span><br/>
                                    </td> 
                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($fix['modified_date']));?></span>
                                        <br/>
                                        <?php if ($fix['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <span><strong><?php echo $fix['orderby'] ?></strong></span><br/>

                                    </td>
                                    <td><a class="btn btn-xs btn-info" href="<?php echo base_url('fix/edit/'.$fix['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>       
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url('fix/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">ชื่อ</label>
                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" placeholder="name" class="form-control input-md" required="">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="description">รายละเอียด</label>
                                <div class="col-md-6">
                                    <input id="description" name="description" type="text" placeholder="รายละเอียด" class="form-control input-md" required="">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="duration">ระยะเวลา</label>
                                <div class="col-md-6">
                                    <input id="duration" name="duration" type="text" placeholder="ระยะเวลา" class="form-control input-md" required="">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="price">ราคา</label>
                                <div class="col-md-6">
                                    <input id="price" name="price" type="number" placeholder="ราคา" class="form-control input-md" required="">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="orderby">เรียงลำดับ</label>
                                <div class="col-md-6">
                                    <input id="orderby" name="orderby" type="number" placeholder="เรียงลำดับ" class="form-control input-md" required="">
                                </div>
                            </div>

              
                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="isactive-0">
                                            <input type="checkbox" name="isactive" id="isactive-0" value="1" checked> ใช้งานสินค้า
                                        </label>
                                    </div>
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
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->