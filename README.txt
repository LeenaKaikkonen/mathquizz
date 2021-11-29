mysql -h 127.0.0.1 -D quizz -u php_user -p

generate HASH password:
https://phppasswordhash.com/

restart containers after code change:
docker-compose stop php && docker-compose build php && docker-compose up -d php
