/**
 * Created by jgutix on 10/28/14.
 */
define(['./compose-directive', './compose-modal-directive',
    './inbox-directive', './sent-directive', './detail-directive', './sent-detail-directive'],
  function (mailCompose, mailComposeModal, mailInbox, mailSent, mailDetail, sentDetail) {
    return angular.module('nt.mail', [])
      .directive('mailCompose', mailCompose)
      .directive('mailComposeModal', mailComposeModal)
      .directive('mailInbox', mailInbox)
      .directive('mailSent', mailSent)
      .directive('mailDetail', mailDetail)
      .directive('sentDetail', sentDetail);
  });
