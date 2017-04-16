---
Product: Illumine Framework
Documentation: 'Setup &#038; Configuration'
Url: >
  https://www.wordpresspluginpro.com/docs/illumine-framework/setup/
---
# Illumine-Framework
<ul><li class="pagenav">Documentation<ul><li class="page_item page-item-559"><a href="setup.md">Setup &#038; Configuration</a></li>
</ul></li></ul>
## Setup & Configuration
Illumine Framework is designed as a starter which you can own going forward.  This codebase is a platform to extent into your own plugin framework for your projects.  Together we can design the best possible setup to share amongst each other while still remaining independent and free to manage our code on our own with customizations to any component.

**Currently the framework is not designed to be updated by a secondary repo.  Once we can resolve the dynamic aspect of the container we can move the framework to its own repo separate from the current package.

Getting Started:
<ol>
 	<li>Change the filename of the container class, and rename the class function to match.
<pre><strong> illumine-framework/illumine/IlluminePlugin.php to MyPlugin.php </strong></pre>
</li>
 	<li>Change the name of the class instance function call to match the container class.
<pre><strong>illumine-framework/bootstrap/framework.php
illumine-framework/illumine/controllers/BaseController.php
</strong></pre>
</li>
 	<li>Edit the configuration file to suite your needs and update the encryption key with a new one and provide a namespace for your plugin.
<pre><strong>illumine-framework/app/config.php</strong></pre>
</li>
 	<li>Edit the primary namespace of  files to match your configuration setting.
<pre><strong>illumine-framework/app/*
</strong><strong>illumine-framework/plugin.php
composer.json (line 27)</strong></pre>
</li>
 	<li>Open a terminal, change to the project directory and run "composer update"</li>
 	<li>Upload the plugin to your server or symlink to your local Wordpress installation.</li>
 	<li>Test included shortcodes:
<strong>[wpp_directory]</strong> <em>(Ajax Pagination of all Posts)</em>
<strong>[wpp_profile]</strong> <em>(Update Current User)</em>
<strong>[wpp_search]</strong> <em>(Basic Search Field)</em></li>
</ol>
Please help us make Illumine the best it can be.   Contribute any suggestions or solutions on GitHub or our website.