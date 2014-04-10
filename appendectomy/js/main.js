var appyApp = angular.module('appyApp', []);

appyApp.controller('FormCtrl', function($scope, $http, $q) {
  var mly = $http.get('data/mly-8.json')
  var constituency = $http.get('data/constituency.json');
  var districtData = $http.get('data/district-data.json');
  $q.all([mly, constituency, districtData]).then(function(results) {
    $scope.mly = results[0].data;
    $scope.constituency = results[1].data;
    $scope.districtData = results[2].data;
    $scope.setLegislator('蔡正元');
  });

  $scope.count = 1;

  var defaultData = {
    birthdayYear: 1992,
    birthdayMonth: 1,
    birthdayDay: 1
  };

  $scope.setLegislator = function(name) {
    $scope.districtData.forEach(function(ly) {
      if (ly.district_legislator === name) {
        $scope.selectedTarget = ly;
      }
    })
  };

  $scope.proposers = [angular.copy(defaultData)];

  $scope.range = function(start, end) {
    var result = [];
    for (var i = start; i <= end; i++) {
      result.push({value: i, content: i});
    }
    return result;
  }
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
        $scope.proposers.push(angular.copy(defaultData));
      }
    }
  });
});

function idCheck(id) {
  var idArray=new Array();
  idArray[10]="A";  idArray[11]="B";  idArray[12]="C";  idArray[13]="D";
  idArray[14]="E";  idArray[15]="F";  idArray[16]="G";  idArray[17]="H";
  idArray[34]="I";  idArray[18]="J";  idArray[19]="K";  idArray[20]="L";
  idArray[21]="M";  idArray[22]="N";  idArray[35]="O";  idArray[23]="P";
  idArray[24]="Q";  idArray[25]="R";  idArray[26]="S";  idArray[27]="T";
  idArray[28]="U";  idArray[29]="V";  idArray[30]="X";  idArray[31]="Y";
  var newIdArray=idArray.indexOf(id.toUpperCase().substr(0,1))+id.substr(1,9);
  var baseNumber=
    parseInt(newIdArray.substr(0,1))*1+
    parseInt(newIdArray.substr(1,1))*9+
    parseInt(newIdArray.substr(2,1))*8+
    parseInt(newIdArray.substr(3,1))*7+
    parseInt(newIdArray.substr(4,1))*6+
    parseInt(newIdArray.substr(5,1))*5+
    parseInt(newIdArray.substr(6,1))*4+
    parseInt(newIdArray.substr(7,1))*3+
    parseInt(newIdArray.substr(8,1))*2+
    parseInt(newIdArray.substr(9,1))*1;
  if((baseNumber%10)==0)
    residue=0;
  else
    residue=10-(baseNumber%10);
  if(parseInt(newIdArray.substr(10,1))==residue)
    return true;
  else
    return false;
}

appyApp.directive('rocid', function($http) {
  return {
      require: 'ngModel',
      link: function(scope, elm, attrs, ctrl) {
        ctrl.$parsers.unshift(function(viewValue) {
          if (idCheck(viewValue)) {
            // it is valid
            ctrl.$setValidity('rocid', true);
            return viewValue;
          } else {
            // it is invalid, return undefined (no model update)
            ctrl.$setValidity('rocid', false);
            return undefined;
          }
        });
      }
    };
});
