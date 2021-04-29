(function () {

    var scriptName = "alert-embed.js"; //name of this script, used to get reference to own tag
    var jQuery; //noconflict reference to jquery
    var jqueryPath = "//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js";
    var jqueryVersion = "3.6.0";
    var scriptTag; //reference to the html script tag

    /******** Get reference to self (scriptTag) *********/
    var allScripts = document.getElementsByTagName('script');
    var targetScripts = [];
    for (var i in allScripts) {
        var name = allScripts[i].src
        if(name && name.indexOf(scriptName) > 0)
            targetScripts.push(allScripts[i]);
    }

    scriptTag = targetScripts[targetScripts.length - 1];

    /******** helper function to load external scripts *********/
    function loadScript(src, onLoad) {
        var script_tag = document.createElement('script');
        script_tag.setAttribute("type", "text/javascript");
        script_tag.setAttribute("src", src);

        if (script_tag.readyState) {
            script_tag.onreadystatechange = function () {
                if (this.readyState == 'complete' || this.readyState == 'loaded') {
                    onLoad();
                }
            };
        } else {
            script_tag.onload = onLoad;
        }
        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    }

    /******** helper function to load external css  *********/
    function loadCss(href) {
        var link_tag = document.createElement('link');
        link_tag.setAttribute("type", "text/css");
        link_tag.setAttribute("rel", "stylesheet");
        link_tag.setAttribute("href", href);
        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(link_tag);
    }

    /******** load jquery into 'jQuery' variable then call main ********/
    if (window.jQuery === undefined || window.jQuery.fn.jquery !== jqueryVersion) {
        loadScript(jqueryPath, initjQuery);
    } else {
        initjQuery();
    }

    function initjQuery() {
        jQuery = window.jQuery.noConflict(true);
        main();
    }

    /******** starting point for your widget ********/
    function main() {
        // main widget code

        jQuery(document).ready(function ($) {
            var rule_id = scriptTag.src.split("?id=")[1];
            var site_path = scriptTag.src.split("?id=")[0];
            var hostname = $('<a>').prop('href', site_path).prop('protocol') + '//' + $('<a>').prop('href', site_path).prop('host');
            var baseURI = window.location.pathname+location.search;

            var api_url = hostname+"/api/check-rule-conditions/"+rule_id;
            jQuery.getJSON(api_url, {url: baseURI}, function(result) {
              console.log(result);
              if(result.show) {
                  alert(result.text)
              }
            });


        });
    }

})();
