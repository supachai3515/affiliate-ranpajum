<script type="text/javascript">
	var app = angular.module("myApp", ['ui.bootstrap']);
	app.controller("myCtrl", function($scope, $http, $uibModal, $log) {
	    $scope.firstName = "John";
	    $scope.lastName = "Doe";
	    $scope.stock_data

	  


	       $scope.getStock = function(product_id) {
            $scope.product_id = product_id
	             $http({
	            method: 'POST',
	            url: '<?php echo base_url('products/getstock');?>',
	             headers: {
	           'Content-Type': 'application/x-www-form-urlencoded'
	         },

	         data: { product_id : $scope.product_id}
	           
	        }).success(function(data) {
	            $scope.items = data;
	            //console.log(data);
	       });

       }



		  $scope.animationsEnabled = true;

		  $scope.open = function (product_id) {
		  	
		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: "",
		      resolve: {
		        items: function () {
		          return product_id;
		        }
		      }
		    });

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


	// Please note that $uibModalInstance represents a modal window (instance) dependency.
	// It is not the same as the $uibModal service used above.

	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {

		$scope.product_id = items
	             $http({
	            method: 'POST',
	            url: '<?php echo base_url('products/getstock');?>',
	             headers: {
	           'Content-Type': 'application/x-www-form-urlencoded'
	         },

	         data: { product_id : $scope.product_id}
	           
	        }).success(function(data) {
	            $scope.items_stock = data;
	            //console.log(data);
	       });


	  $scope.items = items;
	  $scope.selected = {
	    item: $scope.items[0]
	  };

	  $scope.ok = function () {
	    $uibModalInstance.close($scope.selected.item);
	  };

	  $scope.cancel = function () {
	    $uibModalInstance.dismiss('cancel');
	  };
	});

</script>
	