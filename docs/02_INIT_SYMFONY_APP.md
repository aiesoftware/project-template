### Create the project

```shell
> cd applications
> composer create-project symfony/website-skeleton symfony
> cp -r symfony-docker-template/ symfony/
> rm -rf symfony-docker-template
> cd symfony
```
##### Pull in the domain library:
```json
"require": {
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
> docker-compose run --rm -v $(pwd):/var/www app composer update
```

##### Start the services
```shell
> docker-compose up --build
```


