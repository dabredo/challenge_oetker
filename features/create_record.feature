Feature:
    In order to create a record
    As a user
    I want to have an api end point

    Scenario: Create a record successfully
        Given the request body is:
        """
        {
            "title": "The Four Seasons",
            "author": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 24.00
        }
        """
        And the "Content-Type" request header is "application/json"
        When I request "/records" using HTTP POST
        Then the response code is 201
        And the response body is an empty JSON object

    Scenario: Create a record bad request missing title
        Given the request body is:
        """
        {
            "author": "Vivaldi",
            "releaseDate": "2017-05-17",
            "description": "Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan",
            "price": 24.00
        }
        """

        And the "Content-Type" request header is "application/json"
        When I request "/records" using HTTP POST
        Then the response code is 400
        Then the response body contains JSON:
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

    Scenario: Create a record bad request multiple errors
        Given the request body is:
        """
        {
            "title": "",
            "author": "",
            "releaseDate": "NOT_A_DATE",
            "description": "",
            "price": "NOT_A_PRICE"
        }
        """
        And the "Content-Type" request header is "application/json"
        When I request "/records" using HTTP POST
        Then the response code is 400
        Then the response body contains JSON:
        """
        {
            "errors": [
                {
                    "title": "title",
                    "message": "This value should not be blank."
                },
                {
                    "title": "author",
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
