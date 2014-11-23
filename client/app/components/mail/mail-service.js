/**
 * Created by eanjorin on 10/5/14.
 */
define([], function () {

  var MailService = function ($resource, API_PATH) {
    var Mail = $resource(API_PATH + 'user/:id',
      {id: '@id'},
      {
        send: {
          method: 'POST',
          url: API_PATH + 'user/:id/mail',
          isArray: false
        },
        delete: {
          method: 'POST',
          url: API_PATH + 'user/:id/mail/delete/:mail_type',
          isArray: false
        },
        receive: {
          method: 'GET',
          url: API_PATH + 'user/:id',
          isArray: false
        },
        messages: {
          method: 'GET',
          url: API_PATH + 'user/:id/mail/:mail_type',
          isArray: false,
          cache: true
        },
        search: {
          method: 'GET',
          url: API_PATH + 'user/:id/mail/search/:mail_type',
          isArray: false,
          cache: true
        },
        get: {
          method: 'GET',
          url: API_PATH + 'mail/:mail_type/:id',
          isArray: false,
          cache: true
        }

      }
    );

    return Mail;

  };
  return ['$resource', 'API_PATH', MailService];
});

