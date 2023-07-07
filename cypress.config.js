const { defineConfig } = require('cypress');

const webpack = require('@cypress/webpack-preprocessor');
const preprocessor = require('@badeball/cypress-cucumber-preprocessor');

async function setupNodeEvents(on, config) {
  // implement node event listeners here

  await preprocessor.addCucumberPreprocessorPlugin(on, config);

  on(
    'file:preprocessor',
    webpack({
      webpackOptions: {
        resolve: {
          extensions: ['.js'],
        },
        module: {
          rules: [
            {
              test: /\.feature$/,
              use: [
                {
                  loader: '@badeball/cypress-cucumber-preprocessor/webpack',
                  options: config,
                },
              ],
            },
          ],
        },
      },
    }),
  );

  config = require('@bigbite/wp-cypress/lib/cypress-plugin')(on, config);
  return config;
}

module.exports = defineConfig({
  e2e: {
    setupNodeEvents,
    specPattern: 'cypress/**/*.feature',
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
