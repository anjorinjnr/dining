#features/tutor/signup.feature
Feature: tutor sign up
    In order to sign up as a tutor on the web app, I need to complete the form
    on the tutor sign up page at /tutor/signup.

Scenario: Successful tutor sign-up
    Given I have a valid access-token to call the api
    When I make a POST to "/user" with:
     """
        {
          "user_type": 1,
          "firstname": "Donald",
          "lastname": "Lawrence",
          "email": "tester@gmail.com",
          "state_id": 4,
          "town_id": 8,
          "area_id": 1135,
          "password": "123.com",
          "confirm_password": "123.com",
          "terms_agreed": true
        }
     """
    Then the response should have a "status" field set to "success"
    And the response should contain a "user" object
    And the "user" object should have a valid "id"

