var exampleModuleObject = null;
var CSRFCheckManager = null;
var cookieMessageModule = null;
var loginModule = null;
var registrationModule = null;
var documentationModule = null;
var logListModule = null;

var initLibrary = function() {

    // Create your own modules in "/module" directory, then call them here

    require(["module/exampleModule"], function (object) {
        if (exampleModuleObject != null) return;
        exampleModuleObject = new object();
        exampleModuleObject.init();
    });

    /** 
    require(["module/cookieMessageModule"], function (object) {
        if (cookieMessageModule != null) return;
        cookieMessageModule = new object();
        cookieMessageModule.init();
    });
    */
    if (getElementsByClassName("CSRFcheck").length) {
        require(["module/CSRFCheckManager"], function (ccm) {
            if (CSRFCheckManager != null) return;
            CSRFCheckManager = new ccm();
            CSRFCheckManager.init();
        });
    }

    if (getElementsByClassName("login").length) {
        require(["module/loginModule"], function (m) {
            if (loginModule != null) return;
            loginModule = new m();
            loginModule.init();
        });
    }

    if (getElementsByClassName("registration").length) {
        require(["module/registrationModule"], function (m) {
            if (registrationModule != null) return;
            registrationModule = new m();
            registrationModule.init();
        });
    }

    if(getElementsByClassName("documentation").length) {
        require(["module/documentationModule"], function (dm) {
            documentationModule = new dm();
            documentationModule.init();
        });
    }

    if (getElementsByClassName("logList").length) {
        require(["module/logListModule"], function (m) {
            if (logListModule != null) return;
            logListModule = new m();
            logListModule.init();
        });
    }

};

initLibrary();