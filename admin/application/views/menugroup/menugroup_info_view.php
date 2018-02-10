<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View info Menu Groups
      <small>กลุ่มเมนูผู้ใช้</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('menugroup'); ?>"> Menu Group</a></li>
      <li class="active">View Menu Group</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">  View info Menu Groups : (<?php echo $menugroup_data['menu_group_id']; ?>)</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                <form role="form"  role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $menugroup_data['name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $menugroup_data['menu_group_id']; ?>" name="menu_group_id" id="menu_group_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $menugroup_data['description']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Create By</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $menugroup_data['create_by_name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $menugroup_data['menu_group_id']; ?>" name="menu_group_id" id="menu_group_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Create Date</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $menugroup_data['create_date']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Modified By</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $menugroup_data['modified_by_name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $menugroup_data['menu_group_id']; ?>" name="menu_group_id" id="menu_group_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Modified Date</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $menugroup_data['modified_date']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <?php if ($menugroup_data['is_active'] == 1): ?>
                                      <input type="checkbox"  id="is_active"  name="is_active" value="1" checked="true" disabled="true"> ใช้งาน
                                    <?php else: ?>
                                      <input type="checkbox"  id="is_active"  name="is_active" value="1" disabled="true"> ใช้งาน
                                    <?php endif; ?>
                                  </label>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $menugroup_data['name'] ?> (<?php echo $menugroup_data['menu_group_id'] ?>)</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>รหัส</th>
                  <th>ชื่อ</th>
                  <th class="text-center">Add</th>
                  <th class="text-center">Edit</th>
                  <th class="text-center">View</th>
                  <th class="text-center">Active</th>
                </tr>
                <?php foreach ($menu_group_detail as $row): ?>
                <tr>
                    <td><?php echo $row['menu_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td class="text-center">
                      <?php if ($row['is_add']=="1"): ?>
                          <span><i class="fa fa-check"></i></span>
                      <?php else: ?>
                          <span class="text-danger"><i class="fa fa-times"></i></span>
                      <?php endif ?>
                    </td>
                    <td class="text-center">
                      <?php if ($row['is_edit']=="1"): ?>
                          <span><i class="fa fa-check"></i></span>
                      <?php else: ?>
                          <span class="text-danger"><i class="fa fa-times"></i></span>
                      <?php endif ?>
                    </td>
                    <td class="text-center">
                      <?php if ($row['is_view']=="1"): ?>
                          <span><i class="fa fa-check"></i></span>
                      <?php else: ?>
                          <span class="text-danger"><i class="fa fa-times"></i></span>
                      <?php endif ?>
                    </td>
                    <td class="text-center">
                      <?php if ($row['is_active']=="1"): ?>
                          <span><i class="fa fa-check"></i></span>
                      <?php else: ?>
                          <span class="text-danger"><i class="fa fa-times"></i></span>
                      <?php endif ?>
                    </td>
                </tr>
                <?php endforeach; ?>
              </table>

            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
