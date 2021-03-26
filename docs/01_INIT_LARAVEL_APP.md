### Create the Laravel app:

Create the project, then eject the Dockerfiles:

```shell
> cd applications
> curl -s "https://laravel.build/laravel" | bash
> cd laravel
> ./vendor/bin/sail up -d
> ./vendor/bin/sail artisan sail:publish
> ./vendor/bin/sail down
```

##### Pull in the domain library:
```json
require: {
  ...
  "test-project/domain": "*"
},
"repositories": [
  {
    "type": "path",
    "url": "../../library/domain"
  }
]
```

```shell
> composer update
```

##### Setup Docker with xDebug:

Add the XDEBUG arg to `laravel.test` container in the already existing `docker-compose.yml`:

```yaml
laravel.test:
    build:
        context: ./docker/8.0
        dockerfile: Dockerfile
        args:
            # ...
            XDEBUG: '${APP_DEBUG}'
```

Update the docker/8.0/Dockerfile to install xdebug when flag is set.

**IMPORTANT**

- Copy and paste from this raw MD file, not the rendered version, as the rendered versions puts a backslash in front of dollar signs
- The `RUN if [ ${XDEBUG} ] ; then ... fi;` block MUST be inserted between the last PHP package install and the composer install. Examine this file carefully

```dockerfile
FROM ubuntu:20.04
# ...
ARG XDEBUG

# ...

       php8.0-intl php8.0-readline \
       php8.0-msgpack php8.0-igbinary php8.0-ldap \
       php8.0-redis
       
RUN if [ ${XDEBUG} ] ; then \
    apt-get install -y php-xdebug \
    && echo "[XDebug]" > /etc/php/8.0/cli/php.ini \
    && echo "zend_extension="$(find /usr/lib/php/20200930/ -name xdebug.so)" > /etc/php/8.0/cli/php.ini" \
    && echo "xdebug.mode=debug" >> /etc/php/8.0/cli/php.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /etc/php/8.0/cli/php.ini \
    && echo "xdebug.client_host=docker.for.mac.localhost" >> /etc/php/8.0/cli/php.ini \
    && echo "xdebug.client_port=9001" >> /etc/php/8.0/cli/php.ini \
    && echo "xdebug.start_with_request=yes" >> /etc/php/8.0/cli/php.ini \
    && echo "xdebug.discover_client_host=true" >> /etc/php/8.0/cli/php.ini ;\
fi;

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_15.x | bash - \
    && apt-get install -y nodejs \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
```

Rebuild the container:
```shell
> ./vendor/bin/sail build --no-cache
> ./vendor/bin/sail up
```

Access on `http://localhost`
