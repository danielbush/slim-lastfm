
Feature: ping

  Test that our service is nominally up.
  This is a bit like a walking skeleton for our app.

  Scenario: pinging the server
    When an http client gets /ping
    Then a pong will be received

  Scenario: pinging the server (mink/browser)
    Given I am on "/ping"
    Then the response status code should be 200
