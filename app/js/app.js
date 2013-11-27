'use strict';

// Declare app level module which depends on filters, and services
angular.module('flyerBD', [
  'ngRoute',
  'ngResource',
  'ngAnimate',
  'ngTouch',
  'angulartics',
  'angulartics.google.analytics',
  'flyerBDFilters',
  'flyerBDServices',
  'flyerBDDirectives',
  'flyerBDControllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/home', {templateUrl: 'partials/allsites.html', controller: 'AllSitesCtrl'});
  $routeProvider.when('/likes', {templateUrl: 'partials/likes.html', controller: 'LikesCtrl'});
  $routeProvider.when('/settings', {templateUrl: 'partials/settings.html', controller: 'SettingsCtrl'});
  $routeProvider.when('/target', {templateUrl: 'partials/settings.html', controller: 'SettingsCtrl'});
  $routeProvider.when('/singleSite/:site/:id', {templateUrl: 'partials/singleSite.html', controller: 'SingleSiteCtrl'});
  $routeProvider.when('/singleSite/:site/:id/singlePost/:post', {templateUrl: 'partials/singlePost.html', controller: 'SinglePostCtrl'});
  $routeProvider.otherwise({redirectTo: '/home'});
}]);
