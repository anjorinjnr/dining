/*
 * Directive to show ratings using 5 star scale
 */


define([], function () {

  var RatingDirective = function () {
    return {
      restrict: 'AE',
      templateUrl: 'components/star-ratings/star-rating.html',
      scope: {
        rating: '=',
        totalRatings: '='
      },
      link: function (scope, elem, attrs) {}
    };
  };

  return  RatingDirective;

});
