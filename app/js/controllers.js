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
  .controller('SinglePostCtrl', ['$scope', '$http','$routeParams', '$location', '$window', 'base64', 'utf8', function($scope,$http,$routeParams,$location,$window,base64,utf8) {
     var ua = $window.navigator.userAgent;
     var  iphone = ua.indexOf('iPhone') || ua.indexOf('iPod'),
          ipad = ua.indexOf('iPad'),
          ios = iphone || ipad,
          // Detect if this is running as a fullscreen app from the homescreen
          fullscreen = $window.navigator.standalone,
          android = ua.indexOf('Android'),
          lastWidth = 0;

    $scope.spinner = false;
    $scope.prevDisabled = false;
    $scope.nextDisabled = false;
    $scope.rawPath = $location.path().substr(0,$location.path().lastIndexOf(':')+1);
    $scope.json = $routeParams["site"].substr(1);
    $scope.siteID = $routeParams["id"].substr(1);
    $scope.postID = $routeParams["post"].substr(1);
    $scope.prevPostID = parseInt($scope.postID)-1;
    $scope.nextPostID = parseInt($scope.postID)+1;
    var prev = $scope.rawPath + $scope.prevPostID;
    var next = $scope.rawPath + $scope.nextPostID;
    if($scope.prevPostID<0)
      $scope.prevDisabled = true;
    $scope.nextAvailable = function(input){
      if($scope.nextPostID==input)
        return true;
    };
    $scope.lowerLimit = 0;
    $scope.noOfSideBarPost = 10;
    $scope.prevPost = function(){
      if(ios>0 || android>0){
        if($scope.prevPostID>=0)
          $location.path(prev);
      }
      else
        return 0;
    };
    $scope.nextPost = function(input){
      if(ios>0 || android>0){
        if($scope.nextPostID<input)
          $location.path(next);
      }
      else
        return 0;
    };
    $http.get('news/'+$scope.json+".json").success(function(data) {
      $scope.spinner = true;
      $scope.news = data[$scope.postID];
      $scope.allNews = data;
      $scope.noOfNews = data.length;

      console.log($scope.allNews);
      /*var d = utf8.decode(base64.decode($scope.news.detail));
      d.trim();
      console.log(d.length);
      var dl = Math.floor(d.length/3);
      var dArray = [];
      $scope.details = [];
      var start = 0;
      var end = 0;
      for (var i = 0; i < 3; i++) {
        console.log('start '+start);
        console.log(dl);
        if (i<2) {
          $scope.details.push(d.substr(start,d.indexOf(" ",start+dl)));
        } else{
          $scope.details.push(d.substr(start));
        };
        start = d.indexOf(" ",start+dl)+1;*/
        //$scope.details.push(d.substr(c,dl));
        //c+=dl;
        /*if (i==0)
          end = dl+start;
        else
          end = start;*/
        /*for (var j = 0; j <20; j++) {
          //console.log('start '+start);
          //console.log('start dl '+start+dl);
          if(start+dl>d.length){
            end = d.length-1;
            console.log('works');
            break;
          }
          else{
            if(d[start+dl+j]==" "){
              end =start+dl+j;
              //console.log(end);
              break;
            }
            else{
              continue;
            }
          }
        };
        if(i==2){
          console.log('start '+start);
          console.log('end '+end);
          dArray.push(d.substr(start));
          //console.log(d.substr(start));
          console.log('worksss');
          //break;
        }
        else{
          console.log('start '+start);
          console.log('end '+end);
          dArray.push(d.substr(start,end));
          //console.log(d.substr(start,end));
          console.log('worksssssss');
        }
        start = end;
      };*/
     /* console.log(dArray);
      console.log($scope.details);*/
      //$scope.details = dArray;
    });
    $scope.base64 = base64;
    $scope.utf8 = utf8;
  }])
  .controller('NavBarCtrl',['$scope','$route', function($scope,$route){
  	$scope.navs = [
	  	{
	  		"label":"Home",
	  		"url":"#/home",
	  		"id":1
	  	}
  	];
  	$scope.serial = 'id';
    $scope.refresh = function($window){
      $route.reload();
    };
  }])
  .controller('FooterCtrl',['$scope', '$sce', function($scope, $sce){
    var link = 'http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fflyerbd&width&layout=standard&action=like&show_faces=true&share=true&height=80';
    $scope.likeURL = $sce.trustAsResourceUrl(link);
    $scope.founders = [
      {
        "firstname" : "Fahad",
        "lastname" : "Billah",
        "nick" : "Fahad",
        "email" : "fahadbillah@yahoo.com",
        "img" : "fahad.jpg",
        "facebook" : "https://www.facebook.com/fahadbillah",
        "linkin" : "http://www.linkedin.com/pub/fahad-billah/71/6/316",
        "twitter": "",
        "googleplus": ""
      },
      {
        "firstname" : "G.A.N.",
        "lastname" : "Mahmud",
        "nick" : "GAN",
        "email" : "gan.mahmud@gmail.com",
        "img" : "gan.jpg",
        "facebook" : "https://www.facebook.com/GANMAHMUD",
        "linkin" : "",
        "twitter": "",
        "googleplus": ""
      },
      {
        "firstname" : "Monjurul",
        "lastname" : "Morshed",
        "nick" : "Soudi",
        "email" : "murshed.soudi@gmail.com",
        "img" : "soudi.jpg",
        "facebook" : "https://www.facebook.com/mmsoudi",
        "linkin" : "",
        "twitter": "",
        "googleplus": ""
      }
    ];
    $scope.predicate = "-firstname";
  }])  
  .controller('FeedbackCtrl',['$scope', '$http', function($scope,$http){
    $scope.feedbackFormShow = false;
    $scope.feedbackConfirmDiv = false;
    $scope.feedbackLoading = false;
    $scope.feedbackConfirmation = {
      "text" : "",
      "style": ""
    };
    $scope.feedbackName = '';
    $scope.feedbackEmail = '';
    $scope.feedbackTextarea = '';
    $scope.feedbackFormToggle = function(){
      if ($scope.feedbackFormShow)
        $scope.feedbackFormShow = false;
      else
        $scope.feedbackFormShow = true;
    };
    $scope.submitFeedback = function(){
      $scope.feedbackLoading = true;
      var sendData = {
        'name': $scope.feedbackName,
        'email': $scope.feedbackEmail,
        'feedback': $scope.feedbackTextarea
      };
      $http({
            url: 'mail/flyerbdmail.php',
            method: "POST",
            data: sendData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
      .success(function(data){
        console.log(data);
        /*if(data){*/
          $scope.feedbackConfirmDiv = true;
          $scope.feedbackConfirmation.text = "Thanks for your precious feedback!";
          $scope.feedbackConfirmation.style = "alert alert-success";
          $scope.feedbackName = '';
          $scope.feedbackEmail = '';
          $scope.feedbackTextarea = '';
        /*}
        else{
          $scope.feedbackConfirmDiv = true;
          $scope.feedbackConfirmation.text = "Sorry your massage could not be submitted! success error!";
          $scope.feedbackConfirmation.style = "alert alert-danger";
        }*/
        $scope.feedbackLoading = false;
      })
      .error(function(data, status) {
        //$scope.data = data || "Request failed";
        console.log(status);
        $scope.feedbackConfirmDiv = true;
        $scope.feedbackConfirmation.text = "Sorry your massage could not be submitted!";
        $scope.feedbackConfirmation.style = "alert alert-danger";
      });
    };
  }])
  .controller('FBCtrl',['$scope', '$sce', function($scope, $sce){
    
  }]);
  /*$sce.trustAsResourceUrl('http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fflyerbd&width&layout=standard&action=like&show_faces=true&share=true&height=80');
    $http('GET', 'http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fflyerbd&width&layout=standard&action=like&show_faces=true&share=true&height=80')
    .success(function(data){
      // success
      //$scope.FBLikeButtonStatus = status;
      $scope.FBLikeButton = data;
    })
    .success(function(data){
      // error
      //$scope.FBLikeButtonStatus = status;
      $scope.FBLikeButton = data;
    });*/