define(['./mail-controller'], function (MailController) {

  function SentController (authService, mailService, tipService,$cacheFactory,
  API_PATH, $sce) {
    this.user = authService.currentUser();console.log(this.user);
    this.userType = this.user.user_type == 1 ? 'tutor' : 'student';
    this.mailService = mailService;
    this.tipService = tipService;
    this.API_PATH = API_PATH;
    this.$cacheFactory = $cacheFactory;
    this.$sce = $sce;
    this.params = {id: this.user.id, mail_type: 'sent'};
    this.processMessages = function(messages) {
      if (_.isObject(messages) && _.isArray(messages.data) &&
                  messages.data.length > 0) {
            messages.data.map(function (mail) {
              var recipients = _.pluck(mail.recipients, 'name');
              if (recipients.length > 3) {
                mail.to = recipients.slice(0, 3).join(', ') + '...';
              }
              else {
                mail.to = recipients.join(',');
              }
              mail.trustedMessage = $sce.trustAsHtml(mail.message);
              return mail;
            });
          }
    };
    this.loadMessages();
  }
  SentController.prototype = MailController.prototype;
  SentController.prototype.constructor = SentController;
  
  var MailSent = function () {
    return {
      restrict: 'E',
      replace: true,
      scope: {},
      controller: ['authService', 'mailService', 'tipService', '$cacheFactory',
  'API_PATH', '$sce', SentController],
      controllerAs: 'sentCtrl',
      templateUrl: 'components/mail/sent.tpl.html'
    };
  };
  return MailSent;
});
