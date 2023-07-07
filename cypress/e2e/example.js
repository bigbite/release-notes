import { Given, When, Then } from '@badeball/cypress-cucumber-preprocessor';

Given('some release notes are published', () => {
  cy.seed('ReleaseNoteSeeder');
});

When('the user visits the release notes page', () => {
  cy.visit('/wp-admin/admin.php?page=release-notes');
});

Then('the latest release notes should be visible', () => {
  cy.get('article.release-note-single').should('exist');
});
Then('the placeholder message is visible', () => {
  cy.get('article.release-note-single h1.release-note-title').contains('Release not found!');
});
