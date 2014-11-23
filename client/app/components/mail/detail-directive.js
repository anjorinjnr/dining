define(['./detail-controller'], function (DetailController) {


    function InboxDetailController($scope, $stateParams, mailService, tipService, $sce) {
        //this.user = authService.currentUser();
        this.mailService = mailService;
        this.tipService = tipService;
        //this.API_PATH = API_PATH;
        //this.$cacheFactory = $cacheFactory;
        this.$sce = $sce;
        this.params = {id: $stateParams.id, mail_type: 'inbox'};
        this.processMessage = function (message) {
            $scope.message = message;
            $scope.message.to = 'Me';
            $scope.message.trustedMessage = $sce.trustAsHtml($scope.message.message);
        };
        this.loadMessage();
    }
    InboxDetailController.prototype = DetailController.prototype;
    InboxDetailController.prototype.constructor = InboxDetailController;

    var Detail = function (/*authService, userService, */mailService, tipService) {
        return {
            restrict: 'E',
            replace: true,
            transclude: true,
            scope: {},
            controller: ['$scope', '$stateParams', 'mailService', 'tipService', '$sce', InboxDetailController],
            templateUrl: 'components/mail/detail.tpl.html'
        };
    };
    return ['mailService', 'tipService', Detail];;
});
