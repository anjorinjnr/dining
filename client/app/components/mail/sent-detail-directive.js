define(['./detail-controller'], function (DetailController) {


  function SentDetailController($scope, $stateParams, mailService, tipService, $sce) {
    //this.user = authService.currentUser();
    this.mailService = mailService;
    this.tipService = tipService;
    //this.API_PATH = API_PATH;
    //this.$cacheFactory = $cacheFactory;
    this.$sce = $sce;
    this.params = {id: $stateParams.id, mail_type: 'sent'};
    this.processMessage = function (message) {
        $scope.message = message;
        var recipients = _.pluck($scope.message.recipients, 'name');
        if (recipients.length > 3) {
            $scope.message.to = recipients.slice(0, 3).join(', ') + '...';
        }
        else {
            $scope.message.to = recipients.join(',');
        }
        $scope.message.trustedMessage = $sce.trustAsHtml($scope.message.message);
        $scope.message.from = 'Me';
    };
    this.loadMessage($stateParams.id);
  }
  SentDetailController.prototype = DetailController.prototype;
  SentDetailController.prototype.constructor = SentDetailController;

  var SentDetail = function (mailService, tipService) {
    return {
      restrict: 'E',
      replace: true,
      transclude: true,
      scope: {},
      controller: ['$scope', '$stateParams', 'mailService', 'tipService', '$sce', SentDetailController],
      //controllerAs: 'detailCtrl',
      templateUrl: 'components/mail/detail.tpl.html'
    };
  };
  return ['mailService', 'tipService', SentDetail];;
});
