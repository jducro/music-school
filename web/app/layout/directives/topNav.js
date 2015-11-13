(function(){
  angular.module('app.layout', [])
    .directive('topNav',[
      function () {
        return {
          restrict: 'E',
          templateUrl: 'app/layout/views/top_nav.html'
        }
      }
    ])
})();
