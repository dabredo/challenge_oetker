Feature:
    In order to delete a record
    As a admin
    I want to have a secure api end point

    Background:
        Given the following records exist:
        | title            | artist  | releaseDate | price | description                                                             |
        | The Four Seasons | Vivaldi | 2017-05-17  | 24.00 | Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan |

    Scenario: Delete a record successfully
        Given the request body is:
        """
        {}
        """
        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/1" using HTTP DELETE
        Then the response code is 204

    Scenario: Delete a record without api key
        Given the request body is:
        """
        {}
        """
        And the "Content-Type" request header is "application/json"
        When I request "/records/1" using HTTP DELETE
        Then the response code is 401
        And the response body contains JSON:
        """
        {
             "error": "Unauthorized"
        }
        """

    Scenario: Delete a record which does not exist
        Given the request body is:
        """
        {}
        """
        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/NOT_A_RECORD" using HTTP DELETE
        Then the response code is 404
        And the response body contains JSON:
        """
        {
             "error": "Not Found"
        }
        """
