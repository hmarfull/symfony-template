@bookings

Feature:
  In order to prove that the API is able to check the existence of booking on hotel rooms
  As a user
  I want to have the following scenarios

  Scenario: It receives a response from Symfony's kernel
    When a demo scenario sends a request to "/hotels/70ce8358-600a-4bad-8ee6-acf46e1fb8db/rooms/286/booking"
    Then the response should be received