# prod deploy code:

prod:
rm -rf app/cache/*;
php -d xcache.var_size=100M app/console cache:clear -e prod;
php -d xcache.var_size=100M app/console sulu:build prod;
php -d xcache.var_size=100M app/console assets:install public_html -e prod;
php -d xcache.var_size=100M app/console assetic:dump -e prod;rsync -avz --exclude 'public_html/.htaccess'  public_html/ ../public_html/sitescms/

dev:
rm -rf app/cache/*;
php -d xcache.var_size=100M app/console cache:clear -e dev;
php -d xcache.var_size=100M app/console sulu:build dev;
php -d xcache.var_size=100M app/console assets:install public_html -e dev

#file permissions
chomd 755
755 public_html public_html/*


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





