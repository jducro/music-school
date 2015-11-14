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
            levelId: '='
          },
          link: function(scope) {
            Lesson.findByLevelId(scope.levelId).then(function (result) {
              scope.lessons = result.data;
            });
          }
        }
      }]
    );
})();
