/// <reference types="cypress" />

const userRoles = [
    {
        'userRole': 'admin',
    },
    {
        'userRole': 'editor',
    },
    {
        'userRole': 'subscriber',
    },
    {
        'userRole': 'contributor',
    },
    {
        'userRole': 'author',
    },
]

describe('All users can access the release notes page', () => {

    userRoles.forEach((role) => {

        describe(`${role.userRole} accees`, () => {
            beforeEach(() => {
                cy.switchUser(role.userRole);
                cy.visit('/admin/');
            })
        
            it(`should allow ${role.userRole} to see the release notes page`, () => {
                cy.get('#toplevel_page_release-notes > .wp-not-current-submenu > .wp-menu-name').contains('Release Notes').should('exist');
                cy.get('#toplevel_page_release-notes > .wp-not-current-submenu > .wp-menu-name').click();
                cy.url().should('eq', Cypress.config().baseUrl + '/wp-admin/admin.php?page=release-notes');
                cy.url().should('contain', 'release-notes');
            })
        })

    })
    
})

