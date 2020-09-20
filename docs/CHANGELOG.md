# microCMS Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Post Beta] - [1.5.1] - 20200920 1900 UTC - Develpoment
 - add comment count to Admin->Main
 - add Last 3 Bad IPs to Admin->Main with country image
 - add Update Notification to admin Dashboard Menu
 - add check core update to mc-includes->functions
 - update Dashboard->Update to use check_coreUpdate
 - Add account user page and redirect on login

## [Post Beta] - [1.5.1] - 20200919 1530 UTC - Develpoment
 - add commenting on post
 - add comment count per post in admin->posts
 - add if isset to logged_time() to correct error
 - add mc_login_url() mc-includes->functions
 - add mc_logout_url() mc-includes->functions
 - add mc_register_url() mc-includes->functions
 - fix log in button on show_post
 

## [Beta Release] - [1.5.1] - 20200918 0400 UTC - Beta
 - Fixed Admin Index plugin population
 - Fixed Admin Menu plugin population
 - added missing variable to admin->users
 - repackaged 1.5.1 for beta

## [Beta Release] - [1.5.1] - 20200918 0230 UTC - Beta
 - Release 1.5.1 Beta for testing

## [Unreleased]

## [1.5.1] - 20200918 0130 UTC - Development
 - fix front-end ajax, method and JS data
 - add admin->users methods (CRUD)
 - add admin->site theme management
 - add plugins CRUD functionality
 - add admin->update method
 - add admin->sentry update check

 
## [1.5.1] - 20200917 2010 UTC - Development
 - add font awsome icons to admin main
 - add 30 minute auto logout
 - add RSS
 - add Admin Settings Methods
 - add total banned IP to Admin->Sentry
 - add most popular banned IP country to Admin->Sentry

## [1.5.1] - 20200915 1710 UTC - Development
 - fix admin dashboard css
 - add site favicon to admin dashboard header
 - add admin dashboard sentry functionality
 - add site visit count update method, usable in theme front_page or header
 - add site visit count to admin dashboard
 - add JS feature for like_post on show_post, like button is now working

## [1.5.1] - 20200914 1700 UTC - Development
 - add route class
 - add admin route class
 - add admin dashboard functionality
 - add maintenance check to index
 - add functions to handle back-end methods
 - opted to use post/slug vs post/day/month/year/slug for posts and SEO
 - revamped core theme
 - add remote news to admin dashboard via CuRL and JSON
 - add debug detection to index
 - add check install to index
 - add admin dashboard post functionality

## [1.5.1] - 20200830 2004 UTC - Development
 - add parse_url to privacy-policy
 - remove define from index
 - add forgot password page

## [1.5.1] - 20200829 0315 UTC - Development
 - remove autoload
 - add autoload to loader.php
 - add Signup -> email to site\core
 - add admin_email to site\settings
 - add privacy-policy plugin to core_plugins
 - add debug option to config
 - fixed blogs bootstrap issue
 - add PHPMailer to mc-includes
 

## [1.5.1] - 20200827 2340 UTC - Development
- mc-core\loader
- Other Major Codex Changes

## [1.5.1] - 20191012 0250 UTC - Development

### Added
- microcms\settings Class

## [1.5.1] - 20191011 0200 UTC - Development

### Added
- Register
- Login
- Logout

## [1.5.1] - 20191009 0150 UTC - Development

### Added
- Changed og: to twitter: for Twitter OpenGraph in Core theme header

## [1.5.1] - 20191005 0000 UTC - Development

### Added
- is_ssl() function to microcms\core

## [1.5.1] - 20190924 0150 UTC - Development

### Added
- IP based Security Checks
- Sentry Security Class
- Core Class
- Database Class
- Core Theme
