define([], function () {

    var HomeCtrl =   function ($scope, authService, tipService) {

        this.authService = authService;
        $scope.tipService = tipService;
        this.meals = [

        ];
        //this.user = authService.currentUser() || {};

    };
    //return ['$scope', 'authService', 'tipService', '$cookies', '$http', 'API_PATH', MainCtrl];
    return ['$scope', 'authService', 'tipService', HomeCtrl];
});
