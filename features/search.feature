
Feature: Searching by country

  Scenario: Viewing the search page
    Given I am on "/"
    Then the response status code should be 200
    Then the "h1" element should contain "search by country"
