angular.module('FB', []).directive('fbLike', function($timeout) {
    return {
      restrict: 'A',
      scope: {},
      template: "<div class=\"fb-like-box\" data-href=\"{{page}}\" data-width=\"{{width}}\" data-show-faces=\"{{faces}}\" data-height=\"{{height}}\" data-stream=\"{{stream}}\" data-header=\"{{header}}\"></div>",
      link: function($scope, $element, $attrs) {
        var working, _ref, _ref1;

        $scope.page = $attrs.fbLike;
        $scope.height = (_ref = $attrs.fbHeight) != null ? _ref : '550';
        $scope.faces = $attrs.fbFaces != null ? $attrs.fbFaces : 'false';
        $scope.stream = $attrs.fbStream != null ? $attrs.fbStream : 'true';
        $scope.header = $attrs.fbHeader != null ? $attrs.fbHeader : 'false';
        $scope.width = (_ref1 = $attrs.fbWidth) != null ? _ref1 : $element.parent().width();
        working = false;
        
        $(window).on('resize', function() {
          if (!working) {
            working = true;
            $timeout(function() {
              $scope.width = $element.parent().width();
              $timeout(function() {
                return FB.XFBML.parse($element[0]);
              }, 50, false);
              working = false;
            }, 10);
          }
        });
      }
    };
  });
