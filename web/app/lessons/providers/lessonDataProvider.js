(function() {
  angular.module('app.lessons', [])
    .factory('Lesson', [
      '$http',
      function LessonFactory($http) {
        return {
          find: function (lessonId) {
            return $http.get('app.php/api/lessons/' + lessonId);
          },
          findAll: function () {
            return $http.get('app.php/api/lessons');
          },
          findByLevelId: function (levelId) {
            return $http.get('app.php/api/lessons/level/' + levelId);
          }
        }
      }
    ])
})();
