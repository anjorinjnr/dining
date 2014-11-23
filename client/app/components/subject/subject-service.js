/**
 * Created by eanjorin on 10/5/14.
 */
/**
 * Created by eanjorin on 6/29/14.
 */
define([], function () {

    var SubjectService = function ($resource, API_PATH) {
        var Subject = $resource(API_PATH + 'subject/:id',
            { id: '@id' },
            {
              categories: {
                method: 'GET',
                url: API_PATH + 'category',
                isArray: true
              }
            });

        return Subject;
    };
    return ['$resource', 'API_PATH', SubjectService];
});
