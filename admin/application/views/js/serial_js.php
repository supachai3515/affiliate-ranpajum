<script type="text/javascript">
	app.controller("product_serial", function($scope, $http, $uibModal, $log) {

		 $scope.open = function (product_id_p,serial_n) {
		  	
		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: "",
		      resolve: {
		        items: function () {
		        	var re_pa = {
		        		product_id : product_id_p,
		        		serial_number : serial_n,
		        	}
		        	console.log(re_pa);


		          return re_pa;
		        }
		      }
		    });


		    $scope.animationsEnabled = true;
		    modalInstance.result.then(function (selectedItem) {
		      $scope.selected = selectedItem;
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };

		  $scope.toggleAnimation = function () {
		    $scope.animationsEnabled = !$scope.animationsEnabled;
		  };


	});

	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {
			var re_pa = items ;
	             $http({
	            method: 'POST',
	            url: '<?php echo base_url('product_serial/get_product_serial_history');?>',
	             headers: {
	           'Content-Type': 'application/x-www-form-urlencoded'
	         },

	         data: { product_id : re_pa.product_id ,
		        	 serial_number : re_pa.serial_number
		        }
	           
	        }).success(function(data) {
	            $scope.product_serial = data;
	            var count_p = $scope.product_serial.length;
	            for (i = 0; i < re_pa.qty - count_p; i++) { 

	            	 var product_serial = {
	                      	  sku: "",
	                      	  line_number : i+1,
	                          product_id: re_pa.product_id,
	                          order_id: re_pa.order_id,
	                          name: "",
	                          serial_number: "",
	                          create_date: "",
	                          modified_date: "",
	                          modified_date_order: "",
	     
	                      };

	            	$scope.product_serial.push(product_serial);
				}

	            //console.log(data);
	       });


	  $scope.ok = function () {
	    $uibModalInstance.close($scope.selected.item);
	  };

	  $scope.cancel = function () {
	    $uibModalInstance.dismiss('cancel');
	  };


	});


</script>
