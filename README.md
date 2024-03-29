# Stay's coding test

## General Description

I developed this code using DDD (Hexagonal Architecture, Value Object Pattern, Repository Pattern, etc.) and Command Query Responsibility Segregation (CQRS) trying to keep the code as simple as possible. It may be a bit over-engineered but, it was developed keeping in mind that this would be a bigger and more complex project, and it is test where I should show my knowledge as much as I can.


## How to test
1. You need to install [Docker](https://docs.docker.com/get-docker/)
   and [Docker Compose](https://docs.docker.com/compose/install/) on your machine.
2. Start the Docket containers and initialize the DB.
    ```bash
    $ make setup
    ```
3. Execute the command to retrieve and store the bookings since '2024-02-02 00:00:00' on the database.
   ```bash
    $ make collect-bookings
    ```
4. [Get bookings from a particular hotel room](http://localhost:39000/hotels/70ce8358-600a-4bad-8ee6-acf46e1fb8db/rooms/286/booking)
5. [Get bookings from a particular hotel room with no bookings](http://localhost:39000/hotels/70ce8358-600a-4bad-8ee6-acf46e1fb999/rooms/999/booking)

## Possible Improvements

### Add BookingCreatedEvent
I would add a static method "create" that would return an instance with a Domain event BookingCreated. I would pull this Domain Events before calling the "storeMultiple" on the BookingPopulator service (So it doesn't affect the unit testing assertions) and I would publish them right after to make sure they were persisted.

### Go towards Event Driven
This would help, for example, to avoid storing the new bookings on a synchronous way and maybe reaching a bottleneck we could just send events with the new bookings and have some workers subscribed to process those events and actually persist the data. 

### Cacheable Queries
To reduce the DB access and increase performance we could add a redis cache to store queries for particular rooms till there is a change, at which point we would clear the cache, or just with a TTL.

### Add Transactional Middleware to the command bus
While doing this test I learn about the possibility to add a transactional middleware to the command bus. I would need to research more about it, but it could be interesting to avoid commands executing partially in case of unexpected failure.

### Value Objects
Use VOs on every attribute on the Aggregate. For example on the Passport one we could check if it has a valid format and the country code could be an Eum VO to make sure it has valid values.

### Extra modules
On a real case I would implement two extra modules, one for the Guests to allow multiple guests per booking and one for one the Hotels to have this int/ext ID mapping and maybe extra information (even though the mapping I would probably have it loaded in redis too or something like that to improve performance).

### Improve the data recollection from the PMS
I would need to check that the data corresponds with the required formats and the required fields are present. Also, I have a static mapping for the INT/EXT hotel IDs and that should be improved as mentioned before.

### Use Criteria Pattern for the search in the repository
In case that different search queries based on different params would be performed on this repository it would be best to use the Criteria Pattern.

### Improve Booking Storage by checking duplicates
I should check if the Bookings are already stored and if so don't duplicate them.

### Create a cron to execute the command to collect the bookings
Create a cron to collect the bookings as often as needed.

### Map exceptions on the controller
Once the code gets more complex I would map the Exceptions to the corresponding HTTP Response Codes. 

### Create real behat tests
Some of the steps defined on the context are mocked.