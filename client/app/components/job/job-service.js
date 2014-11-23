/**
 * Created by eanjorin on 10/5/14.
 */
define([], function () {

  var JobService = function ($resource, API_PATH) {
    var Job = $resource(API_PATH + 'job',
      {id: '@id'},
      {
        delete: {
          method: 'POST',
          url: API_PATH + 'job/:id/delete',
          isArray: false
        }

      }
    );
    return Job;
  };
  return ['$resource', 'API_PATH', JobService];
});

