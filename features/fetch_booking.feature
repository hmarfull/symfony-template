@booking

Feature:
  In order to prove that the API is able to check the existence of booking on hotel rooms
  As a user
  I want to have the following scenarios

  Scenario: An API user wants the info of a booking on a particular hotel and room
    When a request is sent to "/hotels/70ce8358-600a-4bad-8ee6-acf46e1fb8db/rooms/286/booking"
    Then the response status code should be 200
    And the response content should be exactly:
    """
    {
       "bookingId":"00501cc6-556c-46c4-b4af-eb6598682980",
       "hotel":"70ce8358-600a-4bad-8ee6-acf46e1fb8db",
       "locator":"65BCE6396B6C4",
       "room":"286",
       "checkIn":"2024-02-02",
       "checkOut":"2024-02-14",
       "numberOfNights":12,
       "totalPax":1,
       "guests":[
          {
             "name":"Marco",
             "lastname":"Ram\u00edrez",
             "birthdate":{
                "date":"1964-10-07 19:19:12.000000",
                "timezone_type":3,
                "timezone":"UTC"
             },
             "passport":"FI-1037975-FQ",
             "country":"FI",
             "age":59
          }
       ]
    }
    """
  Scenario: An API user wants the info of a booking on a particular hotel and room but that room has no booking
    When a request is sent to "/hotels/70ce8358-600a-4bad-8ee6-acf46e1fb8db/rooms/286/booking"
    Then the response status code should be 200
    And the response content should be exactly:
    """
    {}
    """