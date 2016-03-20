(function(){
  var app = angular.module('app', [
    'ngRoute',
    'app.layout',
    'app.lessons'
  ]);
  app.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
  }]);
  app.config(function ($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'app/lessons/views/index.html',
      controller: 'LessonsCtrl'
    }).when('/lesson/:lessonId', {
      templateUrl: 'app/lessons/views/view.html',
      controller: 'LessonsCtrl'
    }).otherwise({
      redirectTo: '/'
    });
  });
})();
