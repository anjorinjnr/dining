/**
 * Created by eanjorin on 10/5/14.
 */
'use strict';
define([], function () {

   var MainCtrl =   function ($scope, authService, $modal, tipService, UPLOAD_PATH) {
       //console.log(user);

       /*console.log('mainctrl..');
       var userId = $cookies['user-id'];
       if (userId) {
           $http.get(API_PATH +  'user/' + userId).success(function(data){
               console.log(data);
               if(data.success === 'success') {
                   authService.user = data.user;
               }
           })

       } else {
           console.log('no-user')
       };*/
       //$scope.styles = 'styles/pages/page_log_reg_v1.css';
       $scope.uploadPath = UPLOAD_PATH;
       this.authService = authService;
       console.log(authService.isLoggedIn());
       $scope.tipService = tipService;
       this.modal_ = $modal;
       //this.user = authService.currentUser() || {};

   };
    MainCtrl.prototype.login = function() {
      this.modal_({
            scope: this.scope_,
            template: 'login/login-modal.html',
            animation: 'am-fade-and-slide-top',
            show: true
        });

    };
    //return ['$scope', 'authService', 'tipService', '$cookies', '$http', 'API_PATH', MainCtrl];
    return ['$scope', 'authService', '$modal', 'tipService', 'UPLOAD_PATH', MainCtrl];
});
