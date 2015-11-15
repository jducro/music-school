(function() {
  angular.module('app.layout')
    .directive('footerNav', [
      function () {
        return {
          restrict: 'E',
          templateUrl: 'app/layout/views/footer.html',
          link: function() {

          }
        }
      }
    ])
})();
