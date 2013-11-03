'use strict';

/* Controllers */
		
angular.module('flyerBDControllers', []).
  controller('HomeCtrl', ['$scope', '$http', 'getRandomSpan', function($scope,$http,getRandomSpan) {
	  $http.get('news/prothomAlo.json').success(function(data) {
	    $scope.news = data;
      $scope.length = data.length;
      $scope.spanSizes = getRandomSpan($scope.length);
      console.log($scope.spanSizes);
	  });
	  $scope.holderSize = 150;
	  $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('MyCtrl2', [function() {

  }])
  .controller('navBarCtrl',['$scope', function($scope){
  	$scope.navs = [
	  	{
	  		"label":"Home",
	  		"url":"#/home",
	  		"id":1
	  	},
	  	{
	  		"label":"Likes",
	  		"url":"#/likes",
	  		"id":2
	  	},
	  	{
	  		"label":"Settings",
	  		"url":"#/settings",
	  		"id":3
	  	}
  	];
  	$scope.serial = 'id';
  }])
  .controller('footerCtrl',['$scope', function($scope){

  }]);