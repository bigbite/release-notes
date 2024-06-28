/// <reference types="cypress" />

const userRoles = [
    'admin',
    'editor',
    'subscriber',
    'contributor',
    'author',
];

describe('users can see the release notes widget in the dashboard', () => {

    userRoles.forEach((role) => {

        describe(`${role} access`, () => {
            beforeEach(() => {
                cy.switchUser(role);
                cy.visit('/admin/');
            })

            it(`should allow ${role} to see the release notes widget`, () => {
                cy.get('#release_notes_widget').should('be.visible');
                cy.get('#release_notes_widget').should('contain', 'Whats Changed?');
                cy.get('.release-note-footer > a').should('contain', 'View All Release Notes');
            });
        });

    });
});