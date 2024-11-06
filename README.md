# YumiBung&copy; Venue booking software;

The YumiBung&copy venue booking software is a containerized end-to-end web application that servers a few purposes
- Venue booking:
  - User login
- Venue booking payment
## Important Note
This document exists to provide technical guidance to the developers of this application.

## Licence & Copyright
This software application remains the sole property of the &copy;[Ark Cyber Security Consultants](https://www.arkcybersecurityconsultants.com).
Any unauthorized duplication of this appqlication for personal, malicious or monetary intent is considered a crime, and punishable by law.

## Installation on Local environment
### Steps
1. Update the `DB_*` environment variables in the `.env` file in your project root:
`Note:` _These environment variables will be used by docker-compose in the next step to build your database._
```
DB_CONNECTION=yumibung
DB_HOST=db
DB_PORT=3306
DB_DATABASE=yumibung
DB_USERNAME=yumibung
DB_PASSWORD=yumibung
DB_ROOT_PASSWORD=root
``` 
2. Spin up containers
```bash
$ docker-compose up -d --build // build the project containers. Note: In Dev, run once or everytime the containers need to be respawned.
```
3. Install / Publish node modules and set `watch` to monitor code updates.
```bash
$ make npm-devup
```
4. Run the DB migrations & seed the database with test data
```bash
$ make fresh
```
5. If you experience any database related errors, then run the following db rollback command, and repeat step 4.
```bash
$ make rollback-test
```
6. Login with the test user credentials.
```bash
E: test@yumibung.com
P: abcd1234
````
7. Begin building!

For more info, please email _JohnMoiga_ at jw.moiga@gmail.com

Team DICT&copy; 2024
