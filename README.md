# Slim Framework 4 on Google App Engine Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/groton-school/slim-lti-gae-skeleton/badge.svg?branch=master)](https://coveralls.io/github/groton-school/slim-lti-gae-skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application running on Google App Engine. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses Google Cloud Logging.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application. You will require PHP 7.4 or newer.

```bash
composer create-project --stability dev groton-school/slim-lti-gae-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

- Point your virtual host document root to your new application's `public/` directory.
- Ensure `logs/` is web writable.

To run the application in development, you can run these commands

```bash
cd [my-app-name]
composer start
```

Deploying the application to Google App Engine requires both [gcloud](https://cloud.google.com/sdk/docs/install) and [Node](https://nodejs.org) as prerequisites. With both of those tools installed, install the Node package dependencies.

```bash
npm install
```

Deploy the app (which will take you through an interactive wizard to reuse or create and configure a new Google Cloud project):

```bash
node bin/deploy.js
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:

```bash
cd [my-app-name]
docker-compose up -d
```

After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.
