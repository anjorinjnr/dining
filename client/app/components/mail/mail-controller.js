/**
 * 
 * Parent class for mail controllers.
 * Provides common methods for the messaging.
 */

define([], function () {

  var MailController = function () {

  };

  /**
   * Toggle selecting all mails in the table
   */
  MailController.prototype.masterSelect = function () {
    this.master = !this.master;
    if (this.master) {
      var ids = [];
      this.messages.data.forEach(function (message) {
        ids.push(message.id);
      });
      this.selected = ids;
    } else {
      this.selected = [];
    }
  };

  /**
   * Query server for user's sent messages
   */
  MailController.prototype.loadMessages = function () {
    if (_.isUndefined(this.master)) {
      this.master = false;
    }
    if (_.isUndefined(this.selected)) {
      this.selected = [];
    }


    var self = this;
    self.tipService
            .loading()
            .delay(function () {
              self.mailService.messages(self.params, function (resp) {
                self.messages = resp;
                if (typeof self.processMessages === 'function') {
                  self.processMessages(self.messages);
                }

              });
            })
            .show();
  };



  /**
   * Toggle selecting a mail in the table to the acted upon
   * @param message
   */
  MailController.prototype.selectMail = function (message) {
    console.log(this.selected);
    var i = this.selected.indexOf(message.id);
    if (i >= 0) {
      this.selected.splice(i, 1);
    } else {
      this.selected.push(message.id);
    }

  };

  /**
   * Go to next page of messages
   * @returns
   */
  MailController.prototype.nextPage = function () {
    if (this.messages.current_page <
            this.messages.last_page) {
      this.params.page = this.messages.current_page + 1;
      this.loadMessages();
    }
  };
  /**
   * Go to next previous page of messages
   * @returns
   */
  MailController.prototype.prevPage = function () {
    if (this.messages.current_page > 1) {
      this.params.page = this.messages.current_page - 1;
      this.loadMessages();
    }
  };

  /**
   * Search messages on server
   * @param {string} query
   */
  MailController.prototype.search = function (query) {
    var self = this;
    if (_.isEmpty(query)) {
      this.params.page = 1;
      this.loadMessages();
    } else {
      self.tipService.loading()
              .delay(function () {
                self.mailService.search({id: self.params.id,
                  mail_type: self.params.mail_type,
                  query: query}, function (data) {
                  self.messages = data;
                  if (typeof self.processMessages === 'function') {
                    self.processMessages(self.messages);
                  }
                });
              })
              .show();
    }
  };

  /**
   * Delete selected messages on server;
   */
  MailController.prototype.deleteMessage = function () {
    var self = this;
    self.mailService.delete({id: this.params.id,
      mail_type: this.params.mail_type},
    this.selected,
            function (resp) {
              if (resp.status === 'success') {
                var info = 'Deleted ' + self.selected.length +
                        ((self.selected.length > 1) ? ' messages.' :
                                ' message.');
                self.tipService.info(info).show();
                if (self.selected.length ===
                        self.messages.data.length) {
                  //if user deleted all messages on current page
                  //load next or prev page
                  if (self.messages.current_page ===
                          self.messages.last_page
                          && self.messages.current_page > 1) {
                    self.params.page = self.messages.current_page - 1;
                    self.loadMessages();
                  } else if (self.messages.current_page === 1 &&
                          self.messages.last_page > 1) {
                    self.params.page = self.messages.current_page + 1;
                    self.loadMessages();
                  } else {
                    self.messages.total = 0;
                    self.messages.data = [];
                  }

                } else {
                  var url = [self.API_PATH, 'user/', self.params.id, '/mail/',
                    self.params.mail_type];
                  if (self.messages.current_page === 1 &&
                          self.$cacheFactory.get('$http').get(url.join(''))) {
                    self.$cacheFactory.get('$http').remove(url.join(''));
                  } else {
                    url = url.concat(['?page=', self.messages.current_page]);
                    self.$cacheFactory.get('$http').remove(url.join(''));
                  }
                  self.loadMessages();
                }
                self.selected = [];
                self.master = false;
              } else {
                self.tipService.ajaxError();
              }

            });
  };

  return MailController;
});
