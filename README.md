# improv.ee v2

[![](https://img.shields.io/travis/improv-ee/improv-ee.svg)](https://travis-ci.org/improv-ee/improv-ee)
[![Maintainability](https://api.codeclimate.com/v1/badges/d9ce787b2bf6972eddbc/maintainability)](https://codeclimate.com/github/improv-ee/improv-ee/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/d9ce787b2bf6972eddbc/test_coverage)](https://codeclimate.com/github/improv-ee/improv-ee/test_coverage)
[![](https://img.shields.io/docker/pulls/improv/improv-ee.svg)](https://cloud.docker.com/u/improv/repository/docker/improv/improv-ee)

This is the source code for https://improv.ee, a website dedicated to listing information and events about improvised theatre.

**It is very much in development stages.**


## Development

Configuration instructions are provided for a Linux (Ubuntu) based development environment.

### Needs to be installed

- [Docker][] (latest)
- [Docker Compose][] (latest)
- `openssl` (`apt-get install openssl`)
- [Composer][]
- [npm][]

### Setup

Install vendor packages:

```bash
cd src
composer install
npm install
```

Run the setup script:

```bash
./setup.sh
```

This will generate a new self-signed CA and certificates for local development. You need to
install your new Certificate Authority into your web browser. [Here is how](https://wiki.wmtransfer.com/projects/webmoney/wiki/Installing_root_certificate_in_Mozilla_Firefox)
to do it for Firefox (`Settings -> Certificate Authorities -> Add`). The CA file for importing
is `docker/lb/certs/ca.crt`. If done correctly, this will make `https://` "green" for our dev domains:

`dev.improv.ee` will be the frontend webserver
`api.dev.improv.ee` will be the API

DNS entries are already configured in global DNS to point to `127.0.0.1`.

Review settings in `src/.env` - this will be your local conf.

Bring up services:

```bash
docker-compose up
```

You need to bootstrap the database (once) and set up Laravel.

```bash
docker-compose run webserver bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan passport:install
```

`passport:install` will output 2 clients. Copy the ID and client secret of the password client and
add them to `.env` file. 

```
OAUTH_API_CLIENT_ID=2
OAUTH_API_CLIENT_SECRET=xxxxxx
```

If all goes well you should have Docker containers running, database bootstrapped and webpages
(with green HTTPS) opening on `dev.improv.ee` and `api.dev.improv.ee`.

## Deployment to a DigitalOcean Droplet

```bash
$ export DIGITALOCEAN_TOKEN=xxxx
$ cd terraform
$ terraform init
$ terraform apply

# Check that all resources created OK in DO
# Map domain name to floating IP

$ cd ../ansible

# Save vault token
$ nano .vault 
$ ansible-playbook -i hosts playbooks/all.yml
```

## Api Doc

API documentation can be generated using https://github.com/mpociot/laravel-apidoc-generator

Run:

```bash
$ php artisan apidoc:generate
```

Open `public/doc/index.html` with a local webbrowser.

## Contributing

Want to help? Great - submit a pull request or an issue.

## License

Licensed under Apache-2.0 license.

[Docker]: https://docs.docker.com/install/linux/docker-ce/ubuntu/
[Docker Compose]: https://docs.docker.com/compose/install/
[Composer]: https://getcomposer.org/download/
[npm]: https://www.npmjs.com/get-npm
