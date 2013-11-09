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
  .controller('SingleSiteCtrl', ['$scope', '$http','$routeParams', 'getRandomSpan', 'base64', 'utf8', 'allSiteList', function($scope,$http,$routeParams,getRandomSpan,base64,utf8,allSiteList) {
    //$scope.allSiteList = allSiteList();
    $scope.siteID = $routeParams["id"].substr(1);
    $scope.json = $routeParams["site"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.news = data;
      $scope.length = data.length;
      $scope.spanSizes = getRandomSpan($scope.length);
      console.log($scope.spanSizes);
    });
    $scope.base64 = base64;
    $scope.utf8 = utf8;
    $scope.holderSize = 150;
    $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('SinglePostCtrl', ['$scope', '$http','$routeParams', 'base64', 'utf8', function($scope,$http,$routeParams,base64,utf8) {
    $scope.json = $routeParams["site"].substr(1);
    var postID = $routeParams["post"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.news = data[postID];
    });
    $scope.base64 = base64;
    $scope.utf8 = utf8;
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