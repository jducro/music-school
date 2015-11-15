(function() {
  angular.module('app.lessons', [])
    .factory('Lesson', [
      '$http',
      function LessonFactory($http) {
        var api_root = '/api/lessons';
        return {
          find: function (lessonId) {
            return $http.get(api_root + '/' + lessonId);
          },
          findAll: function () {
            return $http.get(api_root);
          },
          findByLevel: function (levelSlug) {
            return $http.get(api_root + '/level/' + levelSlug);
          }
        }
      }
    ])
})();
