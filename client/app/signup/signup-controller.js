/**
 * Created by eanjorin on 6/13/14.
 */
 'use strict';
define([], function () {
    /*jshint camelcase: false */
    var SignUpCtrl = function ($scope, $upload, $state, $stateParams, userService, $location, authService, $filter) {

        this.authService = authService;
        this.user = {};
        this.state_ = $state;
        this.upload_ = $upload;
        this.staRequired = 'sta';
        this.userType = $filter('sentencecase')($stateParams.userType);
        if (this.userType === 'Tutor') {
            this.user.user_type = 1; 
        } else {
            this.user.user_type = 0;
        }

    };

    SignUpCtrl.prototype.signUp = function (form) {
        var self = this;
        form.submitted = true;
        if (form.$valid && this.user.password === this.user.confirm_password) {
            this.authService.signUp(this.user, function() {
                var state = (self.user.user_type === 0) ? 'index.student.welcome' : 'index.tutor-complete-signup.profile';
                self.state_.go(state);
            }, function(errors) {
                self.signUpErrors = errors;
            });
        }

    };

    return ['$scope', '$upload', '$state', '$stateParams', 'userService', '$location', 'authService', '$filter', SignUpCtrl];

});
