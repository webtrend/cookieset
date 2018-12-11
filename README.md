# Cookie Set plugin for Craft CMS 3.x

A plugin that stores Google Analytics utm_parameter query string to a client cookie.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require webtrend/cookie-set

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Cookie Set.


## Using Cookie Set

	{% hook 'SetMyCookies' %}

Brought to you by **Webtrend**
