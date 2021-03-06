
Feature: Searching by country

  Scenario: Viewing the search page
    Given I am on "/"
    Then the response status code should be 200
    Then the "h1" element should contain "top artists"

  Scenario: Searching a valid country and valid page
    Given I am on "/"
    When I fill in "country" with "australia"
    And I press "Search"
    Then the url should match "/country"
    Then I should see a "table" element
    Then I should see 5 "tr" elements
    Then I should see 5 "img" elements
    Then I should see a "td" element
    And I should see text matching "Australia"
    And I should see links with href matching "#/artist/[a-f0-9-]+/top#i" for each name
    And I should see country pagination links

  Scenario: Searching an invalid country and valid page
    Given I am on "/"
    When I fill in "country" with "bad-country-name"
    And I press "Search"
    And I should see text matching "couldn't get a result"
