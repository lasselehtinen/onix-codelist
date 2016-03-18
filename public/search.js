var instantsearch = instantsearch;

var search = instantsearch({
  appId: '0AX2Y3FFW8', // Mandatory
  apiKey: 'ed59fb1126ff48502e68207c0488c5ba', // Mandatory
  indexName: 'codelists', // Mandatory
  urlSync: { // optionnal, activate url sync if defined
    useHash: false
  }
});

// Add a searchBox widget
search.addWidget(
  instantsearch.widgets.searchBox({
    container: '#search-box',
    placeholder: 'Search for libraries in France...'
  })
);

var hitTemplate =
  '<p>{{description}}</p>';

var noResultsTemplate =
  '<div class="text-center">No results found matching <strong>{{query}}</strong>.</div>';

// Add a hits widget
search.addWidget(
  instantsearch.widgets.hits({
    container: '#hits-container',
    hitsPerPage: 10,
    templates: {
      empty: noResultsTemplate,
      item: hitTemplate
    },
  })
);

// start
search.start();