<script type="text/javascript">

	app.controller("delivery_return", function($scope, $http, $uibModal, $log) {

	$scope.product_delivery_return = [];
		 $scope.items = { return_id : '',
 		  				  order_id : '',
 		  				  serial : '' };

	<?php if (isset($delivery_return_data['id'])): ?>
		$scope.items = { return_id : "<?php echo $delivery_return_data['return_id'] ?>",
			order_id : "<?php echo $delivery_return_data['order_id'] ?>",
			serial : "<?php echo $delivery_return_data['serial'] ?>" ,
			product_id : "<?php echo $delivery_return_data['product_id'] ?>"};

		<?php endif ?>

		 $scope.open = function () {

		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: "lg",
		      resolve: {
		        items: function () {
		          return $scope.items;
		        }
		      }
		    });


		    $scope.animationsEnabled = true;
		    modalInstance.result.then(function (selectedItem) {
		     $scope.items = selectedItem;
		     $scope.order_id = $scope.items.order_id;
		     $scope.return_id = $scope.items.return_id;
		     $scope.serial = $scope.items.serial;
		     $scope.product_id = $scope.items.product_id;

		     	console.log($scope.items);
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };

		  $scope.toggleAnimation = function () {
		    $scope.animationsEnabled = !$scope.animationsEnabled;
		  };


	});

	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {
		  $scope.items = items;
		  $scope.order_data;

		  $scope.ok = function () {
		    $uibModalInstance.close($scope.items);
		  };

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};

		$scope.searchOrder = function () {
			if($scope.search_order.length > 0){

				$http({
		            method: 'POST',
		            url: '<?php echo base_url('delivery_return/get_search_order');?>',
		            headers: { 'Content-Type': 'application/x-www-form-urlencoded'
		         }, data: { search : $scope.search_order }

		        }).success(function(data) {
		             var order_data = data;
 					$scope.order_data = order_data;
				});

			}

		};


		$scope.selectOrder = function (order_id,return_id,serial_number,product_id){

			$scope.items.return_id = return_id;
 		  	$scope.items.order_id = order_id;
 		  	$scope.items.serial = serial_number;
 		  	$scope.items.product_id = product_id;
			$uibModalInstance.close($scope.items);
		};


	});


</script>
