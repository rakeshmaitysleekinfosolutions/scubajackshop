$(document).ready(function() {
  var engine, remoteHost, template, empty;

  $.support.cors = true;

  remoteHost = API_URL;
  template = Handlebars.compile($("#result-template").html());
  empty = Handlebars.compile($("#empty-template").html());

  engine = new Bloodhound({
    identify: function(o) { return o.id; },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    dupDetector: function(a, b) { return a.id === b.id; },
    prefetch: remoteHost + '/autocompleteEventHandler',
    remote: {
      url: remoteHost + '/autocompleteEventHandler?q=%QUERY',
      wildcard: '%QUERY'
    }
  });

  // ensure default users are read on initialization
 // engine.get('1090217586', '58502284', '10273252', '24477185')

  function engineWithDefaults(q, sync, async) {
    if (q === '') {
      //sync(engine.get('1090217586', '58502284', '10273252', '24477185'));
      async([]);
    }

    else {
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
    displayKey: 'title',
    templates: {
      suggestion: template,
      empty: empty
    }
  })
  .on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  })
  .on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.Typeahead-spinner').hide();
  })
  .on('typeahead:autocomplete', function(e, suggestion) {
    //console.log('e: ' + e);
   // console.log('Selection: ' + suggestion);
  })
  .on('typeahead:select', function(event, suggestion) {
    const {slug} = suggestion;
    window.location.href = `${BASE_URL}event/${slug}`;
    //console.log('event ' + event)

  });

});