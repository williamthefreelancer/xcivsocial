(function (global) {
  'use strict';

  var cfg = global.xcivSocial || {};

  /**
   * Minimal Vanilla JS WPGraphQL client.
   * @param {string} query
   * @param {object} [variables]
   * @returns {Promise<object>}
   */
  function graphql(query, variables) {
    return fetch(cfg.graphqlUrl || '/graphql', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': cfg.restNonce || '',
      },
      body: JSON.stringify({ query: query, variables: variables || {} }),
    }).then(function (res) {
      return res.json().then(function (body) {
        if (!res.ok || (body.errors && body.errors.length)) {
          var msg =
            (body.errors && body.errors[0] && body.errors[0].message) ||
            'GraphQL request failed';
          throw new Error(msg);
        }
        return body.data;
      });
    });
  }

  global.XCIV = global.XCIV || {};
  global.XCIV.graphql = graphql;
})(window);
