# Stay's coding test

## General Description

I developed this code using Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) principles trying the code as simple as possible.

## Possible Improvements

### Go towards Event Driven.
This would help, for example, to avoid storing the new bookings on a synchronous way and maybe reaching a bottleneck we could just send events with the new bookings and have some workers subscribed to process those events and actually persist the data. 

### Cacheable Queries
To reduce the DB access and increase performance we could add a redis cache to store queries for particular rooms till there is a change, at which point we would clear the cache, or just with a TTL.

### Add Transactional Middleware to the command bus
While doing this test I learn about the possibility to add a transactional middleware to the command bus. I would need to research more about it but it could be interesting to avoid commands executing partially in case of unexpected failure.

### Value Objects
Use VOs on every attribute on the Aggregate. For example on the Passport one we could check if it has a valid format and the country code could be an Eum VO to make sure it has valid values.

### Extra modules
On a real case I would implement two extra modules, one for the Guests to allow multiple guests per booking and one for one the Hotels to have this int/ext ID mapping and maybe extra information (even though the mapping I would probably have it loaded in redis too or something like that to improve performance)