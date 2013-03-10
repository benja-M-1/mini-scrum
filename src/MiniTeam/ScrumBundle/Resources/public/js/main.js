requirejs.config({
    paths: {
        'jquery': ["http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min"],
        'bootstrap': ["/bootstrap/js/bootstrap.min"]
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require([
    "jquery",
    "bootstrap"
]);
