!function ($) {
    "use strict";
    var engine, remoteHost, template, empty;
    $.support.cors = true;
    remoteHost = myLabel.baseUrl;
    template = Handlebars.compile($("#result-template").html());
    empty = Handlebars.compile($("#empty-template").html());
    engine = new Bloodhound({
        identify: function identify(o) {
            return o.id;
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        dupDetector: function dupDetector(a, b) {
            return a.id === b.id;
        },
        prefetch: remoteHost + '/api/search',
        remote: {
            url: remoteHost + '/api/search?q=%QUERY',
            wildcard: '%QUERY'
        }
    }); // ensure default users are read on initialization
    // engine.get('1090217586', '58502284', '10273252', '24477185')

    function engineWithDefaults(q, sync, async) {
        if (q === '') {
            //sync(engine.get('1090217586', '58502284', '10273252', '24477185'));
            async([]);
        } else {
            engine.search(q, sync, async);
        }
    }

    $('.js-typeahead').typeahead({
        hint: $('.Typeahead-hint'),
        menu: $('.Typeahead-menu'),
        minLength: 0,
        classNames: {
            open: 'is-open',
            empty: 'is-empty',
            cursor: 'is-active',
            suggestion: 'Typeahead-suggestion',
            selectable: 'Typeahead-selectable'
        }
    }, {
        source: engineWithDefaults,
        displayKey: 'name',
        templates: {
            suggestion: template,
            empty: empty
        }
    }).on('typeahead:asyncrequest', function () {
        $('.Typeahead-spinner').show();
    }).on('typeahead:asynccancel typeahead:asyncreceive', function () {
        $('.Typeahead-spinner').hide();
    }).on('typeahead:autocomplete', function (e, suggestion) {}).on('typeahead:select', function (event, suggestion) {
      //  console.log(suggestion);
        var slug = suggestion.slug;
        //console.log(suggestion.category.slug);
        setTimeout(function() {
            window.location.href = myLabel.baseUrl + suggestion.category.slug;
        }, 300);
        //window.location.href = "".concat(BASE_URL, "event/").concat(slug);
    });
}(window.jQuery);



