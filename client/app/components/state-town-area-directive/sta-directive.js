/**
 * Created by eanjorin on 6/9/14.
 */

define([], function () {
    var StaDirective = function (stateService, townService) {
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                stateDefault: '@stateDefault',
                townDefault: '@townDefault',
                areaDefault: '@areaDefault',
                selectedState: '=',
                selectedTown: '=',
                selectedArea: '=',
                requiredFields: '@requiredFields',
                form: '=',
                label: '@label',
                horizontal: '@horizontal'
            },
            require: ['^?form', 'ngModel'],
            /*controller: ['$scope', 'stateService', 'townService' function($scope , stateService, townService){

             $scope.$watch('selectedState', function () {
             if ($scope.selectedState !== undefined) {
             $scope.towns = stateService.towns({id: $scope.selectedState});
             }

             });
             $scope.$watch('selectedTown', function () {
             if ($scope.selectedTown !== undefined) {
             //$scope.user.town = $scope.selectedTown;
             $scope.areas = townService.areas({id: $scope.selectedTown});
             }
             });
             $scope.$watch('selectedArea', function () {
             //$scope.user.area = $scope.selectedArea;
             });

             $scope.states = stateService.query();
             },*/
            templateUrl: 'components/state-town-area-directive/sta.html',
            link: function (scope, element, attrs, ctrls) {

                scope.$watch('selectedState', function () {
                    if (scope.selectedState !== undefined) {
                        scope.towns = stateService.towns({id: scope.selectedState});
                    }

                });
                scope.$watch('selectedTown', function () {
                    if (scope.selectedTown !== undefined) {
                        //$scope.user.town = $scope.selectedTown;
                        scope.areas = townService.areas({id: scope.selectedTown});
                    }
                });
                scope.$watch('selectedArea', function () {

                });

                scope.states = stateService.query();

                scope.form = ctrls[0];
                var ngModel = ctrls[1];
                if (attrs.required !== undefined) {
                    // If attribute required exists
                    // ng-required takes a boolean
                    scope.required = true;
                }

                scope.$watch('state', function () {
                    if (scope.state !== undefined && angular.isDefined(ngModel.$modelValue)) {
                        var user = ngModel.$modelValue;
                        user.state_id = scope.state.id;
                        ngModel.$setViewValue(user);
                    }
                });
                scope.$watch('town', function () {
                    if (scope.town !== undefined && angular.isDefined(ngModel.$modelValue)) {
                        var user = ngModel.$modelValue;
                        user.town_id = scope.town.id;
                        ngModel.$setViewValue(user);
                    }
                });
                scope.$watch('area', function () {
                    if (scope.area !== undefined && angular.isDefined(ngModel.$modelValue)) {
                        var user = ngModel.$modelValue;
                        user.area_id = scope.area.id;
                        ngModel.$setViewValue(user);
                    }
                });

                var stateElement = $(element).find("#sel-state");
                var townElement = $(element).find("#sel-town");
                var areaElement = $(element).find("#sel-area");


                stateElement.bind('change', function () {
                    scope.selectedState = $(this).val();
                    scope.$parent.$digest();
                    //console.log(scope.selectedState)
                });
                townElement.bind('change', function () {
                    scope.selectedTown = $(this).val();
                    scope.$parent.$digest();
                });

            }
        };
    };

    return ['stateService', 'townService', StaDirective];
});