/**
 * Created by eanjorin on 10/10/14.
 */
define([], function () {

  var InitRun = function ($state, $location, $rootScope, authService, tipService, $http, $cookies, API_PATH) {

    $rootScope.tipService = tipService;
    //console.log('run.js');
    /* hack for ui router router malfunction, something isn't right but this works for now. */
    if ($location.path() === '') {
      //window.location = $location.absUrl() + '#/';
    }

    //var _token = $cookies['XSRF-TOKEN'];
    $http.defaults.headers.common.Authorization = 'Bearer ' + $cookies['API-TOKEN'];
    // console.log('token ' + $cookies['API-TOKEN']);
    /**obtain access token to access api */

    $rootScope.$on('$stateChangeSuccess',
      function () {
        tipService.hide();
      });
    $rootScope.$on('$stateChangeError',
      function () {
        tipService.error('An error has occured').show();
      });

    $rootScope.$on('$stateChangeStart', function (event, toState) {

      //console.log('state changing' + toState.url);

      tipService.info('Loading...').show();

      if (toState.url === '/logout') {
        event.preventDefault();
        authService.logout();
        return;
      }

      if ((toState.url === '/' || toState.url === 'login') && authService.isLoggedIn()) {
        event.preventDefault();
        authService.redirectHome();
      } else if (!authService.authorize(toState.data.access)) {
        console.log("not authorized");
      
        if (authService.isLoggedIn()) {
          event.preventDefault();
          authService.redirectHome();
        } else {
          event.preventDefault();
          $state.go('index');
        }
      } else {
        console.log('authorized');
      }

    });
  };
  return ['$state', '$location', '$rootScope', 'authService',
    'tipService', '$http', '$cookies', 'API_PATH', InitRun];

});
