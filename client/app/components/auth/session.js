define(['', ''], function (obj) {

    var Session = function () {
        this.create = function (sessionId, userId, userType) {
            this.id = sessionId;
            this.userId = userId;
            this.userType = userType;
        };
        this.destroy = function () {
            this.id = null;
            this.userId = null;
            this.userType = null;
        };
    };
    return Session;
})