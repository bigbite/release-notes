Feature: Release notes page

Scenario: viewing the release notes page when no release notes exist
  Given the user visits the release notes page
  Then the placeholder message is visible

Scenario: viewing published release notes on the release notes page
  Given some release notes are published
  When the user visits the release notes page
  Then the latest release notes should be visible
