# Matomo-buildpack

Buildpack for running a Matomo instance on a Cloud Platform (Scalingo, Clever Cloud, Dokku, Heroku, etc.).

## Matomo

[Matomo](https://matomo.org) is a free and open source web analytics application, designed to be an open and compliant with GDPR alternative to Google Analytics.

It is mainly a PHP + MySQL/MariaDB application (with a little bit of AngularJS).

![](docs/screenshot.webp)

## History

This repository was originally designed to run Matomo and its [Tag Manager System](https://matomo.org/docs/tag-manager/) part on [Scalingo](https://scalingo.com) (a french PaaS) platform.

Scalingo proposed an [adapted application](https://github.com/Scalingo/matomo) forked from the original [Matomo project](https://github.com/matomo-org/matomo), installable with a "[one-click deploy button](https://scalingo.com/blog/one-click-deploy-everything-on-scalingo)".

There were some critical problems with this application:
- the TMS part and some other important plugins were not installed/available
- one could not pre-install and pre-activate Matomo purchased plugins ; thus, when the application restarted, installed plugins disappeared
- the upgrade of the application was too dependant of Scalingo capacity and willness to merge the parent forked repository (that is not easy)

After a failing first attempt to improve the Scalingo/matomo repository, we decided to radically change our approach, and try a new one inspired by the [Metabase buildpack](https://github.com/metabase/metabase-buildpack).

All that we want is to run an already packaged software. It seems then better to strat from the released program than to package it ourselves. This is what this buildpack does.

## Buildpack

This buildpack does the following, see `bin/compile`:
- for a given release/tag, it downloads (via a cUrl command) the Matomo archive
- unzip it 
- add some plugins, useful in a Cloud-based context
    - EnvironmentVariables
    - AdminCommands
    - DbCommands
- install and activate them by default
    
> The last two plugins are custom ones, initially developed by the Scalingo Team 💪.

The version of the Matomo is defined in the `bin/version` file. 

This buildpack follows the [Cloud Native Buildpacks Specification](https://github.com/buildpacks/spec). So it should be compatible with [Scalingo](https://doc.scalingo.com/platform/deployment/buildpacks/custom), [Dokku](http://dokku.viewdocs.io/dokku~v0.5.0/deployment/buildpacks/) or [Heroku](https://devcenter.heroku.com/articles/buildpacks).

## Matomo releases

Each tag of this repository corresponds to a Matomo official release.

For example, tag `v3.14.1` corresponds to [Matomo#3.14.1](https://builds.matomo.org/matomo-3.14.1.zip).

## Usage

In your Cloud application, define it as a multi-buildpacks application with matomo-buildpack and a php-based buildpack.

For example, for Scalingo, create a `.buildpacks` with:

```shell script
https://github.com/1024pix/matomo-buildpack#v3.14.1
https://github.com/Scalingo/php-buildpack
```

You can find a production-ready application [here](https://github.com/1024pix/matomo-scalingo-deploy).

## Upgrading

Releasing a new version of this buildpack is as easy as running the command:

```shell script
./upgrade-matomo-version <new_matomo_version> #ex: 3.14.2
```

This script does the following:
- change the `bin/version` with the one given in parameter
- declare and push a new tag named `vX.Y.Z`

## Rebuild an already published version

If you need to re-publish a version for some reasons, simply make your changes, then run:

```shell script
# some changes and git operations
git tag -d v3.14.1 && \
  git push --delete origin v3.14.1 && \
  git tag -a "v3.14.1" -m "Release v3.14.1" && \
  git push --tag
```

## License

This software has been distributed under [AGPL-3.0 license](https://choosealicense.com/licenses/agpl-3.0/).
