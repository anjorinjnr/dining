/**
 * Created by eanjorin on 10/8/14.
 */
/**
 * Created by eanjorin on 7/3/14.
 */
//cryptoutf16', 'cryptob64'
define([], function () {
    var SearchService = function ($resource, API_PATH) {
        var search = $resource(API_PATH + 'search', null,
                {
                    tutors: {
                        method: 'GET',
                        url: API_PATH + 'search/tutors',
                        isArray: false
                    },
                    jobs: {
                        method: 'GET',
                        url: API_PATH + 'search/jobs',
                        isArray: true
                    }
                });
        return search;
    };

    return ['$resource', 'API_PATH', SearchService];
});
