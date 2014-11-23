/**
 * Created by eanjorin on 10/22/14.
 */
define([], function () {

  var User = function () {
  };

  /**
   * Navigate to the provided state.
   * Optionally set the class property if provided
   * @param state
   * @param params
   */
  User.prototype.goto = function(state, params) {
    if (angular.isDefined(this.state_)) {
      if (params !== undefined) {
        for (param in params) {
          this[param] = params[param];
        }
      }
      this.state_.go(state, params);
    }
  };

  /**
   * Resend user activation email
   */
  User.prototype.resendConfirmation = function () {
    var self = this;
    self.userService.resendConfirmation(self.user, function (data) {
      if (data.status === 'success') {
        self.tipService.info(data.message).show();
      }
    });
  };
  return User;
});
