/// <reference types="cypress" />

describe('release note page template', () => {
    beforeEach(() => {
        cy.visit("/wp-admin/edit.php?post_type=release-note");
    });

    it('should have the correct page template when a release note is created', () => {
        cy.get(".page-title-action").contains("Add New").click();

        cy.get("h1").should("have.attr", "placeholder", "Add title");
    });
});