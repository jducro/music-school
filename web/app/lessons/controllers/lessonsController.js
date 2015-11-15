(function () {
  angular.module('app.lessons')
    .controller('LessonsCtrl', [
      'Lesson',
      '$routeParams',
      '$scope',
      function (Lesson, $routeParams, $scope) {
        var lessonId = $routeParams.lessonId;
        if (lessonId) {
          Lesson.find(lessonId).then(function(result) {
            $scope.lesson = result.data;
          })
        }
    }]);
})();
