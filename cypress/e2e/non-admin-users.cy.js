/// <reference types="cypress" />

describe('non admin users should not be able to access release notes post type', () => {
    beforeEach(() => {
        cy.switchUser('Editor');
        cy.visit("/wp-admin");
    });

    it('should not allow non admin users to create release notes', () => {
        cy.get('#menu-posts-release-note > .wp-has-submenu > .wp-menu-name').should('not.exist');
        cy.get('#toplevel_page_release-notes > .wp-not-current-submenu > .wp-menu-name').should('exist');
    })
})