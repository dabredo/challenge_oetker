Feature:
    In order to update a record
    As a admin
    I want to have a secure api end point

    Background:
        Given the following records exist:
        | title            | artist  | releaseDate | price | description                                                             |
        | The Four Seasons | Vivaldi | 2017-05-17  | 24.00 | Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan |

    Scenario: Update a record successfully
        Given the request body is:
        """
        {
            "title": "The Four Seasons",
            "artist": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 10.00
        }
        """
        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/1" using HTTP PUT
        Then the response code is 204

    Scenario: Update a record without api key
        Given the request body is:
        """
        {
            "title": "The Four Seasons",
            "artist": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 24.00
        }
        """
        And the "Content-Type" request header is "application/json"
        When I request "/records/1" using HTTP PUT
        Then the response code is 401
        And the response body contains JSON:
        """
        {
             "error": "Unauthorized"
        }
        """

    Scenario: Update a record which does not exist
        Given the request body is:
        """
        {
            "title": "The Four Seasons",
            "artist": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 24.00
        }
        """
        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/NOT_A_RECORD" using HTTP PUT
        Then the response code is 404
        And the response body contains JSON:
        """
        {
             "error": "Not Found"
        }
        """

    Scenario: Update a record bad request missing title
        Given the request body is:
        """
        {
            "artist": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 24.00
        }
        """

        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/1" using HTTP PUT
        Then the response code is 400
        And the response body contains JSON:
        """
        {
            "errors": [
                {
                    "title": "title",
                    "message": "This value should not be blank."
                }
            ]
        }
        """

    Scenario: Update a record bad request multiple errors
        Given the request body is:
        """
        {
            "title": "",
            "artist": "",
            "releaseDate": "NOT_A_DATE",
            "description": "",
            "price": "NOT_A_PRICE"
        }
        """
        And the "Content-Type" request header is "application/json"
        And the "api-key" request header is "12345"
        When I request "/records/1" using HTTP PUT
        Then the response code is 400
        And the response body contains JSON:
        """
        {
            "errors": [
                {
                    "title": "title",
                    "message": "This value should not be blank."
                },
                {
                    "title": "artist",
                    "message": "This value should not be blank."
                },
                {
                    "title": "price",
                    "message": "This value should be positive."
                },
                {
                    "title": "releaseDate",
                    "message": "This value is not a valid date."
                }
            ]
        }
        """
