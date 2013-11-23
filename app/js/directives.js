'use strict';

/* Directives */


angular.module('flyerBDDirectives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }])
  .directive('fbIframe', function(){
    var linkFn = function(scope, element, attrs) {
        element.find('iframe').bind('load', function (event) {
          event.target.contentWindow.scrollTo(0,400);
        });
    };
    return {
      restrict: 'EA',
      scope: {
        src:'http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fflyerbd&width&layout=standard&action=like&show_faces=true&share=true&height=80',
        height: '80',
        width: '100',
        scrolling: 'auto'
      },
      template: '<iframe class="frame" height="{{height}}" width="{{width}}" frameborder="0" border="0" marginwidth="0" marginheight="0" scrolling="{{scrolling}}" src="{{src}}"></iframe>',
      link : linkFn
    };
  })
  .directive('myFrame',['$sce', function($sce){
  	return {
  		link:function(scope,ele,attrs){
  			ele.ready(function(){
  				scope.$apply(attrs.myFrame);
  			});
  		}
  	};
  }]);
