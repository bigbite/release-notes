import { Given } from "@badeball/cypress-cucumber-preprocessor";

Given("the Administrator is on the release notes page", () => {
    cy.visit("/wp-admin/edit.php?post_type=release-note")
})

Given("an Administrator creates a new release note with provided updates", () => {
    cy.get(".page-title-action").contains("Add New").click()
    cy.get(".wp-block-post-title").click().type("hello world")
    cy.get(".is-root-container").within(() => {
        cy.get("p.wp-block-paragraph").type("Overview text")
        cy.get("ul").eq(0).within(() => {
            cy.get("li").eq(0).type("list item #1{enter}")
            cy.get("li").eq(1).type("list item #2")
        })
        cy.get("ul").eq(1).within(() => {
            cy.get("li").eq(0).type("list item #1{enter}")
            cy.get("li").eq(1).type("list item #2")
        })
        cy.get("ul").eq(2).within(() => {
            cy.get("li").eq(0).type("list item #1{enter}")
            cy.get("li").eq(1).type("list item #2")
        })
    })
    cy.contains("button", "Release Note").click()
    cy.contains("button", "Release Info").click()
    cy.get(".components-input-control__container").type("1.0.0")
})

// When("they proceed to publish the created note", () => {

// })

// Then("they should see confirmirmation of a successful publication of the release note", () => {

// })

