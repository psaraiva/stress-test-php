# Stress Test PHP?
Laboratory: Using lib [amphp](https://github.com/amphp).

# Objective:
Use the library in real context, with [PlayLumenDice](https://github.com/psaraiva/PlayLumenDice).

# Getting Started
## Install by Docker:
- `docker-compose up --build -d`
- `docker exec -it stress-test-app composer install` (Optional: `--no-dev`)
- `docker exec -it stress-test-app composer dump-autoload --optimize`

## Excecute files:
- **Sequential**: `docker exec -it stress-test-app php app/sequential.php` (linear)
- **Wait**: `docker exec -it stress-test-app php app/wait.php` (parallel)
- **Sequential-http-client**: `docker exec -it stress-test-app php app/sequential-http-client` (linear)

## Catch IP PlayLumenDice:
To send request to API, get de IP docker and update files.

- `docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' play-lumen-dice-webserver`

[note](https://gist.github.com/psaraiva/51467d6a49a46709e4c46006ee6015c1#exibe-o-ip-de-um-container)

## Using same networks:
In `docker-compose.yml` is ref `networks` to `playlumendice_app-network`, confirm this info with docker network command:

- `docker network ls`;

[note](https://gist.github.com/psaraiva/51467d6a49a46709e4c46006ee6015c1#network)

# output
- Linear
```
Request: 50 
{"dice":[3]}
Request 50 total execution time in seconds: 1.130000.
Script total execution time in seconds: 120.910000.
```
- Parallel
```
Request 43 total execution time in seconds: 14.470000.
{"dice":[5]}
Request 47 total execution time in seconds: 14.710000.
Script total execution time in seconds: 28.530000.
```
