/**
 * Created by eanjorin on 6/23/14.
 */
define([], function () {

    var config = {

        roles: {
            PUBLIC: -1,
            STUDENT : 0,
            TUTOR : 1
            /*USER: 2,
            ADMIN: 3 */
        },


        accessLevels: {
            PUBLIC : 0,
            USER : 1,
            ADMIN: 2
        }
    };

    return config;

})