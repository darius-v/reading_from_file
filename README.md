# Reading from file

## Requirements
- Docker

## Setup
```bash
make up
```

App runs at `http://localhost:8080`.

## Commands
```bash
make up       # start containers
make down     # stop containers
make restart  # restart containers
make bash     # shell into PHP container
make test     # run test suite
```

## Xdebug (PhpStorm)
Port: `9003`, IDE key: `PHPSTORM`.

**Settings → PHP → Servers → localhost:8080 → Path Mappings:**
```
<absolute-path-to-project-root>  →  /var/www/html
```
Example:
```
/home/darius/PhpstormProjects/reading_from_file  →  /var/www/html
```

