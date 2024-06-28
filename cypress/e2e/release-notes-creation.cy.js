/// <reference types="cypress" />

describe('Administrator can create and publish release notes', () => {
    beforeEach(() => {
        cy.intercept({ method: 'POST', url: `/wp-json/wp/v2/release-note/*` }).as('releasePublished');
        cy.visit("/wp-admin/edit.php?post_type=release-note");
    });

    it('should allow an administrator to create and publish a new release note', () => {
        const versionNumber = '1.0.0';

        cy.get(".page-title-action").contains("Add New").click();

        cy.get(".wp-block-post-title").click().type(`Release Notes - V${versionNumber}`);

        cy.get(".is-root-container").within(() => {
            cy.get("p.wp-block-paragraph").type("Overview text");
            cy.get("ul").as("listBlock");
            cy.get("@listBlock").eq(0).within(() => {
                cy.get("li").eq(0).type("list item #1{enter}");
                cy.get("li").eq(1).type("list item #2");
            });
            cy.get("@listBlock").eq(1).within(() => {
                cy.get("li").eq(0).type("list item #1{enter}");
                cy.get("li").eq(1).type("list item #2");
            });
            cy.get("@listBlock").eq(2).within(() => {
                cy.get("li").eq(0).type("list item #1{enter}");
                cy.get("li").eq(1).type("list item #2");
            });
        });

        cy.contains("button", "Release Note").click();

        cy.contains("button", "Release Info").click();

        cy.get(".components-input-control__container").type(`${versionNumber}`);

        cy.contains("button", "Publish").click();

        cy.get(".editor-post-publish-panel__header").within(() => {
            cy.contains("button", "Publish").click();
        });

        cy.saveCurrentPost();

        cy.wait("@releasePublished").its("response.statusCode").should("eq", 200);

        cy.visit("wp-admin/admin.php?page=release-notes");

        cy.get(".menupop.release-note").should("contain", `${versionNumber}`);

        cy.get(".release-note-version").should("contain", `${versionNumber}`);
    });
});
