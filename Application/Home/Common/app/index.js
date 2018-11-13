(function () {
    var entry,
        app = {
            home : '/app/home',	
            login : '/app/login'	
        };

    (function(){

        var dataMain, scripts = document.getElementsByTagName('script'),
            eachScripts = function(el){
                dataMain = el.getAttribute('data-main');
                if(dataMain){
                    entry = dataMain;
                }
            };

        [].slice.call(scripts).forEach(eachScripts);

    })();	

    layui.config({
        base: path
    }).extend(app).use(entry || 'home');

})();