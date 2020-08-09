# Lunch Voting System (LVS)

https://lvs.mitchbarry.com/

Created by Mitchell Barry and Darin Kleb in 2010.

Purpose: Help a rag-tag group of interns decide where to eat lunch on Friday each week. 

Original source with very minor adjustments to run in containers.

https://www.vultr.com/docs/deploy-a-php-application-using-docker-compose

```bash
# pwd: repository root

docker build -t lvs-php php/
docker build -t lvs-nginx nginx/
cd app/
docker-compose up -d

docker ps

# http://localhost:8080/
```

## Notes
- So many SQL injection vulnerabilities!
- Had to update all `mysql` calls to use [PHP Data Objects (PDO)](https://www.php.net/manual/en/book.pdo.php) instead. 
- The _Lunch Voting System_ had some integration with a CMS system hosted on mitchbarry.com - administrators of the _Lunch Voting System_ needed a user created in that system. To self-contain, that user administration has moved to the same mysql database that the application depends on. 
  - Admin User: `admin`
  - Admin Pass: `admin`
  - Fun non-admin User: `user`
  - Fun non-admin Pass: `user`
- Still have not hooked up Cron jobs to refresh restaurant choices.
- Restaurants pulled from database instead of text files would obviously be better.
- Environment variables for all configuration options preferred.
- One-off container building required to run services should be streamlined as well.