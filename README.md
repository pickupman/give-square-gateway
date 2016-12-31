=== Plugin Name ===
Contributors: Joe McFrederick
Donate link: http://reloadedpc.com
Tags: give, square, square connect
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Square Connect Payment Gateway for the Wordpress Give Plugin.

== Description ==

This plugin enables to process donations using the Square Payment Platform. Your Square account must be activated to
process credit cards in order for this plugin to function. You will also need to create a Square Connect application
in your account (free).

== Installation ==

You will need to create a Square Connection application for your account at: https://connect.squareup.com/apps

If you are already have a application created, or just created one, take not of your Application ID and Personal
Access Token. These will be needed later for connecting your account to this plugin to process transactions.

1. Install `give` plugin for wordpress. This can be done from `Plugins->Add New` and search for Give.
2. Download this zip file to your computer. Unzip the contents of the zip package to your computer.
3. Open command line, and navigate to the folder you unzipped the files.
4. Run the command `composer install`. This will install the Square Connect SDK
5. Upload the the entire contents of the folder to `/wp-content/plugins/` directory
6. Activate the plugin through the 'Plugins' menu in WordPress
7. Go to `Donations->Settings` and then click on the `Payment Gateways` tab.
8. In the section `Enabled Gateways`, click on Square, and then `Save Changes` button.
9. After updates saves, the Square settings will be enabled near the bottom of the page. Copy and pasted your
Application ID, and Personal Access Token into the appropriate inputs. Click on `Save Changes` again.
10. You now may want to select the Square gateway as your default in the `Default Gateway` drop down.

== Frequently Asked Questions ==

= What does it cost to create a Square Connect application? =

Free. You can create a new application for free on your Square account.

= Where can I create a Square Connection application? =

[Square Connect](https://connect.squareup.com/apps)

== Screenshots ==


== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==
