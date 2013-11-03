'use strict';


// Declare app level module which depends on filters, and services
angular.module('flyerBD', [
  'ngRoute',
  'flyerBDFilters',
  'flyerBDServices',
  'flyerBDDirectives',
  'flyerBDControllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/home', {templateUrl: 'partials/home.html', controller: 'HomeCtrl'});
  $routeProvider.when('/likes', {templateUrl: 'partials/likes.html', controller: 'LikesCtrl'});
  $routeProvider.when('/settings', {templateUrl: 'partials/settings.html', controller: 'SettingsCtrl'});
  $routeProvider.otherwise({redirectTo: '/home'});
}]);
