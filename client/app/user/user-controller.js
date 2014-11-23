/**
 * Created by eanjorin on 10/22/14.
 */
define([], function () {

    var UserCtrl = function ($scope, $state, userService, authService, tipService,
                             $modal, $upload) {
        this.user = authService.currentUser();
        this.uploader_ = $upload;

        if (this.user.birth_date !== null) {
            var dob = this.user.birth_date.split('-');
            this.user.month = parseInt(dob[1]);
            this.user.day = parseInt(dob[2]);
            this.user.year = dob[0];
            console.log(this.user);
        }
        this.userService = userService;
        this.tipService = tipService;
        this.state_ = $state;
        this.modal_ = $modal;
    };

    UserCtrl.prototype.fileSelect = function ($files) {
        var self = this;

        function postUpload(paths) {
            self.user.photo_path = paths[0];
            console.log(self.user.photo_path);
        }

        this.tipService
            .loading('Uploading...')
            .delay(function () {
                self.userService.uploadPhoto(self.uploader_, self.user.id, $files, postUpload);
                self.upload = false;
            })
            .show();

        this.user.photos = $files;
        console.log(this.user.photos);
    };
    UserCtrl.prototype.updateProfile = function () {
        var self = this;
        if (angular.isNumber(this.user.month) &&
            angular.isNumber(this.user.day) &&
            angular.isNumber(this.user.day)) {
            this.user.birth_date = [this.user.year, this.user.month, this.user.day].join('-');
        }
        if ('permissions' in this.user) {
            delete this.user.permissions;
        }
        this.tipService
            .info('Updating profile...')
            .delay(
            function () {
                self.userService.save({id: self.user.id}, self.user, function (resp) {
                    if (resp.status === 'success') {
                        self.tipService.info('Profile updated.').show();
                    } else {
                        self.tipService.info('Unable to update profile. Please try again.').show();
                    }
                });
            }
        ).show();


    };
    /**
     * Navigate to the provided state.
     * Optionally set the class property if provided
     * @param state
     * @param params
     */
    UserCtrl.prototype.goto = function (state, params) {
        console.log(state);
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
    UserCtrl.prototype.resendConfirmation = function () {
        var self = this;
        self.userService.resendConfirmation(self.user, function (data) {
            if (data.status === 'success') {
                self.tipService.info(data.message).show();
            }
        });
    };
    return ['$scope', '$state', 'userService', 'authService', 'tipService', '$modal',
        '$upload', UserCtrl];
})
;
