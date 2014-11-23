/**
 * Created by eanjorin on 10/5/14.
 */
'use strict';
define([], function () {

   var MainCtrl =   function ($scope, authService, tipService, UPLOAD_PATH) {
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
       $scope.tipService = tipService;
       //this.user = authService.currentUser() || {};

   };
    //return ['$scope', 'authService', 'tipService', '$cookies', '$http', 'API_PATH', MainCtrl];
    return ['$scope', 'authService', 'tipService', 'UPLOAD_PATH', MainCtrl];
});
