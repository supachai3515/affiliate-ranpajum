<div class="content-wrapper">
  <section class="content">
<?php $chk_admin_id =  $this->session->userdata('permission_id'); ?>
<?php if ($chk_admin_id == "1"): ?>
     <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
            <h1>ผู้ใช้</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาผู้ใช้</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มผู้ใช้</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อ</th>
                                    <th>สถานะ</th>
                                    <th>สิทธิ์การใช้</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($account_list as $account): ?>
                                <tr>
                                    <td>
                                        <span>รหัส : <strong><?php echo $account['id'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                        <span>Name : <strong><?php echo $account['first_name']." ".$account['last_name'] ?></strong></span><br/>
                                        <span>Email : <strong><?php echo $account['email_address']?></strong></span><br/>
                                        
                                    </td> 
                                    <td>
                                        <span>Username : <strong><?php echo $account['username'] ?></strong></span><br/>
                                        <span>Password : <strong><?php echo $account['password']?></strong></span><br/>
                                    </td>
                                    <td>
                                        <strong><?php echo $account['permission_id'] ?></strong>
                                    </td>
                                    <td><a class="btn btn-xs btn-info" href="<?php echo base_url('account/edit/'.$account['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>       
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" action="<?php echo base_url('account/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="first_name">first name</label>
                                <div class="col-md-6">
                                    <input id="first_name" name="first_name" type="text" placeholder="first_name" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="last_name">last name</label>
                                <div class="col-md-6">
                                    <input id="last_name" name="last_name" type="text" placeholder="last_name" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email_address">email address</label>
                                <div class="col-md-6">
                                    <input id="email_address" name="email_address" type="email" placeholder="email_address" class="form-control input-md" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">username</label>
                                <div class="col-md-6">
                                    <input id="username" name="username" type="text" placeholder="username" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="password">password</label>
                                <div class="col-md-6">
                                    <input id="password" name="password" type="text" placeholder="password" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="permission_id">permission</label>
                                <div class="col-md-6">
                                    <input id="permission_id" name="permission_id" type="number" placeholder="permission_id" class="form-control input-md" required>
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
    <?php else: ?>
        <p class="text-danger text-center">ไม่มีสิทธิ์เข้าถึง</p>
<?php endif ?>
   
</div>
</section>
<!-- /.content -->