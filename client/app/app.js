/**
 * Creates the main application modules,
 * Injects the other modules used e.g controllers, directives, services etc
 *
 */
define([
    //'angular',
    'login/login-controller',
    'home/home-controller',
    'student/student-controller',
    'tutor/tutor-controller',
    'main/main-controller',
    'signup/signup-controller',
    'search/search-controller',
    'components/states-config/states-config',
    'components/auth/auth-service',
    'components/user/user-service',
    'components/tutor/tutor-service',
    'components/search/search-service',
    'components/subject/subject-service',
    'components/mail/mail-service',
    'components/job/job-service',
    'components/sentence-case-filter/sentence-case-filter',
    'components/subject/subject-category-filter',
    'components/date-time-filter/date-time-filter',
    'components/star-ratings/star-rating-directive',
    './run',
    'components/tip/tip-module',
    'components/state-town-area-directive/sta-module',
    'components/subject/subject-directive/subj-module',
    'components/mail/mail-module',
], function (LoginCtrl, HomeCtrl, StudentCtrl, TutorCtrl, MainCtrl, SignUpCtrl, SearchCtrl,
             StatesConfig, AuthService, UserService, TutorService, SearchService,
             SubjectService, MailService, JobService,
             scFilter, subjCategoryFilter, dateTimeFilter, ratingsDirective, InitRun) {
    'use strict';
    var neartutor = {};
    neartutor.module = angular.module('neartutors', [
        'ui.router',
        'tip.bar',
        'uiSlider',
        'ngResource',
        'ngCookies',
        'mgcrea.ngStrap',
        'angularFileUpload',
        'nt.state-town-area',
        'nt.select-subject',
        'nt.mail'
    ]);
    //console.log(LoginCtrl);

    neartutor.module
        .config(StatesConfig)
        .filter('sentencecase', scFilter)
        .filter('formatdate', dateTimeFilter)
        .filter('bysubjectcategory', subjCategoryFilter)
        .directive('starRating', ratingsDirective)
        .service('authService', AuthService)
        .service('userService', UserService)
        .service('tutorService', TutorService)
        .service('searchService', SearchService)
        .service('subjectService', SubjectService)
        .service('mailService', MailService)
        .service('jobService', JobService)
        .controller('LoginCtrl', LoginCtrl)
        .controller('HomeCtrl', HomeCtrl)
        .controller('MainCtrl', MainCtrl)
        .controller('SearchCtrl', SearchCtrl)
        .controller('SignUpCtrl', SignUpCtrl)
        .run(InitRun);
    console.log('created neartutors module');
    return neartutor.module;


});
