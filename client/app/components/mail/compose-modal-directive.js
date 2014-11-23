define([], function () {

  var MailComposeModal = function (mailService, tipService) {

    return {
      restrict: 'E',
      replace: true,
      scope: {
        message: '=',
        hide: '='
      },
      controller: function ($scope) {

        $scope.send = function () {
          var message = $scope.message;
          $scope.submitted = true;
          if (angular.isString(message.body) &&
                  message.body.length > 0 &&
                  angular.isString(message.subject) &&
                  message.subject.length > 0 &&
                  angular.isNumber(message.from) &&
                  message.to.length > 0) {
            mailService.send({id: message.from}, message, function (resp) {
              if (resp.status === 'success') {
                $scope.hide();
                tipService.info('Your message was successfully sent.').show();
              } else {
                tipService.error('Unable to send message, please try again').show();
              }

            });
          } else {
            tipService.info('Unable to send message due to an internal error').show();
          }
        };
      },
      templateUrl: 'components/mail/compose-modal.tpl.html',
      link: function ($scope, element, attrs) {

      }
    };
  };
  return ['mailService', 'tipService', MailComposeModal];
});
