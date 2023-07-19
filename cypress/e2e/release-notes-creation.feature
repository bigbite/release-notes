Feature: Release Notes Creation

Scenario: Publishing a New Release by an Administrator
    Given an Administrator creates a new release note with provided updates
    When they proceed to publish the created note
    Then they should see indications of a successful publication
