(function() {
  angular.module('app.lessons', [])
    .factory('Lesson', [
      '$http',
      function LessonFactory($http) {
        return {
          find: function (lessonId) {
            return $http.get(Routing.generate('lesson_by_id', {'id': lessonId}));
          },
          findAll: function () {
            return $http.get(Routing.generate('lessons'));
          },
          findByLevel: function (levelSlug) {
            return $http.get(Routing.generate('lessons_by_level', {'level_slug': levelSlug}));
          }
        }
      }
    ])
})();
