<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">

        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title" ng-bind="items_stock[0].sku +' : '+ items_stock[0].product_name">Stock สินค้า </h3>
            </div>
            <div class="modal-body">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>เลขที่รับเข้า</th>
                                <th>status</th>
                                <th>วันที่รับเข้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="value in items_stock">
                                <td><span ng-bind="value.serial_number"></span></td>
                                <td><span ng-bind="value.receive_id"></span></span></td>
                                <td><span ng-bind="value.status_name"></span></td>
                                <td><span ng-bind="value.create_date"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
            </div>
        </script>


        <div class="page-header">
            <h1>Product<small> สินค้า </small></h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div role="tabpanel">
            <!-- Nav tabs -->
             <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาสินค้า</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มสินค้า</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url('products/search');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="search">รหัส + ชื่อ + Model + รายละเอียด</label>
                                        <input id="search" name="search"  value="<?php if(isset($data_search['search']))echo $data_search['search']; ?>" type="text" class="form-control input-md">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="select_brand">ยี่ห้อสินค้า</label>
                                        <select id="select_brand" name="select_brand" class="form-control">
                                            <option value="">ทั้งหมด</option>
                                            <?php foreach ($brands_list as $brand): ?>
                                                <?php if ($brand['id']==$data_search['product_brand_id']): ?>
                                                    <option value="<?php echo $brand['id']; ?>" selected><?php echo $brand['name']; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="select_type">หมวดสินค้า</label>
                                        <select id="select_type" name="select_type" class="form-control">
                                            <option value="">ทั้งหมด</option>
                                            <?php foreach ($type_list as $type): ?>
                                                <?php if ($type['id']==$data_search['product_type_id']): ?>
                                                    <option value="<?php echo $type['id']; ?>" selected><?php echo $type['name']; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-4" style="padding:0;">
                                        <div class="col-md-6">
                                            <label for="from_stock">สินค้าคงเหลือ</label>
                                            <input id="from_stock" name="from_stock" type="number"
                                                value="<?php if(isset($data_search['from_stock']))echo $data_search['from_stock']; else echo "0"; ?>" class="form-control input-md">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="to_stock">ถึง</label>
                                            <input id="to_stock" name="to_stock" type="number"
                                            value="<?php if(isset($data_search['to_stock']))echo $data_search['to_stock']; else echo "9999"; ?>" class="form-control input-md">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="promotion">โปรโมชั่น</label>
                                        <div class="checkbox">
                                            <label for="all_promotion">
                                                <input type="checkbox" name="all_promotion" id="all_promotion" value="1"
                                                    <?php if(isset($data_search['all_promotion'])) {if($data_search['all_promotion']==1) echo "checked";} ?> > ทั้งหมด
                                            </label>
                                            <label for="is_promotion">
                                                <input type="checkbox" name="is_promotion" id="is_promotion" value="1"
                                                 <?php if(isset($data_search['is_promotion'])) {if($data_search['is_promotion']==1) echo "checked";} ?> > ลดราคา
                                            </label>
                                            <label for="is_sale">
                                                <input type="checkbox" name="is_sale" id="is_sale" value="1"
                                                <?php if(isset($data_search['is_sale'])) {if($data_search['is_sale']==1) echo "checked";} ?> > แนะนำ
                                            </label>
                                            <label for="is_hot">
                                                <input type="checkbox" name="is_hot" id="is_hot" value="1"
                                                <?php if(isset($data_search['is_hot'])) {if($data_search['is_hot']==1) echo "checked";} ?>> ได้รับความนิยม
                                            </label>
                                            <label for="isactive-0">
                                                <input type="checkbox" name="isactive" id="isactive" value="1"
                                                 <?php if(isset($data_search['is_active'])) {if($data_search['is_active']==1) echo "checked";} ?> > ใช้งานสินค้า
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                                        </div>
                                        <select id="select_branch" name="select_branch" class="form-control" style="display: none;">
                                            <option value="">ทั้งหมด</option>
                                            <?php foreach ($branch_list as $branch): ?>
                                                <?php if ($branch['id']==$data_search['branch_id']): ?>
                                                    <option value="<?php echo $branch['id']; ?>" selected><?php echo $branch['name']; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $branch['id']; ?>"><?php echo $branch['name']; ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <div class="clearfix">
                    </div>
                    <div style="padding-top:30px;"></div>

                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#price" aria-controls="price" role="tab" data-toggle="tab"><i class="fa fa-tag" aria-hidden="true"></i> price</a>
                            </li>
                            <li role="presentation">
                                <a href="#export" aria-controls="export" role="tab" data-toggle="tab"><i class="fa fa-file-text-o" aria-hidden="true"></i> export stock</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="price">
                            <div style="padding-top:20px;"></div>
                                <form action="<?php echo base_url('products/updateprice');?>" method="post" accept-charset="utf-8" class="ng-pristine ng-valid">
                                    <fieldset>

                                       <div class="col-md-12" style="padding:0;">
                                            <div class="col-md-2">
                                                <label for="price">ราคาสินค้า</label>
                                                <input id="price" name="price" type="number"
                                                    value="" class="form-control input-md" required="true">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="dis_price">ราคาส่วนลด</label>
                                                <input id="dis_price" name="dis_price" type="number"
                                                value="" class="form-control input-md" required="true">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="member_discount">ราคา Dealer</label>
                                                <input id="member_discount" name="member_discount" type="number"
                                                value="" class="form-control input-md" required="true">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="member_discount_lv1">ราคา fanshine </label>
                                                <input id="member_discount_lv1" name="member_discount_lv1" type="number"
                                                value="" class="form-control input-md" required="true">
                                            </div>

                                            <div class="col-md-2" style="padding:0;">
                                                    <label for="to_stock"> </label><br>
                                                    <button type="submit"  name ="updateprice" class="btn btn-primary">ปรับปรุงราคา</button>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <div style="padding-top:20px;"></div>

                                    <?php if (isset($update)): ?>
                                        <h4 class="text-success">มีการแก้ไขราคาสินค้า</h4>
                                        <ul class="list-group">
                                           <?php echo $update ?>
                                        </ul>

                                    <?php endif ?>

                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>เลือก</th>
                                                    <th>Image</th>
                                                    <th>Detail</th>
                                                    <th>Price</th>
                                                    <th>promotion</th>
                                                    <th>Date</th>
                                                    <th>stock</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($products_list as $product): ?>
                                                    <tr>
                                                        <td>
                                                        <input type="hidden" name="productid_p[]" value="<?php echo $product['id'];?>">
                                                        <input type="hidden" name="name_p[]" value="<?php echo $product['name'];?>">
                                                        <input type="checkbox" name="check_p[]" value="<?php echo $product['id'];?>" checked>
                                                        </td>
                                                        <td><img src=" <?php echo $this->config->item('url_img').$product['image']; ?>" style="width:100px;" class="img-responsive" alt="Image">
                                                            <td>
                                                                <span>รหัส : </span>
                                                                <?php echo $product['sku'];?>
                                                                    <br/>
                                                                    <span>name : </span><strong><?php echo $product['name'];?></strong>
                                                                    <br/>
                                                                    <span>model : </span><?php echo $product['model'];?>
                                                                    <br/>
                                                                    <span>หมวด : </span>
                                                                <?php echo $product['type_name'];?>
                                                                    <br/>
                                                                    <span>brand : </span>
                                                                <?php echo $product['brand_name'];?>
                                                                    <br/>
                                                            </td>
                                                            <td>

                                                                <span>ราคา : </span><span class="text-success" ng-bind="<?php echo $product['price'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ลดราคา : </span><span class="text-danger" ng-bind="<?php echo $product['dis_price'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ราคา dealer : </span><span class="text-info" ng-bind="<?php echo $product['member_discount'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ราคา dealer fanshine : </span><span class="text-danger" ng-bind="<?php echo $product['member_discount_lv1'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                            </td>
                                                            <td>
                                                                <?php if ($product['is_promotion']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ลดราคา</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> ลดราคา</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                                <?php if ($product['is_sale']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> แนะนำ</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> แนะนำ</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                                <?php if ($product['is_hot']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ได้รับความนิยม</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> ได้รับความนิยม</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                            </td>
                                                            <td>
                                                                <span><i class="fa fa-calendar-o"></i> <?php echo  date("d-m-Y H:i", strtotime($product['create_date']));?></span>
                                                                <br/>
                                                                <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($product['modified_date']));?></span>
                                                                <br/>
                                                                   <?php if ($product['is_active']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ใช้งาน</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                            </td>
                                                            <td>
                                                                <?php if($product['stock'] < 5 && $product['stock'] != 0) { ?>
                                                                    <strong><span class="text-danger"><?php echo $product['stock'];?> <i class="fa fa-caret-down"></i></span></strong>
                                                                <?php } else if ($product['stock'] > 4) {?>
                                                                    <strong><span class="text-success"><?php echo $product['stock'];?> <i class="fa fa-caret-up"></i></span></strong>
                                                                <?php  }?>
                                                                <?php if ($product['stock'] == 0): ?>
                                                                    <strong><span class="text-danger">0</span></strong>
                                                                <?php endif ?>
                                                                <?php if ($product['stock'] > 0): ?>
                                                                     <button type="button" class="btn btn-xs btn-info" ng-click="open(<?php echo $product['id'];?>)">แยกตาม Serial</button>

                                                                <?php endif ?>

                                                            </td>
                                                            <td><a class="btn btn-xs btn-info" href="<?php echo base_url('products/edit/'.$product['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                                <?php if(isset($links_pagination)) {echo $links_pagination;} ?>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="export">
                                <div style="padding-top:20px;"></div>
                                 <form action="<?php echo base_url('products/export_stock');?>" method="post" accept-charset="utf-8" class="ng-pristine ng-valid">
                                    <fieldset>

                                       <div class="col-md-12" style="padding:0;">

                                            <div class="col-md-2">
                                                    <input type="checkbox" name="all_product" value="1"> สินค้าทั้งหมด
                                            </div>

                                            <div class="col-md-2">
                                                    <label for="to_stock"> </label><br>
                                                    <button type="submit" class="btn btn-primary">export stock</button>
                                            </div>
                                        </div>
                                        <p class="text-warning">ใช้แบบเลือกสินค้าไม่เกิน 300 items</p>

                                    </fieldset>
                                    <div style="padding-top:20px;"></div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>เลือก</th>
                                                    <th>Image</th>
                                                    <th>Detail</th>
                                                    <th>Price</th>
                                                    <th>promotion</th>
                                                    <th>Date</th>
                                                    <th>stock</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($products_list as $product): ?>
                                                    <tr>
                                                        <td>
                                                        <input type="hidden" name="productid_p[]" value="<?php echo $product['id'];?>">
                                                        <input type="hidden" name="name_p[]" value="<?php echo $product['name'];?>">
                                                        <input type="checkbox" name="check_p[]" value="<?php echo $product['id'];?>" checked>
                                                        </td>
                                                        <td><img src=" <?php echo $this->config->item('url_img').$product['image']; ?>" style="width:100px;" class="img-responsive" alt="Image">
                                                            <td>
                                                                <span>รหัส : </span>
                                                                <?php echo $product['sku'];?>
                                                                    <br/>
                                                                    <span>name : </span><strong><?php echo $product['name'];?></strong>
                                                                    <br/>
                                                                    <span>model : </span><?php echo $product['model'];?>
                                                                    <br/>
                                                                    <span>หมวด : </span>
                                                                <?php echo $product['type_name'];?>
                                                                    <br/>
                                                                    <span>brand : </span>
                                                                <?php echo $product['brand_name'];?>
                                                                    <br/>
                                                            </td>
                                                            <td>

                                                                <span>ราคา : </span><span class="text-success" ng-bind="<?php echo $product['price'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ลดราคา : </span><span class="text-danger" ng-bind="<?php echo $product['dis_price'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ราคา dealer : </span><span class="text-info" ng-bind="<?php echo $product['member_discount'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                                <span>ราคา dealer fanshine : </span><span class="text-danger" ng-bind="<?php echo $product['member_discount_lv1'];?> | currency:'฿':0"></span>
                                                                <br/>
                                                            </td>
                                                            <td>
                                                                <?php if ($product['is_promotion']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ลดราคา</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> ลดราคา</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                                <?php if ($product['is_sale']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> แนะนำ</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> แนะนำ</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                                <?php if ($product['is_hot']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ได้รับความนิยม</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span><i class="fa fa-times"></i> ได้รับความนิยม</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                            </td>
                                                            <td>
                                                                <span><i class="fa fa-calendar-o"></i> <?php echo  date("d-m-Y H:i", strtotime($product['create_date']));?></span>
                                                                <br/>
                                                                <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($product['modified_date']));?></span>
                                                                <br/>
                                                                   <?php if ($product['is_active']=="1"): ?>
                                                                    <span><i class="fa fa-check"></i> ใช้งาน</span>
                                                                    <br/>
                                                                <?php else: ?>
                                                                    <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                                                    <br/>
                                                                <?php endif ?>
                                                            </td>
                                                            <td>
                                                                <?php if($product['stock'] < 5 && $product['stock'] != 0) { ?>
                                                                    <strong><span class="text-danger"><?php echo $product['stock'];?> <i class="fa fa-caret-down"></i></span></strong>
                                                                <?php } else if ($product['stock'] > 4) {?>
                                                                    <strong><span class="text-success"><?php echo $product['stock'];?> <i class="fa fa-caret-up"></i></span></strong>
                                                                <?php  }?>
                                                                <?php if ($product['stock'] == 0): ?>
                                                                    <strong><span class="text-danger">0</span></strong>
                                                                <?php endif ?>
                                                                <?php if ($product['stock'] > 0): ?>
                                                                     <button type="button" class="btn btn-xs btn-info" ng-click="open(<?php echo $product['id'];?>)">แยกตาม Serial</button>

                                                                <?php endif ?>

                                                            </td>
                                                            <td><a class="btn btn-xs btn-info" href="<?php echo base_url('products/edit/'.$product['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                                <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url('products/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="sku">รหัส</label>
                                <div class="col-md-4">
                                    <input id="sku" name="sku" type="text" placeholder="รหัสสินค้า" class="form-control input-md" required="">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">ชื่อ</label>
                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" placeholder="ชื่้อสินค้า" class="form-control input-md" required="">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="model">Model</label>
                                <div class="col-md-6">
                                    <input id="model" name="model" type="text" placeholder="model" class="form-control input-md">
                                </div>
                            </div>
                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="select_brand">ยี่ห้อสินค้า</label>
                                <div class="col-md-4">
                                    <select id="select_brand" name="select_brand" class="form-control">
                                    <?php
                                        foreach ($brands_list as $brand) {
                                            echo '<option value="'.$brand["id"].'">'.$brand["name"].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="select_type">หมวดสินค้า</label>
                                <div class="col-md-4">
                                    <select id="select_type" name="select_type" class="form-control">
                                    <?php
                                        foreach ($type_list as $type) {
                                            echo '<option value="'.$type["id"].'">'.$type["name"].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="price">ราคา</label>
                                <div class="col-md-4">
                                    <input id="price" name="price" type="number" placeholder="ราคา" class="form-control input-md">
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="dis_price">ลดราคา</label>
                                <div class="col-md-4">
                                    <input id="dis_price" name="dis_price" type="number" placeholder="ราคาส่วนลด" class="form-control input-md">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="member_discount">ราคา dealer</label>
                                <div class="col-md-4">
                                    <input id="member_discount" name="member_discount" type="number" placeholder="ราคา Dealer" class="form-control input-md">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="member_discount_lv1">ราคา fanshine</label>
                                <div class="col-md-4">
                                    <input id="member_discount_lv1" name="member_discount_lv1" type="number" placeholder="ราคา fanshine" class="form-control input-md">
                                </div>
                            </div>


                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="warranty">ระยะประกัน</label>
                                <div class="col-md-4">
                                    <input id="warranty" name="warranty" type="text" placeholder="warranty" class="form-control input-md">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="weight">น้ำหนัก</label>
                                <div class="col-md-4">
                                    <input id="weight" name="weight" type="number" placeholder="น้ำหนัก" class="form-control input-md">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="stock">สินค้าคงเหลือ</label>
                                <div class="col-md-4">
                                    <input id="stock" name="stock" type="number" placeholder="สินค้าคงเหลือ" class="form-control input-md">
                                </div>
                            </div>
                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="promotion">โปรโมชั่น</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="is_promotion">
                                            <input type="checkbox" name="is_promotion" id="is_promotion" value="1"> ลดราคา
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="is_sale">
                                            <input type="checkbox" name="is_sale" id="is_sale" value="1"> แนะนำ
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label for="is_hot">
                                            <input type="checkbox" name="is_hot" id="is_hot" value="1"> ได้รับความนิยม
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="detail">รายละเอียด</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="detail" name="detail"></textarea>
                                </div>
                            </div>
                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="image_field">รูปตัวอย่าง</label>
                                <div class="col-md-6">
                                    <input id="image_field" name="image_field" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1">
                                </div>
                            </div>
                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="image_field_mul">รูปสินค้า</label>
                                <div class="col-md-6">
                                    <?php for ($i=1; $i < 11  ; $i++){ ?>
                                        <p>
                                            <input id="image_field_<?php echo $i; ?>" name="image_field_<?php echo $i; ?>" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1">
                                        </p>
                                    <?php } ?>
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
