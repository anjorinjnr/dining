/**
 * Created by eanjorin on 11/18/14.
 */
define([], function () {

  var StudentService = function ($resource, API_PATH) {
    var tutor = $resource(API_PATH + 'tutor/:id',
      {id: '@id'},
      {
        updateProfile: {
          method: 'post',
          url: API_PATH + 'tutor/:id/update/profile',
          isArray: false
        },
        updateSubjects: {
          method: 'POST',
          url: API_PATH + 'tutor/:id/subjects',
          isArray: false
        },
        agreeToTerms: {
          method: 'POST',
          url: API_PATH + 'tutor/:id/agreetoterms',
          isArray: false
        }
      });
    return tutor;
  };
  return ['$resource', 'API_PATH', TutorService];
})
;

