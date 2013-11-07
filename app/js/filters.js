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
  }])
  .filter('holderFilter', function(input){
    if(input=='http://images1.wikia.nocookie.net/__cb20100722190004/logopedia/images/thumb/b/b6/SNCB_B_logo.svg/120px-SNCB_B_logo.svg.png')
      return 'img/flyerBDHolder.jpg';
  });
