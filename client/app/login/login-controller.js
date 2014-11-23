/**
 * Created by eanjorin on 6/21/14.
 */
'use strict';
define([], function () {
    var LoginCtrl = function ($scope, authService) {
        this.userLogin = {};
        this.scope_ = $scope;
        console.log(authService)
        this.authService = authService;
        if(angular.isDefined(this.authService.activate) ){
          this.activate = this.authService.activate;
          delete this.authService.activate;
        } else {
          this.activate = null;
        }

    };
    LoginCtrl.prototype.login = function(form) {
        console.log('123');
        var self = this;
        form.submitted = true;
        if (form.$valid) {
            this.authService.login(this.user, function(error){
                console.log(error);
                self.loginError = error;
            });
        }
    };
    return ['$scope', 'authService', LoginCtrl];
});
