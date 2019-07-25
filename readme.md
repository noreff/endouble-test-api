# Endouble Test API

API that based on a predetermined sets of fixed requests returns the correct responses.

# Requirements

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Composer

# Installation instructions

Clone or download project from git

`git clone https://github.com/noreff/endouble-test-api.git`

Change directory to project directory

`cd endouble-test-api`

**Now you have 2 options:**

**Run app inside Docker container** **(Recomended)**

`docker-compose up -d`

Install dependencies

`docker exec -it testapi_php composer install`

Go to http://localhost:8081 in your browser.

___

**Install dependencies using composer and run php built in server**

Install dependencies 

`composer install`

Launch the server

`php -S localhost:8000 -t public`

Go to http://localhost:8000 in your browser.



# Usage

Your port may be different depending of which way of running server you choose. It It should be 8081 for docker and 8000 for php server.

Endpoint url to get the data is http://localhost:8081/data
You need to specify request parameters in a get string. Year and limit parameters are optional, both requires positive Integer.


**Example request**

http://localhost:8081/api?sourceId=space&year=2013&limit=10

**Example response**

```
{
    "meta": {
        "request": {
            "sourceId": "space",
            "limit": "2",
            "year": "2013"
        },
        "timestamp": "2019-07-24T23:58:08.000Z"
     },
     "data": [
         {
            "number": 10,
            "date": "2013-03-01",
            "name": "CRS-2",
            "link": "https://en.wikipedia.org/wiki/SpaceX_CRS-2",
            "details": "Last launch of the original Falcon 9 v1.0 launch vehicle"
         },
         {
            "number": 11,
            "date": "2013-09-29",
            "name": "CASSIOPE",
            "link": "http://www.parabolicarc.com/2013/09/29/falcon-9-launch-payloads-orbit-vandenberg/",
            "details": "Commercial mission and first Falcon 9 v1.1 flight, with improved 13-tonne to LEO capacity. Following second-stage separation from the first stage, an attempt was made to perform an ocean touchdown test of the discarded booster vehicle. The test provided good test data on the experiment-its primary objective-but as the booster neared the ocean, aerodynamic forces caused an uncontrollable roll. The center engine, depleted of fuel by centrifugal force, shut down resulting in the impact and destruction of the vehicle."
         }
     ]
 }
 ```
 
 # Extension
 
New connectors can be added to `app/Connectors` and should be named like `sourceIdConnector`. Each of them should implement ```public static method fetch(array $params)``` where ```$params``` should contain request parameters such as *sourceId*, *year*, *limit* and more if needed.

# Notes and explanations

To get data from XKCD API for given year I first found a id of any comics having given year using recursive function, which is in a nutshell is a half-interval search. Than I grab another comicses just by checking neibourth up and down. I'm also using prepend and push to keep correct sort order of notes. That's also results in `O(log n)` performance.‎

# Tests

Test located inside `tests` directory. To run them use this command `vendor/bin/phpunit`

