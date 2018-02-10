<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Menu Groups
      <small>กลุ่มเมนูผู้ใช้</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Menu Group</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-12 text-right">
              <div class="form-group">
                  <a class="btn btn-primary" href="<?php echo base_url(); ?>menugroup/add"><i class="fa fa-plus"></i> Add New</a>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">Menu Groups List</h3>
                  <div class="box-tools">
                      <form action="<?php echo base_url() ?>menugroup" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </form>
                  </div>
              </div><!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>รายละเอียด</th>
                    <th>วันที่สร้าง</th>
                    <th>วันที่แก้ไข</th>
                    <th>สถานะ</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <?php foreach ($menugroup_list as $record): ?>
                  <tr>
                    <td><?php echo $record->menu_group_id ?></td>
                    <td><?php echo $record->name ?></td>
                    <td><?php echo $record->description ?></td>
                    <td><span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($record->create_date));?></span></td>
                    <td><span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($record->modified_date));?></span></td>
                    <td>
                        <?php if ($record->is_active=="1"): ?>
                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                        <?php else: ?>
                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                        <?php endif ?>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm bg-navy" href="<?php echo base_url().'menugroup/set_menu/'.$record->menu_group_id; ?>"><i class="fa fa-sliders" aria-hidden="true"> Set Menu</i></a>
                        <a class="btn btn-sm btn-warning" href="<?php echo base_url().'menugroup/edit/'.$record->menu_group_id; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'menugroup/view/'.$record->menu_group_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </table>

              </div><!-- /.box-body -->
              <div class="box-footer clearfix">
                  <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
              </div>
            </div><!-- /.box -->
          </div>
      </div>
  </section>
  <!-- /.content -->
</div>
