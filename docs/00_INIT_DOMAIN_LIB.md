##### Project setup

Update the `"name"` value in `composer.json` to reflect the name of the project. Most likely the same name as the project's root folder and the project's repo name.

Also update the `"description"` for good measure.

##### Build image

We need a container to run composer in.

We don’t want to use the official composer image because that doesn’t have the intl library, so it may also not have others.

So we will build our own image that will have that library, and also allow us to add others if needed. We’ll copy composer executable into this image.

And, we might as well use this image to run our tests suites inside.

And given that all interaction with pure domain libraries is to run tests against them, this image is effectively the main, and only, image for the library.

```
> docker build -t <library-name>:latest .
```

Now we can install our dependencies.

For first time set up, we won’t have a composer.lock, so composer will do an initial install with fresh versions.

But notice that we will volume mount when we run composer install, so when composer writes the composer.lock and vendor folder on the container, it will reflect back to the host directory.

At that point, we commit the composer.lock file, and all other runs of composer will use that file.

```
> docker run --rm -v $(pwd):/app <library-name>:latest composer install --ignore-platform-reqs
```

We should now have a local vendor dir and composer.lock if we didn’t already.

Now that we have our dependencies locally, we are able to mount them into the image each time we run a test suite.

We also pass in the .env.test which has the env var for xdebug CLI.

And we also pass -t which gives us colour in the output:

```
> docker run --env-file=.env.test -t -v$(pwd):/app <library-name>:latest vendor/bin/behat --format=progress
> docker run --env-file=.env.test -t -v$(pwd):/app <library-name>:latest vendor/bin/phpunit
```
