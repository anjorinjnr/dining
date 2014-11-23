/**
 * Created by eanjorin on 6/13/14.
 */
define(['./config', './session'], function (config, Session) {

    var AuthService = function (scope, API_PATH, userService, $state, $cookieStore, $http) {
        scope.$on('event:accessTokenRequired', function () {
            /* $http.defaults.headers.post['Access-Token-Preflight'] = true;
             var params =  jQuery.param({ grant_type: 'client_credentials',
             client_id: CLIENT_ID,
             client_secret: CLIENT_SECRET,
             scope: 'full_api'
             });
             $http.post(API_PATH.substring(0, API_PATH.length - 3) + 'oauth/access_token?' + params).success(function(data){
             delete $http.defaults.headers.post['Access-Token-Preflight']
             console.log(data);
             });*/
        });
        var currentUser = null;

        return {
            /*user: null, */
            setCurrentUser: function (user) {
                currentUser = user;
            },

            redirectHome: function () {
                if (this.isLoggedIn()) {
                    $state.go('index.home');
                } else {
                    $state.go('index');
                }
            },
            createSession: function (user) {
                var session = {
                    session_id: '',
                    user_id: user.id,
                    user_type: user.user_type
                };
                $cookieStore.put('user', session);
            },
            login: function (user, onSuccess, onError) {
                var self = this;
                userService.login(user, function (data) {
                    if (data.status === 'success') {
                        if (angular.isFunction(onSuccess)) {
                            onSuccess();
                        }
                        currentUser = JSON.parse(data.user);
                        self.createSession(currentUser);
                        self.redirectHome();
                    } else {
                        if (angular.isFunction(onError)) {
                            onError(data.errors);
                        }

                    }
                });
            },

            logout: function () {
                $cookieStore.remove('user');
                currentUser = null;
                $state.go('index');
            },
            signUp: function (user, onSuccess, onError) {
                var self = this;
                userService.save({}, user, function (data) {
                    if (data.status === 'success') {
                        currentUser = JSON.parse(data.user);
                        self.createSession(currentUser);
                        //$cookieStore.put('user-id', data.user.id);
                        onSuccess();
                    } else {
                        onError(data.errors);
                    }
                });

            },
            /* check that the user is authorized the view the current state.
             everyone can view a state that has a public role
             state with student/tutor require logged in user of that user_type
             */
            authorize: function (role) {
                if (config.roles.PUBLIC == role) {
                    return true;
                }
                return this.isLoggedIn();


            },

            currentUser: function () {
                return currentUser;
            },

            isLoggedIn: function () {

                //console.log(this.currentUser());
                if ($cookieStore.get('user')) {
                    //console.log('logged in');
                    return true;
                }
                return false;
                //return this.currentUser() !== null;
            }

        }
    };
    return ['$rootScope', 'API_PATH', 'userService', '$state', '$cookieStore', '$http', AuthService];

});
