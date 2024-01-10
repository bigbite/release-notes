/// <reference types="cypress" />

describe('release notes can be deleted', () => {
    before(() => {
        cy.visit('/wp-admin/edit.php?post_type=release-note');
    });

    it('should allow administrators to delete release notes', () => {
        cy.get('#wpadminbar').within(() => {
            cy.get('.release-note a').should('contain', 'Version 1.6.0');
        })
        // cy.get('#wp-admin-bar-release-note-version > [aria-haspopup="true"]').should('contain', 'Version 1.6.0');
        cy.get('#the-list').within(() => {
            cy.get('#post-5 .row-actions').invoke('attr', 'style', 'position: static').find('.submitdelete').click();
            cy.visit('/wp-admin/edit.php?post_type=release-note');
            cy.get('tr').should('have.length', 1);
        });
        cy.get('#wpadminbar').within(() => {
            cy.get('.release-note a').should('contain', 'Version 1.5.0');
        })    });
});