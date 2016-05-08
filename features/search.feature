
Feature: Searching by country

  Scenario: Viewing the search page
    Given I am on "/"
    Then the response status code should be 200
    Then the "h1" element should contain "top artists"

  Scenario: Searching a valid country
    Given I am on "/"
    When I fill in "country" with "australia"
    And I press "Search"
    Then I should see a "table" element
