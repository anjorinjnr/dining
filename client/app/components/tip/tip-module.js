/**
 * Created by eanjorin on 9/23/14.
 */
define(['./tip-service', './tip-directive'], function ( TipService, TipDirective) {
    'use strict';
    return  angular.module('tip.bar', [])
        .service('tipService', TipService)
        .directive('tipBar', TipDirective);
});
