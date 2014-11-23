/**
 * Created by eanjorin on 5/7/14.
 *
 * Defines the entire application states, and associated urls
 */


define(['components/auth/config'], function (config) {
  'use strict';
  var StatesConfig = function ($stateProvider, $urlRouterProvider, $cookieStore) {
    $urlRouterProvider.otherwise('/');
    $stateProvider
            .state('logout', {
              url: '/logout'
            })
            .state('index', {
              url: '/',
              views: {
                'header': {
                  templateUrl: 'main/header.html'
                },
                'content': {
                  templateUrl: 'main/content.html'
                },
                'footer': {
                  templateUrl: 'main/footer.html'
                }
              },
              data: {
                access: config.roles.PUBLIC
              },
              resolve: {
                currentUser: ['$http', '$cookieStore', 'authService', 'API_PATH', function ($http, $cookieStore, authService, API_PATH) {

                    var session = $cookieStore.get('user');
                    if (session) {
                      console.log('resolving currentuser');
                      return $http.get(API_PATH + 'user/' + session.user_id).then(function (resp) {
                        if (resp.data.status === 'success') {
                          authService.setCurrentUser(resp.data.user);
                        }
                      });
                    }
                    return null;
                  }]
              }
            })
            .state('index.404', {
              url: 'lost',
              views: {
                'content@': {
                  templateUrl: '/main/404.html'
                }
              }
            })

            .state('index.login', {
              url: 'login',
              views: {
                'content@': {
                  templateUrl: 'login/login.html',
                  controller: 'LoginCtrl as loginCtrl'
                }
              }
            })
            .state('index.signup', {
              url: 'signup',
              views: {
                'content@': {
                  templateUrl: 'signup/signup.html',
                  controller: 'SignUpCtrl as signupCtrl'
                }
              }
            })
            .state('index.home', {
                url: 'home',
                views: {
                    'content@': {
                        templateUrl: 'home/home.html',
                        controller: 'HomeCtrl as homeCtrl'
                    }
                },
                data: {
                    access: config.roles.USER
                }
            })
        .state('index.edit-profile', {
            url: 'edit/profile',
            views: {
                'content@': {
                    templateUrl: 'user/edit-profile.html',
                    controller: 'UserCtrl as userCtrl'
                }
            },
            data: {
                access: config.roles.USER
            }
        })
        .state('index.profile', {
            url: 'profile',
            views: {
                'content@': {
                    templateUrl: 'user/profile.html',
                    controller: 'UserCtrl as userCtrl'
                }
            }
        })

  };
  return ['$stateProvider', '$urlRouterProvider', StatesConfig];
});
