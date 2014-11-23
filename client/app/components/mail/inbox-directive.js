define(['./mail-controller'], function (MailController) {

  function InboxController($state, authService, mailService, tipService, $cacheFactory,
          API_PATH, $sce) {
    this.state_ = $state;
    this.user = authService.currentUser();console.log(this.user);
    this.user_type = this.user.user_type == 1 ? 'tutor' : 'student';
    this.mailService = mailService;
    this.tipService = tipService;
    this.API_PATH = API_PATH;
    this.$cacheFactory = $cacheFactory;
    this.$sce = $sce;
    this.params = {id: this.user.id, mail_type: 'inbox'};
    this.processMessages = function (messages) {
      if (_.isObject(messages) && _.isArray(messages.data) &&
              messages.data.length > 0) {
        messages.data.map(function (element, i) {
          element.trustedMessage = $sce.trustAsHtml(element.message);
          return element;
        });
      }
    };
    this.loadMessages();
  }
  InboxController.prototype = MailController.prototype;
  InboxController.prototype.constructor = InboxController;

  var MailInbox = function () {
    return {
      restrict: 'E',
      replace: true,
      scope: {},
      controller: ['$state','authService', 'mailService', 'tipService', '$cacheFactory',
        'API_PATH', '$sce', InboxController],
      controllerAs: 'inboxCtrl',
      templateUrl: 'components/mail/inbox.tpl.html'
    };
  };
  return MailInbox;
});
