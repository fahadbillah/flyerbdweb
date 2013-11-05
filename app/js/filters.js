'use strict';

/* Filters */

angular.module('flyerBDFilters', [])
  .filter('interpolate', ['version', function(version) {
    return function(text) {
      return String(text).replace(/\%VERSION\%/mg, version);
    };
  }])
  .filter('navActive', ['$location', function($location){
  	return function(url){
  		url = url.substr(1);
  		if(url===$location.path())
  			return 'active';
  		else
  			return '';
  	};
  }]);
