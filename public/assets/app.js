var app = angular.module('app-cars', ['ngRoute']);

app.config(function ($routeProvider) {
  $routeProvider
  .when('/', {
    templateUrl: 'assets/templates/car/index.html',
    controller: 'carsController'
  })
  .when('/car', {
    templateUrl: 'assets/templates/car/index.html',
    controller: 'carsController'
  })
  .when('/car/new', {
    template: '<div ng-controller="carNewController as carNewController"><div ng-bind-html="form"></div></div>',
    controller: 'carNewController'
  })
  .when('/car/:id', {
    templateUrl: 'assets/templates/car/show.html',
    controller: 'carController'
  })
  .when('/car/:id/edit', {
    template: '<div ng-controller="carEditController as carEditController"><div ng-bind-html="form"></div></div>',
    controller: 'carEditController'
  })
  .otherwise({
    template : '<h1 class="text-center">404 Not Found</h1>',
  });
});

app.component('caraddress', {
  template: '<span style="font-weight: bold; color: orange;">{{ $ctrl.address }}</span>',
  controller: function () {
    this.address = null;

    this.setAddress = function (address) {
      this.address = address;
    }
  },
  bindings: {
    address: '@'
  }
});

app.controller('carsController', function ($scope, $http) {
  $scope.cars = [];

  $http.get('/car?xhr=true').then(
    function(res) {
      $scope.cars = res.data;
    },
    function (res) {
      console.error('XHR error');
    }
  );
});

app.controller('carController', function ($scope, $http, $routeParams) {
  $scope.car = null;

  $http.get('/car/' + $routeParams.id + '?xhr=true').then(
    function(res) {
      $scope.car = res.data;
    },
    function (res) {
      console.error('XHR error');
    }
  );
});

app.controller('carNewController', function ($scope, $http, $sce) {
  $scope.form = null;

  $http.get('/car/new?xhr=true').then(
    function(res) {
      $scope.form = $sce.trustAsHtml(res.data);
    },
    function (res) {
      console.error('XHR error');
    }
  );
});

app.controller('carEditController', function ($scope, $http, $routeParams, $sce) {
  $scope.form = null;

  $http.get('/car/' + $routeParams.id + '/edit?xhr=true').then(
    function(res) {
      $scope.form = $sce.trustAsHtml(res.data);
    },
    function (res) {
      console.error('XHR error');
    }
  );
});