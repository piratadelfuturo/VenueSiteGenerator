# prod deploy code:
// ERRASES EVERYTHING
prod initial deploy:
rm -rf app/cache/*;
php app/console cache:clear -e prod;
php app/webconsole cache:clear -e prod;
php app/console assets:install public_html -e prod;
php app/console assetic:dump -e prod;
php app/console sulu:build phpcr_migrations -e prod -n;
chown plazapmg:plazapmg -R  ./ public_html public_html/*;
chmod 755 public_html public_html/*;
rsync -avz public_html/ ../public_html/sitescms/;
chown plazapmg:plazapmg -R ../public_html/sitescms/ ../public_html/sitescms/*;
chmod 755 ../public_html/sitescms/ ../public_html/sitescms/*;

// ERRASES NOTHING
prod update:
rm -rf app/cache/*;
php app/console cache:clear -e prod;
php app/webconsole cache:clear -e prod;
php app/console sulu:build phpcr_migrations -e prod -n;
php app/console assets:install public_html -e prod;
php app/console assetic:dump -e prod;
chown plazapmg:plazapmg -R  ./ public_html public_html/*;
chmod 755 public_html public_html/*;
rsync -avz public_html/ ../public_html/sitescms/;
chown plazapmg:plazapmg -R ../public_html/sitescms/ ../public_html/sitescms/*;
chmod 755 ../public_html/sitescms/ ../public_html/sitescms/*;


DEV:

load translations:
php app/console translation:extract fr --dir=./src/ --output-dir=./app/Resources/translations

load fixtures: // -n erases all database
php -d xcache.var_size=100M app/console sulu:document:fixtures:load --fixtures  ./src/PmgSocialBundle/Datafixtures/Document/ -e prod -n

dev:
rm -rf app/cache/*;
php app/console cache:clear -e dev;
php app/webconsole cache:clear -e dev;
php app/console assets:install public_html -e dev;
php app/console assetic:dump -e dev;
php app/console sulu:build phpcr_migrations;



# Sulu - Content Management

[![](https://travis-ci.org/sulu/sulu-standard.svg?branch=master)](https://travis-ci.org/sulu/sulu-standard)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sulu/sulu-standard/badges/quality-score.png?s=3039e48d6515ea846578ca06f3c5bd5442ad3c5b)](https://scrutinizer-ci.com/g/sulu/sulu-standard/)

[Sulu](http://sulu.io/) is an open-source content management platform based on the
[Symfony PHP framework](http://cmf.symfony.com/). Use it as a CMS to develop and
manage enterprise multi-sites or as a development environment to create reliable
and high-performant web-apps.

**Although Sulu is stable and already used in production it is still under
heavy development. Therefore we can not guarantee full backwards compatibility
at the current stage.**

## Installation

For the install guide and reference, see:

* [installation guide](http://docs.sulu.io/en/latest/book/getting-started/index.html)





