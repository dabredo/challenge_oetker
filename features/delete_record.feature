Feature:
    In order to delete a record
    As a user
    I want to have an api end point

    Scenario: Delete a record successfully
        Given the request body is:
        """
        {}
        """
        Given the "Content-Type" request header is "application/json"
        When I request "/records/55" using HTTP DELETE
        Then the response code is 204

    Scenario: Delete a record which does not exist
        Given the request body is:
        """
        {}
        """
        Given the "Content-Type" request header is "application/json"
        When I request "/records/NOT_A_RECORD" using HTTP DELETE
        Then the response code is 404
        And the response body contains JSON:
        """
        {
             "error": "Not Found"
        }
        """
