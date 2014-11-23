define([], function () {

    var StateService = function ($resource, API_PATH) {
        return $resource(API_PATH + 'location/state/:id',
            { id: '@id' },
            { towns: {
                method: 'GET',
                url: API_PATH + 'location/state/:id/towns',
                isArray: true
            }
            }
        );
    };
    return ['$resource', 'API_PATH', StateService];

});

