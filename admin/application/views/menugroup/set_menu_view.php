<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" ng-controller="set_menu">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Set Menu Group {{firstName}}
      <small>ตั้งค่าเมนู</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('menugroup'); ?>"> Menu Group</a></li>
      <li class="active">Set Menu</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-xs-6">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">Menu List</h3>
              </div><!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>วันที่สร้าง</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <tr ng-repeat="menu in menu_list">
                    <td><span ng-bind="menu.menu_id"></span></td>
                    <td><span ng-bind="menu.name"></span></td>
                    <td><span><i class="fa fa-calendar"></i> <span ng-bind="menu.create_date"></span></span></td>
                    <td class="text-center">
                        <a class="btn btn-sm bg-navy" ng-click="inset_menu(menu.menu_id,menu.menu_group_id)">
                          <i class="fa fa-plus" aria-hidden="true"></i> Add Menu</i>
                        </a>
                    </td>
                  </tr>
                </table>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div>
          <div class="col-xs-6">
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

                  <tr ng-repeat="row in menu_group_detail_list">
                    <td><span ng-bind="row.menu_id"></span></td>
                    <td><span ng-bind="row.name"></span></td>
                    <td class="text-center">
                      <input type="checkbox" ng-model="edit_add[row.menu_id]"  ng-checked="{{row.is_add}}" ng-click="stateChanged(row.menu_id,edit_add[row.menu_id],'is_add')" />
                    </td>
                    <td class="text-center">
                      <input type="checkbox" ng-model="edit_edit[row.menu_id]"  ng-checked="{{row.is_edit}}"  ng-click="stateChanged(row.menu_id,edit_edit[row.menu_id],'is_edit')" />
                    </td>
                    <td class="text-center">
                      <input type="checkbox" ng-model="edit_view[row.menu_id]" ng-checked="{{row.is_view}}" ng-click="stateChanged(row.menu_id,edit_view[row.menu_id],'is_view')" />
                    </td>
                    <td class="text-center">
                      <input type="checkbox" ng-model="edit_active[row.menu_id]" ng-checked="{{row.is_active}}" ng-click="stateChanged(row.menu_id,edit_active[row.menu_id],'is_active')" />
                    </td>
                  </tr>
                </table>

              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div>
      </div>
  </section>
  <!-- /.content -->
</div>
