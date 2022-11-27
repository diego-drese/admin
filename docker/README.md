# docker-alpine
Docket alpine with php

### With docker command line
Make the image

    docker build -t aerd ./

Run container

    docker run -d --name aerd --network local-network -p 3007:80 -v "/PATH_PROJECT:/usr/share/nginx/html" aerd
 

### With docker compose
Make the image

    docker-compose -f docker-compose.yml build 

This command will generate images to execute containers

    docker-compose -f docker-compose.yml up -d


After to access the container make:

    docker container exec -ti aerd /bin/bash
