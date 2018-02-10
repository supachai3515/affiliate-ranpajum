<div class="content-wrapper">
  <section class="content">
<?php $chk_admin_id =  $this->session->userdata('permission_id'); ?>
<?php if ($chk_admin_id == "1"): ?>
    <div class="container-fluid box" ng-controller="myCtrl">
        <div class="page-header">
          <h1>แก้ไขผู้ใช้</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('account/update/'.$account_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $account_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">

          </div>
        </div>


        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-3 control-label" for="first_name">first name</label>
            <div class="col-md-6">
                <input id="first_name" name="first_name" type="text" value="<?php echo $account_data['first_name']; ?>" placeholder="first_name" class="form-control input-md" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="last_name">last name</label>
            <div class="col-md-6">
                <input id="last_name" name="last_name" type="text" value="<?php echo $account_data['last_name']; ?>" placeholder="last_name" class="form-control input-md" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="email_address">email address</label>
            <div class="col-md-6">
                <input id="email_address" name="email_address" type="email" value="<?php echo $account_data['email_address']; ?>" placeholder="email_address" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="name">username</label>
            <div class="col-md-6">
                <input id="username" name="username" type="text" value="<?php echo $account_data['username']; ?>" placeholder="username" class="form-control input-md" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="password">password</label>
            <div class="col-md-6">
                <input id="password" name="password" type="text" value="<?php echo $account_data['password']; ?>" placeholder="password" class="form-control input-md" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="permission_id">permission</label>
            <div class="col-md-6">
                <input id="permission_id" name="permission_id" type="number" value="<?php echo $account_data['permission_id']; ?>" placeholder="permission_id" class="form-control input-md" required>
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
    <!-- /.container-fluid box -->
<?php else: ?>
    <p class="text-danger text-center">ไม่มีสิทธิ์เข้าถึง</p>
<?php endif ?>
</section>
</div>
<!-- /.content -->
