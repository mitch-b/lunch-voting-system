# Lunch Voting System (LVS)

https://lvs.mitchbarry.com/

Created by Mitchell Barry and Darin Kleb in 2010.

Purpose: Help a rag-tag group of interns decide where to eat lunch on Friday each week. 

Original source with very minor adjustments to run in containers.

https://www.vultr.com/docs/deploy-a-php-application-using-docker-compose

## Running

```bash
# pwd: repository root

docker build -t lvs-php php/
docker build -t lvs-nginx nginx/
docker build -t lvs-cron cron/
cd app/
docker-compose up -d

docker ps

# http://localhost:8080/
```

### Running with Send Mail

Any SMTP service should work, but replace the environment variables in the [`docker-compose.yml`](./app/docker-compose.yml) file with your appropriate settings. Alternatively, to set these variables from the command line, follow this syntax:

```bash
export MAIL_USER=myuser@mydomain.com
export MAIL_PASS=abcdefghijklmnop
docker-compose up -d
```

## Notes
- So many SQL injection vulnerabilities!
- Had to update all `mysql` calls to use [PHP Data Objects (PDO)](https://www.php.net/manual/en/book.pdo.php) instead. 
- The _Lunch Voting System_ had some integration with a CMS system hosted on mitchbarry.com - administrators of the _Lunch Voting System_ needed a user created in that system. To self-contain, that user administration has moved to the same mysql database that the application depends on. 
  - Admin User: `admin`
  - Admin Pass: `admin`
  - Fun non-admin User: `user`
  - Fun non-admin Pass: `user`
- I had issues with `/start.php` not writing the `index.php` file out. This impacts cron job not writing new `index.php` as well, of course.
  ```bash
  # security be damned
  chmod 777 ./app/index.php
  chmod 777 ./app/lastweek.php
  chmod 777 ./app/restaurant.pl
  ```
- Cron container runs schedule on **Fridays**:
  - Sets up index page at **7AM** with fresh **voting options**
  - Sends **reminder email** to all registered users at **8AM**
  - Sends **vote results** at **11AM**
  - Resets the index page at **2PM** to indicate voting is over and to **wait until next week**.

## To Do
- Update cronjob to appropriate scripts/timings
- Restaurants pulled from database instead of text files would obviously be better.
- Environment variables for all configuration options preferred.
- One-off container building required to run services should be streamlined as well.
- Update to mailgun sendmail

## Debugging

To get into mysql container host to run `mysql` tool and poke around, you'll need to get the container id. 

```bash
docker ps
# assume b7a9f5eb6b85 is the CONTAINER_ID of the lvs-data instance
docker exec -it b7a sh
```

## Schema

View [00-init.sql](./app/sql/00-init.sql) to see database schema. 

To populate your own test data, update [01-seed.sql](./app/sql/01-seed.sql).