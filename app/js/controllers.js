'use strict';

/* Controllers */
		
angular.module('flyerBDControllers', [])
  .controller('AllSitesCtrl', ['$scope', '$http', 'getRandomSpan', function($scope,$http,getRandomSpan) {
	  $http.get('news/allSites.json').success(function(data) {
	    $scope.sites = data;
      $scope.length = data.length;
	  });
    $scope.spanSizes = 3;
	  $scope.holderSize = 200;
	  $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('SingleSiteCtrl', ['$scope', '$http','$routeParams', 'getRandomSpan', function($scope,$http,$routeParams,getRandomSpan) {
    $scope.json = $routeParams["site"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.news = data;
      $scope.length = data.length;
      $scope.spanSizes = getRandomSpan($scope.length);
      console.log($scope.spanSizes);
    });
    $scope.holderSize = 150;
    $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('SinglePostCtrl', ['$scope', '$http','$routeParams', function($scope,$http,$routeParams) {
    $scope.json = $routeParams["site"].substr(1);
    $scope.postID = $routeParams["post"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.news = data;
      $scope.length = data.length;
      $scope.spanSizes = getRandomSpan($scope.length);
      console.log($scope.spanSizes);
    });
    $scope.holderSize = 150;
    $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('NavBarCtrl',['$scope', function($scope){
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