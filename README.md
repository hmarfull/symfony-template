# Stay's coding test

## General Description

I developed this code using DDD (Hexagonal Architecture, Value Object Pattern, Repository Pattern, etc.) and Command Query Responsibility Segregation (CQRS) trying to keep the code as simple as possible. It may be a bit over-engineered but, it was developed keeping in mind that this would be a bigger and more complex project, and it is test where I should show my knowledge as much as I can.


## How to test
1. You need to install [Docker](https://docs.docker.com/get-docker/)
   and [Docker Compose](https://docs.docker.com/compose/install/) on your machine.
2. Start the Docket containers.
    ```bash
    make start
    ```
3. Execute the command to run the unit tests.
   ```bash
    make unit
    ```
4. Send Order 1
   ```bash
   curl --location 'http://localhost:39000/discount' \
   --header 'Content-Type: application/json' \
   --data '{
   "id": "1",
   "customer-id": "1",
   "items": [
   {
   "product-id": "B102",
   "quantity": "10",
   "unit-price": "4.99",
   "total": "49.90"
   }
   ],
   "total": "49.90"
   }'
    ```
5. Send Order 2
   ```bash
   curl --location 'http://localhost:39000/discount' \
   --header 'Content-Type: application/json' \
   --data '{
   "id": "2",
   "customer-id": "2",
   "items": [
   {
   "product-id": "B102",
   "quantity": "5",
   "unit-price": "4.99",
   "total": "24.95"
   }
   ],
   "total": "24.95"
   }'
    ```
6. Send Order 2
   ```bash
   curl --location 'http://localhost:39000/discount' \
   --header 'Content-Type: application/json' \
   --data '{
   "id": "3",
   "customer-id": "3",
   "items": [
   {
   "product-id": "A101",
   "quantity": "2",
   "unit-price": "9.75",
   "total": "19.50"
   },
   {
   "product-id": "A102",
   "quantity": "1",
   "unit-price": "49.50",
   "total": "49.50"
   }
   ],
   "total": "69.00"
   }'
    ```


## Possible Improvements

### Add a json validator to validate the request parameters
Add a JSON validator to make sure the format and type of the body and it's attributes is correct. 

### Fix the case "a sixth unit free when buying five"
I was not sure how to create a clean response without modifying and returning a new Order JSON with the updated 
quantities. I could have returned de monetary discount and an array with the updated quantities but doesn't feel right.
So since I have no chance to talk with product I took a similar approach and every six units you buy, one of them is 
for free, that way response of the Discount Service would be just a discount value in any case. But I'm aware that is 
not exactly what it was described on the exercise. 

### Create value objects for every attribute
Having a deeper knowledge of the product definition of each attribute, I would create VO for each attribute and 
encapsulate any business logic related to them. I used a VO Category on the category attribute of the Product class 
because it was a pretty clear case of use. 

### Library or initial boilerplate for VOs and utilities like Collection class
To make the development easier would have been nice to have some initial boilerplate with common VOs and classes with
pre-implemented functions like Collection (with functions like first, all, filter, get, etc.).

### Improve Unit tests
It would be needed to improve the unit tests to have more resilient tests and avoid "happy scenarios". I would do it by
adding DataProviders and Random Stub/MotherObjects for the tests and add more scenarios like the
Customer/ProductNotFound. And make them cleaner and easier to read using dedicated TestCases instead the default one,
with methods like "this->getProductByIdAndThrowException($productId, ProductNotFound::class)".

### Maybe it would be necessary to validate the category and customer identifiers
Since we want this to be a standalone (micro)service to avoid being dependant of other segments of the application 
related to Categories and Customers it will accept any identifiers and only react to the ones it has information for.
If there is the need to validate those I would do it.

### Catching or throwing NotFound exceptions
Depending on the use cases and the race condition times on the sync we could decide if catching the exception and
continue or returning an error. For example if a user has just been created and is not synced yet, it doesn't matter 
that we don't find it since the total income would be zero (all this in case we trust the data sen to our service, for 
example if it's for internal use only).

### Add Domain events, if needed, depending on the business logic
I didn't use DomainEvents, since there is no data persistence and there is nothing on the exercise description that 
makes me think they are needed.

### Improve the strategy for the discount application
If we think that the conditions for the discounts will get very complex, will be repeated among different cases or
change often, we should use a more complex approach. We will create some boilerplate, but we'll be more scalable and 
maintainable. For example, creating an Interface DiscountType with the logic and dependencies. And create the different 
discount types implementing this interface and adapt the Order::applyDiscount() to receive that interface. This way we 
will be using a clear "Tell, Don't Ask" keeping the logic related with the order inside the Order class. 