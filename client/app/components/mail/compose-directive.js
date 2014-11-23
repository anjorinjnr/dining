define([], function (ng) {

  var MailCompose = function (authService, userService, mailService, tipService) {

    return {
      restrict: 'E',
      replace: true,
      //require: ['^?form', 'ngModel'],
      scope: {
      },
      controller: function ($scope, $stateParams) {

        userService.getUsers({fields: 'id, email, first_name, last_name'}, function (resp) {
          $scope.users = _.filter(resp, function (user) {
            return $scope.currentUser.id !== user.id;
          }); //filter current user
        });

          if($stateParams.id !== undefined && !!$stateParams.id){//if there's an ID, then this is a reply
              mailService.get({id: $stateParams.id, mail_type: $stateParams.mail_type}, function(resp){
                  $scope.mail.body = resp.message;
                  $scope.mail.subject = 'Reply:' + resp.subject;
                  if($stateParams.mail_type === 'inbox'){
                      $scope.mail.to.push(resp.sender_id);
                  }else if($stateParams.mail_type === 'sent'){
                      _.each(resp.recipients, function(item){
                          $scope.mail.to.push(item.user_id);
                      });
                  }
                  tinymce.activeEditor.setContent('Original message: <br>' + resp.message);
              });
          }

        $scope.send = function () {
          $scope.mail.from = $scope.currentUser.id;
          mailService.send($scope.mail, function () {
            $scope.mail = angular.copy($scope.newMail);
            tinymce.activeEditor.setContent("");
            $("select[name='to']").val("").trigger('chosen:updated');
            tipService.info("Your message has been sent").show();
          });
        };

      },
      templateUrl: 'components/mail/compose.tpl.html',
      link: function ($scope, element, attrs) {
        $scope.currentUser = authService.currentUser();
        $scope.newMail = {id: $scope.currentUser.id, to: [], subject: '', body: ''};
        $scope.mail = angular.copy($scope.newMail);

          $scope.$watch($scope.users, function (oldVal, newVal) {
              setTimeout(function () {
                  //this timeout is a workaround because the event is fired before the options are
                  //added to the select tag
                  $("select[name='to']").trigger('chosen:updated');
              }, 700);
          });

        $("select[name='to']").chosen();
        tinymce.init({
          height: 200,
          menubar: false,
          statusbar: false,
          mode: "textareas",
          selector: "#messageBody",
          setup: function (ed) {
              //listening several events which can update the data
            ed.on('init', function (args) {
              $scope.mail.body = ed.getContent();
            });
            // Update model on button click
            ed.on('ExecCommand', function (e) {
              ed.save();
              $scope.mail.body = ed.getContent();
            });
            // Update model on keypress
            ed.on('KeyUp', function (e) {
              ed.save();
              $scope.mail.body = ed.getContent();
            });
          }
        });

      }
    };
  };
  return ['authService', 'userService', 'mailService', 'tipService', MailCompose];
});