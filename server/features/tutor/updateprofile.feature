#features/tutor/updateprofile.feature
Feature: Update Tutor Profile
    After I successfully sign up as a tutor. I will be able to update and 
    personalize my profile, select subjects, and review & accept the terms
    and condition.

Scenario: Update profile (personal info)
    Given I have a valid access-token to call the api
        And I have created a tutor account with email "tester@gmail.com"
    When I make a POST to "tutor/{id}/update/profile" with profile data:
        """
           {
            "id": "29",
            "email": "tester@gmail.com",
            "user_type": "1",
            "phone_number": "412-692-0733",
            "gender": "M",
            "dob": "1987-08-08",
            "tutor": {
              "rate": "650.00",
              "education": "Masters",
              "major": "Computer Science",
              "institution": "Babcock Mellon University"
            }
          }
       """
    Then the response should have a "status" field set to "success"
    When I make a GET request to "/v1/tutor/{id}"
        Then the response should contain a "user" object
        And the "user" object should have the correct values for these fields "phone_number,gender,dob" 
        And the child "tutor" object should have the correct values for these fields "rate, education,major,institution"


