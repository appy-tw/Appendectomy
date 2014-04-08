var appyApp = angular.module('appyApp', ['ng-bootstrap3-datepicker']);

appyApp.controller('FormCtrl', function($scope, $http) {
  $http.get('data/mly-8.json').success(function(data) {
    $scope.mly = data;
  });
  $http.get('data/constituency.json').success(function(data) {
    $scope.constituency = data;
  });

  $scope.count = 1;

  $scope.proposers = [{}];

  $scope.$watch('count', function(newValue, oldValue) {
    var i = 0;
    var offset = parseInt(newValue, 10) - parseInt(oldValue, 10);
    if (offset === NaN) {
      $scope.proposers = [];
      return;
    }
    if (offset < 0) {
      for (i = 0; i < offset*-1; i++) {
        $scope.proposers.pop();
      }
    } else if (offset > 0) {
      for (i = 0; i < offset; i++) {
        $scope.proposers.push({});
      }
    }
  });
});
