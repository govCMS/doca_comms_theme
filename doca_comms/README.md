# DoCA Site Theme

The Department of Communications and Arts theme for the govCMS website

## Overview

This is a theme for Drupal 7 govCMS

### Dependencies

* [Git](http://git-scm.com/)
* [Node](https://nodejs.org/en/), which includes the NPM package manager
* [bundler](http://bundler.io/), install all the required gems
* [Bower](https://bower.io/)

### Settings

* bower.json - vendors configuration
* config.rb - `Compass` configuration
* Gemfile - provides required Gems for `gulp` and `compass`
* gulpfile - gulp configuration
* package.json - install required node libraries for `gulp`

### Set up local environment

Run following commands to install global libraries

```
sudo gem update --system
gem install bundler
```

Run following commands in theme folder

```
bundle
npm install
```

#### For Mac developers

```
Installing sass 
Operation not permitted - /usr/bin/sass
```

If you have above issues, try

```
brew install ruby
```
