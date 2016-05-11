
Feature: Top tracks for artist

  Scenario: Viewing artist top tracks
    Given I am on "/artist/5441c29d-3602-4898-b1a1-b77fa23b8e50/top"
    Then the response status code should be 200
    Then the "h1" element should contain "Artist Name"
    Then the "h2" element should contain "top tracks"
    Then I should see a "table" element
    Then I should see 5 "tr" elements
    Then I should see 5 "img" elements
    Then I should see a "td" element

