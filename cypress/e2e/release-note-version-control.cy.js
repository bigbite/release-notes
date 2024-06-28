/// <reference types="cypress" />

describe('release notes version control', () => {
    before(() => {
        cy.visit('/wp-admin/edit.php?post_type=release-note');
    });

    it('should change the version accordingly after a release note has been deleted', () => {
        //asserts that the version number is the current version
        cy.get('#wpadminbar').within(() => {
            cy.get('#wp-admin-bar-release-note-version > a').should('contain', 'Version 1.6.0');
        })
        //deletes the current release note in the post list
        cy.get('#the-list').within(() => {
            cy.get('#post-5 .row-actions').invoke('attr', 'style', 'position: static').find('.submitdelete').click();
            cy.visit('/wp-admin/edit.php?post_type=release-note');
            cy.get('tr').should('have.length', 1);
        });
        //asserts that the version number has changed to the previous release note version
        cy.get('#wpadminbar').within(() => {
            cy.get('#wp-admin-bar-release-note-version > a').should('contain', 'Version 1.5.0');
        })    });
});