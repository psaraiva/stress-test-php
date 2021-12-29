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
- **Request API - Sequential**: `docker exec -it stress-test-app php app/api/sequential.php`
- **Request API - Sequential (http-client)**: `docker exec -it stress-test-app php app/api/sequential.php`
- **Request API - Parallel**: `docker exec -it stress-test-app php app/api/parallel.php`
- **Create Image - Sequential**: `docker exec -it stress-test-app php app/image/sequencial.php`
- **Create Image - Parallel**: `docker exec -it stress-test-app php app/image/parallel.php`

## Monitoring processes
- **Htop**: `docker exec -it stress-test-app htop`

## Catch IP PlayLumenDice:
To send request to API, get de IP docker and update files.

- `docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' play-lumen-dice-webserver`

[note](https://gist.github.com/psaraiva/51467d6a49a46709e4c46006ee6015c1#exibe-o-ip-de-um-container)

## Using same networks:
In `docker-compose.yml` is ref `networks` to `playlumendice_app-network`, confirm this info with docker network command:

- `docker network ls`;

[note](https://gist.github.com/psaraiva/51467d6a49a46709e4c46006ee6015c1#network)

# output
- Request API Sequential
```
Request: 50 
{"dice":[1]}
Request 50 total execution time in seconds: 1.110000.
Script total execution time in seconds: 126.000000.
Script memory usage: 2 Mb.
```
- Request API Parallel
```
Request 42 total execution time in seconds: 14.080000.
{"dice":[6]}
Request 50 total execution time in seconds: 10.300000.
Script total execution time in seconds: 28.040000.
Script memory usage: 4 Mb.
```
- Image Sequential
```
Image: 50 
Image 50 total execution time in seconds: 0.990000.
Script total execution time in seconds: 45.810000.
Script memory usage: 2 Mb.
```
- Image Parallel
```
Image 37 total execution time in seconds: 4.510000.
Script total execution time in seconds: 57.150000.
Script memory usage: 4 Mb.
```
