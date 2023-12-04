/// <reference types="cypress" />

const userRoles = [
    {
        'userRole': 'admin',
        'isAllowed': true,
    },
    {
        'userRole': 'editor',
        'isAllowed': false,
    },
    {
        'userRole': 'subscriber',
        'isAllowed': false,
    },
    {
        'userRole': 'contributor',
        'isAllowed': false,
    },
    {
        'userRole': 'author',
        'isAllowed': false,
    },
]

describe('non admin users should not be able to access release notes post type', () => {

    userRoles.forEach((role) => {

        describe(`${role.userRole} access`, () => {
            beforeEach(() => {
                cy.switchUser(role.userRole);
                cy.visit('/admin/');
            })

            const roleLabel = role?.userRole ? role.userRole : role.userRole;
            const assertion = role?.isAllowed ? 'exist' : 'not.exist';
            const assertionLabel = role?.isAllowed ? 'shold' : 'should not';
            
        
            it(`${roleLabel} ${assertionLabel} be able to create release notes`, () => {
                cy.get('#menu-posts-release-note > .wp-has-submenu > .wp-menu-name').should(assertion);
                cy.get('#toplevel_page_release-notes > .wp-not-current-submenu > .wp-menu-name').should('exist');
            })
        })
    })

})