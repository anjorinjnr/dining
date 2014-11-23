/**
 * Created by eanjorin on 7/23/14.
 */
'use strict';
define(['user/user', 'components/paginator/paginator'], function (User, Paginator) {

  var StudentCtrl = function ($scope, $state, $modal, $location,
          authService, tipService, jobService) {

    this.state_ = $state;
    this.modal_ = $modal;
    this.scope_ = $scope;
    this.user = authService.currentUser();
    this.tipService = tipService;
    this.jobService = jobService;
    var self = this;
    this.init = function (path) {
      switch (path) {
        case '/student/requests':
          this.active = 'requests';
          getTutorRequests(self);
          break;
        case '/student/requests/applications':
          getTutorRequests(self);
      }
    };
    this.init($location.path());
    this.jobPaginator = new Paginator(10);
    this.filterAppByJob = function (item) {

      if (angular.isDefined(self.jobFilter) && self.jobFilter !== null) {
        return item.job_id === self.jobFilter.id;
      }
      return true;
    };
  };
  //inherit share methods from the user class
  StudentCtrl.prototype = User.prototype;
  StudentCtrl.prototype.constructor = StudentCtrl;

  /**
   * Show the applications view for the selected job
   * @param {object} job
   * @returns {undefined}
   */
  StudentCtrl.prototype.viewApplications = function (job) {
    this.jobFilter = job;
    this.state_.go('index.student.tutor-applications');
  };

  var tutorAppModal;

  StudentCtrl.prototype.viewApplication = function (app) {
    this.scope_.app = app;
    console.log(app);
    tutorAppModal = this.modal_({
      scope: this.scope_,
      template: 'student/tutor-application-modal.html',
      show: true
    });
    //dconsole.log(tutorAppModal);
  };
  /**
   * Show the tutor requests view for this user
   * @returns {undefined}
   */
  StudentCtrl.prototype.showRequests = function () {
    getTutorRequests(this);
    this.goto('index.student.requests', {active: 'requests'});
  };

  /**
   * Delete all selected jobs in the database and in the paginator.
   * @returns {undefined}
   */
  StudentCtrl.prototype.deleteJobRequests = function () {
    var self = this;
    //self.jobPaginator.delete();
    self.tipService
            .loading()
            .delay(function () {
              self.jobService.delete({id: self.user.id}, self.jobPaginator.selected,
                      function (resp) {
                        if (resp.status === 'success') {
                          self.jobPaginator.delete();
                          self.user.jobs = self.jobPaginator.data;
                        } else {
                          self.tipService
                                  .error('Unable to complete action, please try again.')
                                  .show();
                        }
                      });
            })
            .show();
  };

  /**
   * Submit a new Tutor Request
   * @returns {undefined}
   */
  StudentCtrl.prototype.newRequest = function () {
    var self = this;
    this.scope_.alert = {
      visible: false
    };
    this.scope_.request = {};
    this.scope_.modal = {};
    this.scope_.modal.action = function (form) {
      form.submitted = true;
      if (form.$valid && !jQuery.isEmptyObject(self.scope_.request.subject)) {
        var request = self.scope_.request;
        self.tipService
                .loading()
                .delay(function () {
                  self.jobService.save(
                          {
                            'student_id': self.user.id,
                            'subject_id': request.subject.id,
                            'details': request.message
                          }, function (resp) {
                    if (resp.status === 'success') {
                      modal.hide();
                      self.user.jobs.push(resp.job);
                      self.jobPaginator.setData(self.user.jobs);
                      self.jobPaginator.changePage();
                    }
                  });
                })
                .show();
      }
    };
    var modal = this.modal_({
      scope: this.scope_,
      template: 'student/tutor-request-modal.html',
      show: true
    });

  };

  StudentCtrl.prototype.contactTutor = function () {
    tutorAppModal.hide();
    this.scope_.message = {
      from: this.user.id,
      recipientName: this.scope_.app.tutor,
      to: [this.scope_.app.tutor_id],
      subject: ['Re: ', this.scope_.app.request_subject, ' tutor request.']
              .join('')
    };

    this.modal_({
      scope: this.scope_,
      template: 'components/mail/compose-modal.html',
      animation: 'am-fade-and-slide-top',
      show: true
    });
  };

  /**
   * Gets all tutor requests submitted by this user
   * @param {student.StudentCtrl} ctrl
   * @returns {undefined}
   */
  function getTutorRequests(ctrl) {
    ctrl.scope_.tipService.loading().show();
    ctrl.jobService.query({user_id: ctrl.user.id}, function (resp) {
      ctrl.user.jobs = resp;
      ctrl.jobPaginator.setData(resp);
      // console.log(ctrl.user.jobs);
      ctrl.user.tutorApplications = [];
      ctrl.user.jobs.forEach(function (job) {
        job.applications.forEach(function (app) {
          app.request_subject = job.subject.title;
          app.request_date = job.created_at;
        });
        ctrl.user.tutorApplications = ctrl.user.tutorApplications
                .concat(job.applications);
      });
      //console.log(resp);
      ctrl.scope_.tipService.hide();
    });
  }


  return ['$scope', '$state', '$modal', '$location', 'authService',
    'tipService', 'jobService', StudentCtrl];
});
