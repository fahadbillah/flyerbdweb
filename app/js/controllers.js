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
  .controller('NavBarCtrl',['$scope', function($scope){
  	$scope.navs = [
	  	{
	  		"label":"Home",
	  		"url":"#/home",
	  		"id":1
	  	}
  	];
  	$scope.serial = 'id';
  }])
  .controller('FooterCtrl',['$scope', function($scope){

  }])  
  .controller('FeedbackCtrl',['$scope', '$http', function($scope,$http){
    $scope.feedbackFormShow = false;
    $scope.feedbackConfirmDiv = false;
    $scope.feedbackLoading = false;
    $scope.feedbackConfirmation = {
      "text" : "",
      "style": ""
    }
    ;
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
      //alert($scope.feedbackName+' '+$scope.feedbackEmail+' '+$scope.feedbackTextarea);
      $scope.feedbackLoading = true;
      //alert('works');
      var sendData = {
        'name': $scope.feedbackName,
        'email': $scope.feedbackEmail,
        'feedback': $scope.feedbackTextarea
      };
      $scope.feedbackConfirmDiv = true;
      //$http.post('mail/flyerbdfmail.php',sendData)
      $http({
            url: 'mail/flyerbdmail.php',
            method: "POST",
            data: sendData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
      .success(function(data){
        console.log(data);
        if(data){
          $scope.feedbackConfirmation.text = "Thanks for your precious feedback!";
          $scope.feedbackConfirmation.style = "alert alert-success";
        }
        else{
          $scope.feedbackConfirmation.text = "Sorry your massage could not be submitted!";
          $scope.feedbackConfirmation.style = "alert alert-danger";
        }
        $scope.feedbackConfirmDiv = true;
        $scope.feedbackLoadingDiv = false;
      })
      .error(function(data, status) {
        //$scope.data = data || "Request failed";
        //$scope.status = status;
        $scope.feedbackConfirmation.text = "Sorry your massage could not be submitted!";
        $scope.feedbackConfirmation.style = "alert alert-danger";
      });
    };
  }]);