import { When, Then } from '@badeball/cypress-cucumber-preprocessor';

When('I visit the release notes page', () => {
  cy.visit('/wp-admin/admin.php?page=release-notes');
});

Then('I should see a release note', () => {
  cy.get('article.release-note-single').should('exist');
});
