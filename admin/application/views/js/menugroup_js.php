<script>
//swal('Hello world!');
app.controller("set_menu", function($scope, $http, $uibModal, $log) {
  <?php if (isset($menugroup_data['menu_group_id'])): ?>
     $scope.initget_menu = function() {
             $http({
              method: 'POST',
              url: '<?php echo base_url('menugroup/get_menu');?>',
              headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
           },
           data: { menu_group_id : "<?php echo $menugroup_data['menu_group_id'];?>"}
          }).success(function(data) {
               $scope.menu_list = data;
         });
       }
     $scope.initget_menu_group_detail = function() {
             $http({
              method: 'POST',
              url: '<?php echo base_url('menugroup/get_menu_group_detail');?>',
              headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
           },
           data: { menu_group_id : "<?php echo $menugroup_data['menu_group_id'];?>"}
          }).success(function(data) {
               $scope.menu_group_detail_list = data;
         });
       }

  $scope.initget_menu();
  $scope.initget_menu_group_detail();

  $scope.stateChanged = function (menu_id,edit_valus,case_update) {
      if (edit_valus == null){
          edit_valus = false;
        }
       $http({
        method: 'POST',
        url: '<?php echo base_url('menugroup/update_menu_group_detail');?>',
        headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
     },
     data: { "menu_group_id" : "<?php echo $menugroup_data['menu_group_id'];?>",
           "menu_id" : menu_id,
           "case_update": case_update,
            "edit_valus": edit_valus}
    }).success(function(data) {

      $.notify({
        // options
      	icon: 'fa fa-floppy-o',
      	title: 'Update Menu '+'<?php echo $menugroup_data['name'];?>',
        message: 'บันทึกสำเร็จ',
      },{
      	// settings
      	type: 'success',
      });
   });
  }

  $scope.inset_menu = function (menu_id,menu_group_id) {
       $http({
        method: 'POST',
        url: '<?php echo base_url('menugroup/save_menu_group_detail');?>',
        headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
     },
     data: { "menu_group_id" : '<?php echo $menugroup_data['menu_group_id'];?>',
            "menu_id" : menu_id}
    }).success(function(data) {
      $.notify({
        // options
        icon: 'fa fa-floppy-o',
        title: 'เพิ่มเมนูให้กับ '+'<?php echo $menugroup_data['name'];?>',
        message: 'บันทึกสำเร็จ',
      },{
        // settings
        type: 'success',
      });
      $scope.initget_menu();
      $scope.initget_menu_group_detail();
   });
  }

  <?php endif ?>
});
</script>
