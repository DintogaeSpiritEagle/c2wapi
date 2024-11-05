# C2Wapi&copy; Cradle To The Web API - Training Web App

The C2Wapicopy Training Web App is a containerized end-to-end web application designed to spread the love for DevSecOps.
This application is a copied from the [Yumibung](https://github.com/DintogaeSpiritEagle/yumibung) platform, and will be customized for the purpose of teaching students about DevSecOps.

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
DB_CONNECTION=c2wapi
DB_HOST=db
DB_PORT=3306
DB_DATABASE=c2wapi
DB_USERNAME=c2wapi
DB_PASSWORD=c2wapi
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
E: test@c2wapi.com
P: abcd1234
````
7. Begin building!

For more info, please email _FreddyYoung_ at fmyoung96@gmail.com

Team DICT&copy;2024
