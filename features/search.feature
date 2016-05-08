
Feature: Searching by country

  Scenario: Viewing the search page
    Given I am on "/"
    Then the response status code should be 200
    Then the "h1" element should contain "top artists"

  Scenario: Searching a valid country and valid page
    Given I am on "/"
    When I fill in "country" with "australia"
    And I press "Search"
    Then I should see a "table" element
    Then I should see 5 "tr" elements
    Then I should see 5 "img" elements
    Then I should see a "td" element
    And I should see text matching "Australia"
    # TODO: I should see an a-link linking to top tracks
