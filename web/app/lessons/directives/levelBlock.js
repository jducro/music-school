(function(){
  angular.module('app.lessons')
    .directive('levelBlock', [
      'Lesson',
      function(Lesson){
        return {
          restrict: 'E',
          templateUrl: 'app/lessons/views/level_block.html',
          scope: {
            blockTitle: '@',
            level: '@'
          },
          link: function(scope) {
            Lesson.findByLevel(scope.level).then(function (result) {
              scope.lessons = result.data;
            });
          }
        }
      }]
    );
})();
