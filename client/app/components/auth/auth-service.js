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

        return  {
            /*user: null, */
            setCurrentUser: function (user) {
                currentUser = user;
            },
            requestAccessToken: function () {
                /**authenticate and request access token**/
                /*$http.defaults.headers.post.access_token_preflight = true;
                 $http.post(path + 'oauth/access_token', { grant_type: 'client_credentials',
                 client_id: CLIENT_ID,
                 client_secret: CLIENT_SECRET,
                 scope: 'full_api'
                 }).success(function(data){
                 delete $http.defaults.headers.post.access_token_preflight;
                 console.log(data);
                 });*/

            },
            redirectHome: function () {
                if (this.isLoggedIn()) {
                    switch (parseInt($cookieStore.get('user').user_type)) {
                        case 0:
                            console.log("student home");
                            $state.go('index.student.home');
                            break;
                        case 1:
                            console.log("tutor home");
                            $state.go('index.tutor.home');

                    }
                } else {
                    $state.go('index');
                }

                /* function home() {
                 switch (parseInt(currentUser.user_type)) {
                 case 0:
                 console.log("student home");
                 $state.go('index.student.home');
                 break;
                 case 1:
                 console.log("tutor home");
                 $state.go('index.tutor.home');

                 }
                 }

                 if (this.isLoggedIn() && currentUser) {
                 home();
                 } else if (this.isLoggedIn) {

                 $http.get(API_PATH + 'user/' + $cookieStore.get('user').user_id).then(function (data) {
                 currentUser = data;
                 home();
                 });


                 }*/
            },
            createSession: function (user) {
                var session = {
                    session_id: '',
                    user_id: user.id,
                    user_type: user.user_type
                };
                $cookieStore.put('user', session);
            },
            login: function (user, error) {
                var self = this;
                userService.login(user, function (data) {
                    if (data.status === 'success') {
                        //self.user = JSON.parse(data.user);
                        currentUser = JSON.parse(data.user);
                        self.createSession(currentUser);
                        self.redirectHome();
                    } else {
                        error(data.errors);
                        //$scope.loginError = data.error;
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
                //console.log($cookieStore.get('user'));
                return true;
               /* console.log("required role " + role);
                if (config.roles.PUBLIC == role) {
                    return true;
                } else if (this.isLoggedIn()) {
                   var user_type = parseInt($cookieStore.get('user').user_type);
                    return user_type === role;
                } else {
                    return false;
                }*/

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
