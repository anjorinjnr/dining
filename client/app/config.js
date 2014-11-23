/**
 * Created by eanjorin on 10/11/14.
 */
define(['./app'], function (app) {
    'use strict';

  app.factory('httpInterceptor', ['$q', '$rootScope', 'API_PATH', function($q, $rootScope, API_PATH) {
            return {
                'request': function (config) {
                    return config;

                },
                'requestError': function (error) {
                    return error;

                },
                'response': function (response) {
                    //console.log(response);
                    return response;
                },
                'responseError': function (error) {
                    console.log(error);
                    return error;
                }
            }

        }])
        .config(['$httpProvider', function ($httpProvider) {
            $httpProvider.interceptors.push('httpInterceptor');
        }]);


    if (window) {
        if (window.location.origin.indexOf('chefme.co') >= 0) {
            app.constant('UPLOAD_PATH', 'http://api.chefme.co/uploads');
            app.constant('API_PATH', 'http://api.chefme.co/index.php/v1/');
        } else {
            app.constant('UPLOAD_PATH', 'http://dining-service.local/uploads');
            app.constant('API_PATH', 'http://dining-service.local/v1/');
        }
    }
    return app;
});