'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('flyerBDServices', []).
  value('version', '0.1')
  .factory('getRandomSpan', function(){
  	return function(length){
  		console.log(length);
  		var count = 12;
      var spanList = [2,3,4];
      var spanArr = [];
      for(var i=0;i<length;i++){
        var rand = spanList[Math.floor((Math.random()*spanList.length))];
        count -= rand;
        if(count<2){
          count += rand;
          spanArr.push(count);
          count = 12;
        }
        else
          spanArr.push(rand);
      }
      return spanArr;
  	};
  })
  .factory('base64', ['$window', function($window) {
    return {
      name: 'Base64',
      readonly: false,
      encode: function(input) {
        return $window.btoa(input);
      },
      decode: function(input) {
        return $window.atob(input);
      }
    };
  }])
  .factory('utf8', ['$window', function($window) {
    return {
      name: 'utf8',
      readonly: false,
      encode: function(input) {
        return $window.unescape(encodeURIComponent(input));
      },
      decode: function(input) {
        return $window.decodeURIComponent(escape(input));
      }
    };
  }])
  .factory('allSiteList', ['$http', function($http) {
    $http.get('news/allSites.json').success(function(data) {
      return data;
    });
  }])
  .factory('newsJson', ['$http', '$q', function($http, $q) {               // Angular Service Declaration
      return {
          getJson: function(sitename) {
              var d = new Date();
              var n = d.getMinutes();
              var t = (n<30)? 0 : 1;
              var deferred = $q.defer();                       // Deferred Object Declaration
              if (sitename=='allSites') {
                var link = "news/"+sitename+".json";
              } else{
                var link = "news/"+sitename+".json?time="+t;
              };
              $http.get(link).success(function(data) {   // Asynchronous Service calling
                   deferred.resolve(data);
              }).error(function(){
                   deferred.reject();
              });
          return deferred.promise;
       }
     };
  }]);
