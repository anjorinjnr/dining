/**
 * 
 * Parent class for detail controllers.
 * Provides common methods for the messaging.
 */

define([], function () {

  var DetailController = function () {

  };

  /**
   * Query server for user message
   */
  DetailController.prototype.loadMessage = function () {
    /*if (_.isUndefined(this.master)) {
      this.master = false;
    }
    if (_.isUndefined(this.selected)) {
      this.selected = [];
    }*/
    var self = this;
    self.tipService
            .loading()
            .delay(function () {
              self.mailService.get(self.params, function (resp) {
                if (typeof self.processMessage === 'function') {
                  self.processMessage(resp);
                }

              });
            })
            .show();
  };

  return DetailController;
});
