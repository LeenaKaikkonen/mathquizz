docker exec mysql sh -c 'exec mysqldump --all-databases -uroot -psecret123' > backup/all-databases.sql
