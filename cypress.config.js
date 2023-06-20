const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
      config = require('@bigbite/wp-cypress/lib/cypress-plugin');
      return config;
    },
    watchForFileChanges: true,
    baseUrl: 'http://localhost:3333',
  },
  wordpressVersions: ['6.2.1'],
  wp: {
    port: 3333,
    dbPort: 3336,
    version: ['6.2.1'],
    themes: [],
    plugins: ['./'],
    multisite: 'subdomain',
    uploadsPath: 'cypress/uploads',
    config: {},
    phpVersion: 8.1,
  },
});
