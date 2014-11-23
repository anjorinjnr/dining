/**
 * Created by eanjorin on 10/7/14.
 */
'use strict';
define(['user/user'], function (User) {
  /*jshint camelcase: false */
  var TutorCtrl = function ($scope, $state, $location, $upload, authService, userService, tutorService, searchService, $modal) {


    var self = this;

    function setStep(path) {
      if (path.indexOf('/tutor/complete/') >= 0) {
        self.step = path.split('/')[3];
      } else if (path.indexOf('tutor/complete/') >= 0) {
        self.step = path.split('/')[2];
      }
    }

    var path = $location.path();
    setStep(path);
    $scope.$on('$stateChangeStart', function (event, toState) {
      setStep(toState.url);
    });
    this.tipService = $scope.tipService;
    this.state_ = $state;
    this.user = authService.currentUser();
    this.student = {};
    this.contactEmail = {};
    this.emailSent = false;
    this.accountCreated = false;
    this.passwordChanged = false;
    this.modal_ = $modal;
    this.userService = userService;
    this.tutorService = tutorService;
    this.searchService = searchService;
    this.upload_ = $upload;
    this.scope_ = $scope;
    this.termsDate = moment().format('MMMM Do YYYY');

    this.loadJobs();
  };

  TutorCtrl.prototype = User.prototype;
  TutorCtrl.prototype.constructor = TutorCtrl;

  TutorCtrl.prototype.addSubject = function (subject) {
    console.log(subject);

    if (_.isUndefined(this.user.tutor.subjects)) {
      this.user.tutor.subjects = [];
    }
    var idx = _.indexOf(this.user.tutor.subjects, subject);
    if (idx >= 0) {
      this.user.tutor.subjects.splice(idx, 1);
    } else {
      this.user.tutor.subjects.push(subject);
    }
  };

  TutorCtrl.prototype.finish = function () {
    var self = this;
    this.tutorService.agreeToTerms({id: this.user.id}, function (data) {
      if (data.status === 'success') {
        self.scope_.tipService.info('Profile updated.').delay(1000).show();
        self.state_.go('index.tutor.home');
      }
    });
  }

  TutorCtrl.prototype.next = function () {
    var self = this;

    function updateProfile() {
      self.tutorService.updateProfile(self.user, function (data) {
        if (data.status === 'success') {
          self.scope_.tipService.info('Profile updated.').delay(4000).show();
        }
      });
    }

    switch (this.step) {
      case 'profile':
        var dob = moment(this.user.dob, 'DD-MM-YYYY');
        if (dob.isValid()) {
          this.user.dob = dob.format('YYYY-MM-DD');
        } else {
          this.user.dob = '';
        }
        updateProfile();
        this.state_.go('index.tutor-complete-signup.personalize');
        break;
      case 'personalize':
        if (!_.isUndefined(this.user.photos)) {
          this.userService.uploadPhoto(this.upload_, this.user.id, this.user.photos);
        }
        updateProfile();
        this.state_.go('index.tutor-complete-signup.subjects');
        break;
      case 'subjects':
        this.state_.go('index.tutor-complete-signup.terms');
        this.tutorService.updateSubjects({id: this.user.id}, this.user.tutor.subjects, function(data){
          if (data.status === 'success'){
            self.scope_.tipService.info('Profile updated.').show();
          }
        });
        break;

    }

  };

  TutorCtrl.prototype.fileSelect = function ($files) {
    this.user.photos = $files;
    console.log(this.user.photos);
  };

  TutorCtrl.prototype.skip = function () {
    switch (this.step) {
      case 'profile':
        this.state_.go('index.tutor-complete-signup.personalize');
        break;
      case 'personalize':
        this.state_.go('index.tutor-complete-signup.subjects');
        break;
      case 'subjects':
        this.state_.go('index.tutor-complete-signup.terms');
        break;
    }
  };


  TutorCtrl.prototype.showStep = function (step) {
    this.step = step;
    switch (this.step) {
      case 'profile':
        this.state_.go('index.tutor-complete-signup.profile');
        break;
      case 'personalize':
        this.state_.go('index.tutor-complete-signup.personalize');
        break;
      case 'subjects':
        this.state_.go('index.tutor-complete-signup.subjects');
        break;
      case 'terms':
        this.state_.go('index.tutor-complete-signup.terms');
        break;


    }
  };

  TutorCtrl.prototype.sendMessage = function (form) {

    form.submitted = true;
    if (form.$valid) {
      if (!jQuery.isEmptyObject(this.student)) {
        //create student account
        //expects user object (newly created) with tmp password
        this.accountCreated = true;
        this.student.temp_password = 'password123';
        this.auth.user = this.student;
      }
      //send email
      this.emailSent = true;
      this.contactEmail.recipient = this.tutor.id;
      this.contactEmail.sender = this.auth.currentUser().id;
    }
  };


  TutorCtrl.prototype.changePassword = function () {

    var modal;
    this.modal = {};
    this.modal.action = function (form) {
      form.submitted = true;
      if (form.$valid && this.student.password === this.student.confirm_password) {
        this.passwordChanged = true;
        modal.hide();
      } else {

      }
    };
    modal = this.modal_({
      scope: this.scope_,
      template: 'views/modals/change-password.html',
      //template: 'app/views/templates/modal.tpl.html',
      show: true
    });

  };

    TutorCtrl.prototype.searchJob = function () {
        var $scope = this.scope_;
        $scope.resultLabel = "Search results for \"" + this.scope_.subjectSearch + "\"";

        this.searchService.jobs({title: this.scope_.subjectSearch}, function(data){
            $scope.jobs = _.filter(data, function(item){
               return item.subject != null;
            });
        });
        return false;
    };

    TutorCtrl.prototype.loadJobs = function () {
        var $scope = this.scope_;
        $scope.resultLabel = "Jobs based on Tutor's subjects";
        this.tutorService.jobs({id: this.user.id}, function (data) {
            $scope.jobs = data;
        });

    };

  return ['$scope', '$state', '$location', '$upload', 'authService',
    'userService', 'tutorService', 'searchService', '$modal', TutorCtrl];
});
