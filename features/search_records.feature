Feature:
    In order to search recrods
    As a user
    I want to have an api end point

    Background:
        Given the following records exist:
        | title            | artist  | releaseDate | price | description                                                             |
        | The Four Seasons | Vivaldi | 2017-05-17  | 24.00 | Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan |
        | La Traviata      | Verdi   | 2019-11-11  | 27.00 | Marina Rebeka, Charles Castronovo, George Petean, Latvian Festival O... |
        | Otello           | Verdi   | 2014-04-12  | 18.75 | Plácido Domingo (Otello), Renée Fleming (Desdemona), James Morris (I... |
        | Motets           | Bach    | 2010-05-01  | 15.50 | Yukari Nonoshita & Aki Matsui (soprano), Damien Guillon (counter-ten... |
        | Don Carlos       | Verdi   | 2013-10-12  | 20.25 | Katia Ricciarelli (Elisabeth), Lucia Valentini Terrani (Eboli), Plác... |

    Scenario: Search all records
        When I request "/records" using HTTP GET
        Then the response code is 200
        And the response body contains JSON:
        """
        [
            {
                "id": 4,
                "title": "Motets",
                "artist": "Bach",
                "description": "Yukari Nonoshita & Aki Matsui (soprano), Damien Guillon (counter-ten...",
                "price": 15.5,
                "releaseDate": "2010-05-01"
            },
            {
                "id": 5,
                "title": "Don Carlos",
                "artist": "Verdi",
                "description": "Katia Ricciarelli (Elisabeth), Lucia Valentini Terrani (Eboli), Plác...",
                "price": 20.25,
                "releaseDate": "2013-10-12"

            },
            {
                "id": 2,
                "title": "La Traviata",
                "artist": "Verdi",
                "description": "Marina Rebeka, Charles Castronovo, George Petean, Latvian Festival O...",
                "price": 27,
                "releaseDate": "2019-11-11"

            },
            {
                "id": 3,
                "title": "Otello",
                "artist": "Verdi",
                "description": "Plácido Domingo (Otello), Renée Fleming (Desdemona), James Morris (I...",
                "price": 18.75,
                "releaseDate": "2014-04-12"
            },
            {
                "id": 1,
                "title": "The Four Seasons",
                "artist": "Vivaldi",
                "description": "Anne-Sophie Mutter (violin)\\nWiener Philharmoniker, Herbert von Karajan",
                "price": 24,
                "releaseDate": "2017-05-17"

            }
        ]
        """

    Scenario: Search records by title
        When I request "/records?title=motets" using HTTP GET
        Then the response code is 200
        """
        [
            {
                "id": 4,
                "title": "Motets",
                "artist": "Bach",
                "description": "Yukari Nonoshita & Aki Matsui (soprano), Damien Guillon (counter-ten...",
                "price": 15.5,
                "releaseDate": "2010-05-01"
            },
        ]
        """
    Scenario: Search records by artist
        When I request "/records?artist=verdi" using HTTP GET
        Then the response code is 200
        """
        [
            {
                "id": 5,
                "title": "Don Carlos",
                "artist": "Verdi",
                "description": "Katia Ricciarelli (Elisabeth), Lucia Valentini Terrani (Eboli), Plác...",
                "price": 20.25,
                "releaseDate": "2013-10-12"

            },
            {
                "id": 2,
                "title": "La Traviata",
                "artist": "Verdi",
                "description": "Marina Rebeka, Charles Castronovo, George Petean, Latvian Festival O...",
                "price": 27,
                "releaseDate": "2019-11-11"

            },
            {
                "id": 3,
                "title": "Otello",
                "artist": "Verdi",
                "description": "Plácido Domingo (Otello), Renée Fleming (Desdemona), James Morris (I...",
                "price": 18.75,
                "releaseDate": "2014-04-12"
            },
        ]
        """

    Scenario: Search records by artist and title
        When I request "/records?artist=verdi&title=Otello" using HTTP GET
        Then the response code is 200
        """
        [
            {
                "id": 5,
                "title": "Don Carlos",
                "artist": "Verdi",
                "description": "Katia Ricciarelli (Elisabeth), Lucia Valentini Terrani (Eboli), Plác...",
                "price": 20.25,
                "releaseDate": "2013-10-12"

            },
            {
                "id": 2,
                "title": "La Traviata",
                "artist": "Verdi",
                "description": "Marina Rebeka, Charles Castronovo, George Petean, Latvian Festival O...",
                "price": 27,
                "releaseDate": "2019-11-11"

            },
            {
                "id": 3,
                "title": "Otello",
                "artist": "Verdi",
                "description": "Plácido Domingo (Otello), Renée Fleming (Desdemona), James Morris (I...",
                "price": 18.75,
                "releaseDate": "2014-04-12"
            },
        ]
        """

    Scenario: Search records for empty result
        When I request "/records?title=NOT_A_TITLE" using HTTP GET
        Then the response code is 200
        """
        []
        """
