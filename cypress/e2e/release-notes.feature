Feature: Release Notes Creation

Background: Administrator user is on release notes
    Given the Administrator is on the release notes page

Scenario: Publishing a New Release by an Administrator
Given an Administrator creates a new release note with provided updates
When they proceed to publish the created note
Then they should see indications of a successful publication of the release note