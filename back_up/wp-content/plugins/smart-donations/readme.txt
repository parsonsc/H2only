=== Smart Donations ===
Contributors: EDGARROJAS
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=edseventeen%40gmail.com
Tags: donations, donate, donation buttons, donation widget,widget, paypal, donations, donation page, donation plugin, nonprofit donations, campaign donations, political campaigns, donations, donation widget, donate page, donate plugin,charity, fundraising, shortcode, forms, widgets
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The all in one donation plugin, create different kind of donations, set goals, monitor your results, donation forms, thank you emails and more...

== Description ==

Smart Donations

Want to see a demo? check out the video tutorials here: http://rednao.com/tutorials.htm

 The all in one donation plugin, create different kind of donations, set goals, monitor your results, create donation forms, set thank you emails. Currently it supports paypal, wepay and five different styles of donations:
 
 *  **Classic Donation**.- The classic paypal or wepay button, When The user clicks the button he will be directed to the paypal/wepay page and he will define how much he want to donate there. (Paypal or wepay)
 
 *  **TextBox Donation**.- A paypal or wepay button with a text box so the donators can pick right away how much they want to donate. (Paypal or wepay)
   
 * **Three Buttons Donation**.- Three donation buttons (they dont have to be paypal buttons, you can customize them) each one with a different amounts (that you define) so the donators can donate with one click. (Paypal or wepay)
    
 *  **Slider Donation**.- This has an slider that the user can scroll to donate more or less money (you define the minimun and maximun amount), it also has a happy face that gets happier or not that happy depending on the donation amount. (Paypal or wepay)
 
 * **Forms**.- You need to ask something to the donors? then Forms donations is the way to go, you can create a custom form the way you want it (you can add text boxes, drop downs, checkboxes etc). Once you get a donation you will get an email with all that information. (Paypal only)

PayPal also support IPN notifications so you can keep track of all the donations, you can show a donation goal meter or analize how well you have been doing in a period of time.

Also you can customize the paypal currency that you want to use for each donation button.

*You can find more here:[Smart Donations](http://rednao.com/smartdonations.html "Smart Donations")
== Installation ==

1. Upload smart donations to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Smart Donations /Add new and create a new donation, you can use paypal or wepay.
4. To add the donation to a widget go to widgets and drag the smart donations widget
5. To add the donation to a post type [sdonations]donationid[/sdonations] (example:[sdonations]1[/sdonations]), you can find the donationid of your donation on the donations list (i will improve this on a future update)


== Frequently Asked Questions ==

= How can i get help=

You can check the smart donations video tutorial at http://rednao.com/tutorials.htm, if you have any question you can reach me at
https://www.facebook.com/SmartDonations

= How can i change the currencty of a wepay button =
Currently only paypal supports currencies, this is a wepay limitation so we dont have a way to add that to the plugin at this time.

= Why there is no ipn notifications for wepay =
This is another wepay limitation, Only paypal support ipn notifications because currently the standard wepay buttons does not support this.

= My progress indicators are not getting refreshed when i receive a donation =
The progress indicators need to use "IPN Notifications" so make sure to use paypal buttons, currently this plugin only support paypal IPN Notifications. (See question above for more information)






== Screenshots ==

1. Here you pick the donation style, paypal or wepay
2. Classic Donation (paypal or wepay)
3. Text Box Donation (paypal or wepay)
4. Three Buttons Donation (paypal or wepay)
5. Slider Donation (paypal or wepay)
6. Example of site with donations
7. You can customize any donation or progress indicator
8. Example of a donation progress indicators (Pro feature)
9. Analytics of all your donations(Pro)
10. Forms Donation Style (Pro, only paypal)

== Changelog ==
= 2.9.9 =
* Added feature to let you change the paypal donation description and the paypal button in the donation forms.
= 2.9.5 =
* Fixed minor issues with the donation items.
= 2.9 =
* Fixed a bug in Form donations, added thank you email to the donation campaigns and added the possibility to include amounts in the donation check, radio and combo boxes.
= 2.5.6 =
* Fixing issue with manual donations.
= 2.5.5 =
* Added Option to add required fields in a paypal donation form and fixing minor issues.
= 2.5.1 =
* Added paypal Donation forms, now you can create custom forms in your donations.
= 2.1.1 =
* Fixed Warnings in paypal donation ipn.
= 2.0.1 =
* Fixed minnor issues with donation items
= 2.0 =
* Added donation progress indicators and analytics to paypal.





== Upgrade Notice ==
N/A