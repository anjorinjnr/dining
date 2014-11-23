/**
 * Created by eanjorin on 10/8/14.
 */
 'use strict';
define([], function () {
  /*jshint camelcase: false */
    var SortOption = {
        LOWEST_PRICE: 1,
        HIGHEST_PRICE: 2,
        HIGHEST_RATING: 3,
        BEST_MATCH: 4,
        RECENTLY_JOINED: 5
    };

    var SearchCtrl = function ($scope, $state, $location, searchService, subjectService) {
        this.location_ = $location;
        this.state_ = $state;
        this.searchService = searchService;
        this.subjectService = subjectService;
        
        this.search = { 
            qry: $location.search(),
            errors: []
        };
        var self = this;
        $scope.$watch(function () {
            return self.search.subject;
        }, function () {
            if (angular.isDefined(self.search.subject)) {
                self.search.errors = [];
            }
        });
        if (this.search.qry.subject !== undefined) {
            //query for the subject (to get the subject's name)
             subjectService.get({id:this.search.qry.subject}, function(data) {
                if (data.status === 'success') {
                    //search tutors
                    self.search.subject = data.subject;
                    self.searchTutor(self.search.qry);
                }
             });
            
        }
    };

    SearchCtrl.prototype.sort = function () {
        this.searchTutor(this.search.qry);
    };
    
    SearchCtrl.prototype.searchTutor = function (qry) {
        var self = this;
        this.location_.search(jQuery.param(this.search.qry));
        this.searchService.tutors(qry, function (res) {
            if (res.status === 'success' && angular.isDefined(res.tutors)) {
                self.search.result = {};
                self.search.result.tutors = res.tutors;
                self.search.result.subject = self.search.subject.title;

            } else {
                self.search.result = {};
            }
        });

    };
    SearchCtrl.prototype.submitSearch = function () {

        if (!angular.isDefined(this.search.subject)) {
            this.search.errors = ['You must select a subject'];
        } else {
            this.search.qry.sort = SortOption.BEST_MATCH;
            this.search.qry.subject = this.search.subject.id;
            if (angular.isDefined(this.search.state_id)) {
                this.search.qry.state = this.search.state_id;
            }
            if (angular.isDefined(this.search.town_id)) {
                this.search.qry.town = this.search.town_id;
            }
            if (angular.isDefined(this.search.area_id)) {
                this.search.qry.area = this.search.area_id;
            }

            this.searchTutor(this.search.qry);
        }
    };

    SearchCtrl.prototype.next = function () {
        this.search.qry.page = this.search.result.tutors.current_page + 1;
        this.searchTutor(this.search.qry);
    };
    SearchCtrl.prototype.prev = function () {
        this.search.qry.page = this.search.result.tutors.current_page - 1;
        this.searchTutor(this.search.qry);
    };

    SearchCtrl.prototype.openProfile = function (tutor) {
        this.state_.go('index.tutor-profile', {id: tutor.id});
    };

    return ['$scope', '$state', '$location', 'searchService', 'subjectService', SearchCtrl];
});