define([/*'angular',
        'angularResource',*/
        './sta-directive',
        './state-service',
        './town-service',
        './area-service'], function(/*angular, ngResource,*/StaDirective, StateService, TownService, AreaService)
{
   return  angular.module('nt.state-town-area', ['ngResource'])
       .directive('statetownarea', StaDirective)
       .service('stateService', StateService )
       .service('townService', TownService )
       .service('areaService', AreaService );
});

