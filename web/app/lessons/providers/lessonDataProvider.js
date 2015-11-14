(function() {
  angular.module('app.lessons', [])
    .factory('Lesson', [
      '$http',
      function LessonFactory($http) {
        var api_root = 'app_dev.php/api/lessons';
        return {
          find: function (lessonId) {
            return $http.get(api_root + '/' + lessonId);
          },
          findAll: function () {
            return $http.get(api_root);
          },
          findByLevelId: function (levelId) {
            return $http.get(api_root + '/level/' + levelId);
          }
        }
      }
    ])
})();
