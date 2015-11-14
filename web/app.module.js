(function(){
  var app = angular.module('app', [
    'ngRoute',
    'app.layout',
    'app.lessons'
  ]);
  app.config(function ($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'app/lessons/views/index.html',
      controller: 'LessonsCtrl'
    }).otherwise({
      redirectTo: '/'
    });
  });
})();
