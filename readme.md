# WordPress Development Environment with Lando

This repository contains a development environment setup for WordPress using Lando as the local development platform.

## Overview

This setup provides a complete WordPress development environment with the following features:

- PHP 8.2
- MySQL database
- Nginx web server
- Redis cache
- Composer 2 for dependency management
- MailHog for email testing
- Xdebug for debugging
- Custom configuration scripts

## Prerequisites

- [Lando](https://docs.lando.dev/getting-started/installation.html)
- Git

## Getting Started

1. Clone this repository
2. Navigate to the project directory
3. Run `lando start`

The setup will automatically:
- Copy the local WordPress configuration file (`wp-config-local.php` to `wp-config.php`)
- Run pre-start and post-start scripts located in the `.lando` directory

## Configuration Files

### .lando.yml

The main configuration file that defines the development environment:

```yaml
name: my-wp-starter
recipe: wordpress
config:
  php: 8.2
  composer_version: 2
  webroot: .
  database: mysql
  cache: redis
  ssl: false
  via: nginx
  xdebug: true
services:
  appserver:
    build:
      - cp wp-config-local.php wp-config.php
    run:
      - .lando/run.sh
  mailhog:
    type: mailhog
    portforward: true
    hogfrom:
      - appserver
proxy:
  appserver_nginx:
    - wp-starter.local
events:
  pre-start:
    - appserver: .lando/pre-start.sh
  post-start:
    - appserver: .lando/post-start.sh
```

### .lando Directory

Contains scripts that are executed at different stages of the Lando lifecycle:

- `pre-start.sh`: Executed before the environment starts
- `post-start.sh`: Executed after the environment starts
- `run.sh`: Executed when the environment is running

## WordPress Configuration

The setup automatically copies `wp-config-local.php` to `wp-config.php` during the build process, which allows you to maintain separate configurations for different environments.

## Redis Cache

This setup includes Redis for object caching, which can significantly improve performance. Make sure you have a Redis plugin installed and activated in WordPress to take advantage of this feature.

## Xdebug

Xdebug is enabled by default for PHP debugging. You'll need to configure your IDE to connect to Xdebug. The default port is 9003.

## URLs

- **WordPress site**: http://wp-starter.local
- **MailHog**: http://localhost:8025 (default MailHog port)

## Common Commands

```bash
# Start the environment
lando start

# Stop the environment
lando stop

# SSH into the application container
lando ssh -s appserver

# Run WP-CLI commands
lando wp [command]

# Run Composer commands
lando composer [command]

# View logs
lando logs

# Rebuild the environment
lando rebuild

# Get database connection information
lando info
```

## Email Testing

MailHog is included for email testing. All emails sent from WordPress will be captured by MailHog and can be viewed at http://localhost:8025.

## Important Notes

1. This is a **development environment only** and should not be used for production.
2. SSL is disabled by default. Enable it in `.lando.yml` if needed.
3. Custom scripts in the `.lando` directory should be made executable (`chmod +x .lando/*.sh`).
4. The `wp-config-local.php` file should contain your local development settings and should not be committed to version control.

## Customization

- Modify `.lando.yml` to add additional services or change configuration
- Update scripts in the `.lando` directory to customize the setup process
- Create custom WordPress plugins and themes in their respective directories

## Troubleshooting

- If the site doesn't load, check that the domain is properly set up in your hosts file
- For database connection issues, verify the credentials in your `wp-config.php` file
- If scripts fail to execute, ensure they have executable permissions
- For Redis connection issues, check that the Redis service is running with `lando info`

## License

[MIT](https://opensource.org/licenses/MIT)