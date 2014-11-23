head.load('assets/vendor/jquery/dist/jquery.min.js', function () {
    $.getJSON('vendor.json')
        .done(function (vendorjs) {
            head.load(vendorjs, function() {
                console.log('Loaded vendor files');
                require(['app', 'config'], function() {
                    angular.bootstrap(document, ['neartutors']);
                    console.log('Angular is ready and bootstrapped');
                });
            });
        }).fail(function(e) {
            //really bad, now what
        });
});
