'use strict';

/* Controllers */
		
angular.module('flyerBDControllers', [])
  .controller('AllSitesCtrl', ['$scope', '$http', 'getRandomSpan', function($scope,$http,getRandomSpan) {
    $scope.spinner = false;
    $http.get('news/allSites.json').success(function(data) {
      $scope.spinner = true;
	    $scope.sites = data;
      $scope.length = data.length;
	  });
    $scope.spanSizes = 3;
	  $scope.holderSize = 200;
	  $scope.holderLink = 'http://placehold.it/'+$scope.holderSize+'x'+$scope.holderSize;
  }])
  .controller('SingleSiteCtrl', ['$scope', '$http','$routeParams', 'getRandomSpan', 'base64', 'utf8', 'allSiteList', function($scope,$http,$routeParams,getRandomSpan,base64,utf8,allSiteList) {
    /*$scope.allSiteList = allSiteList();*/
    $scope.spinner = false;
    $scope.siteID = $routeParams["id"].substr(1);
    $scope.json = $routeParams["site"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.spinner = true;
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
    $scope.spinner = false;
    $scope.json = $routeParams["site"].substr(1);
    var postID = $routeParams["post"].substr(1);
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.spinner = true;
      $scope.news = data[postID];
      var d = utf8.decode(base64.decode($scope.news.detail));
      console.log(d.length);
      var dl = Math.floor(d.length/3);
      $scope.details = [];
      var c = 0;
      for (var i = 0; i < 3; i++) {
        $scope.details.push(d.substr(c,dl)); 
        c+=dl;
        /*var k = dl+c;
        for (var j = 0; j <20; j++) {
          if(d[k+j]!==" ")
            continue;
          else
            k+=j;
        };
        if(k>d.length){
          $scope.details.push(d.substr(c));
          console.log('works');
        }
        else{
          $scope.details.push(d.substr(c,k));          
        }
        c+= k;*/
        /*console.log(k);
        console.log(c);*/
      };
      console.log($scope.details);
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