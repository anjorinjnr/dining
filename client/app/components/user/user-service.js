/**
 * Created by eanjorin on 10/5/14.
 */
define([], function () {

    var UserService = function ($resource, API_PATH) {
        var User = $resource(API_PATH + 'user/:id',
            {id: '@id'},
            {
                login: {
                    method: 'POST',
                    url: API_PATH + 'login',
                    isArray: false
                },
                resendConfirmation: {
                    method: 'POST',
                    url: API_PATH + 'user/activationmail/:id',
                    isArray: false
                },
                getUsers: {
                    method: 'GET',
                    url: API_PATH + 'users',
                    isArray: true
                },
                activate: {
                  method: 'POST',
                  url: API_PATH + 'user/activate',
                  isArray: false
                }
            }
        );
        User.uploadPhoto = function ($uploader, user_id, files) {
            files.forEach(function (file) {
                $uploader.upload({
                    url: API_PATH + 'user/' + user_id + '/upload/picture',
                    method: 'POST',
                    data: {user_id: user_id},
                    file: file
                }).success(function (data) {
                    console.log(data);
                });

            });

        };


        return User;

    }
    return ['$resource', 'API_PATH', UserService];
});

