### Create the project

```
> cd applications
> composer create-project symfony/website-skeleton symfony-app
> cp -r symfony-docker-template/ symfony-app/
> rm -rf symfony-docker-template
> cd symfony-app
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
> docker-compose run --rm -v $(pwd):/var/www app composer update
```

##### Start the services
```shell
> docker-compose up --build
```


