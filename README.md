# **prod deploy code:** #

*ERASES EVERYTHING*
**prod initial deploy:**

```
#!bash


rm -rf app/cache/*;
php app/console cache:clear -e prod;
php app/webconsole cache:clear -e prod;
php app/console assets:install public_html -e prod;
php app/console assetic:dump -e prod;
php app/console sulu:build phpcr_migrations -e prod -n;
chown plazapmg:plazapmg -R  ./ public_html public_html/*;
chmod 755 public_html public_html/*;
rsync -avz --exclude 'uploads' public_html/ ../public_html/sitescms/;
chown plazapmg:plazapmg -R ../public_html/sitescms/ ../public_html/sitescms/*;
chmod 755 ../public_html/sitescms/ ../public_html/sitescms/*;

```

*ERASES NOTHING*
**prod update:**

```
#!bash

rm -rf app/cache/*;
php app/console cache:clear -e prod;
php app/webconsole cache:clear -e prod;
php app/console sulu:build phpcr_migrations -e prod -n;
php app/console cache:warmup -e prod;
php app/webconsole cache:warmup -e prod;
php app/console assets:install public_html -e prod;
php app/console assetic:dump -e prod;
chown plazapmg:plazapmg -R  ./ public_html public_html/*;
chmod 755 public_html public_html/*;
rsync -avz --exclude 'uploads' public_html/ ../public_html/sitescms/;
chown plazapmg:plazapmg -R ../public_html/sitescms/ ../public_html/sitescms/*;
chmod 755 ../public_html/sitescms/ ../public_html/sitescms/*;
```



**DEV:**

**dumps translations:**

```
#!bash

php app/console translation:extract fr --dir=./src/ --output-dir=./app/Resources/translations
```


**load fixtures: // -n erases all database**

```
#!bash

php app/console sulu:document:fixtures:load --fixtures  ./src/PmgSocialBundle/Datafixtures/Document/ -e prod -n
```


**dev:**

```
#!bash

rm -rf app/cache/*;
php app/console cache:clear -e dev;
php app/webconsole cache:clear -e dev;
php app/console assets:install public_html -e dev;
php app/console assetic:dump -e dev;
php app/console sulu:build phpcr_migrations -n;

```

# Steps to point a hostname to the sitescms.plazapmg.com document root folder

Find the filename of the document to edit to add the new hostname to be read by sitescms.plazapmg.com virtualhost in the Apache config file.

Apache config file: nano /etc/httpd/conf/httpd.conf

File that adds configuration parameters to sitescms.plazapmg.com virtualhost configuration
/usr/local/apache/conf/userdata/std/2_4/plazapmg/sitescms.plazapmg.com/*.conf

After editing the file mentioned above, to apply the vhost config file changes in easy apache use the following command, replacing username with the plazapmg username:

/scripts/ensure_vhost_includes --user=username

If the hostname is already configured for another user in the Apache config file, you have to override the same way the user Apache configfile in a similar way as above:
/usr/local/apache/conf/userdata/std/2_4/USERNAME/DOMAIN.COM/*.conf

With the following rules:

#

ServerAlias old.plazacentreville.com

RewriteEngine On
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^/(.*) http://www\.%{HTTP_HOST}/$1 [R=301,L]

```


And then run the script to include the file that changes the virtualhost configuration for the user that hosts the hostname your want to modify:
/scripts/ensure_vhost_includes --user=username


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


ADMIN Panel
http://sitescms.plazapmg.com/admin