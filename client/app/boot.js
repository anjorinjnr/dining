head.load('assets/vendor/jquery/dist/jquery.min.js', function () {
    $.getJSON('vendor.json')
        .done(function (vendorjs) {
            //console.log(vendorjs);
            head.load(vendorjs, function() {
                console.log('Loaded vendor files');
                require(['app', 'config'], function() {
                    angular.bootstrap(document, ['neartutors']);
                    console.log('Angular is ready and bootstrapped');
                });
            });
        }).fail(function(e) {
            console.log(e.error());
            //really bad, now what
        });
});
