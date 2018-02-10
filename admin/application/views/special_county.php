<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>สถานที่พิเศษ</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาสถานที่พิเศษ</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มสถานที่พิเศษ</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('special_county/search');?>" method="POST" class="form-inline" role="form">
                    
                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="วิธีจัดส่ง">
                        </div>
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>วิธีจัดส่ง</th>
                                    <th>สถานที่</th>
                                    <th>รายละเอียด</th>
                                    <th>ราคา</th>
                                    <th>สถานะ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($special_county_list as $special_county): ?>
                                <tr>
                                    <td>
                                        <span><strong><?php echo $special_county['shipping_method_name'] ?></strong></span><br/> 
                                    </td> 

                                    <td>
                                        <span>จังหวัด : </span><strong><?php echo $special_county['province_name'] ?></strong><br/>
                                        <span>อำเภอ : </span><strong><?php echo $special_county['amphur_name'] ?></strong><br/>

                                    </td>
                                    <td>
                                        <span><?php echo $special_county['description'] ?></span>
                                    </td>
                                    <td>
                                        <span><strong><?php echo $special_county['price'] ?></strong></span><br/> 
                                    </td>
                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($special_county['modified_date']));?></span>
                                        <br/>
                                        <?php if ($special_county['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td><a class="btn btn-xs btn-danger" href="<?php echo base_url('special_county/delete/'.$special_county['amphur_id']."/".$special_county['shipping_method_id']) ?>" role="button"><i class="fa fa-trash-o"></i> ลบ</a></td>       
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url('special_county/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                         <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="shipping_method_id">วิธีจัดส่ง</label>
                                <div class="col-md-4">
                                    <select id="shipping_method_id" name="shipping_method_id" class="form-control">
                                    <?php 
                                        foreach ($shipping_method_list as $shipping) {
                                            echo '<option value="'.$shipping["id"].'">'.$shipping["name"].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-md-3 control-label" for="province">จังหวัด</label>
                                <div class="col-md-4">
                                    <select id="province" name="province" class="form-control" ng-model="province" ng-change="changeProvince()">
                                    <?php 
                                        foreach ($province_list as $province) {
                                            echo '<option value="'.$province["id"].'">'.$province["name"].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="amphur_id">อำเภอ</label>
                                <div class="col-md-4">
                                    <select id="amphur_id" name="amphur_id" class="form-control" ng-model="amphur_id">
                                     <option ng-repeat="amphur in items" value="{{amphur.id}}">{{amphur.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="price">ราคา</label>
                                <div class="col-md-6">
                                    <input id="price" name="price" type="text" placeholder="price" class="form-control input-md" required="">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="description">รายละเอียด</label>
                                <div class="col-md-6">
                                    <input id="description" name="description" type="text" placeholder="description" class="form-control input-md">
                                </div>
                            </div>
               
                           
 
                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="isactive-0">
                                            <input type="checkbox" name="isactive" id="isactive-0" value="1" checked> ใช้งาน
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