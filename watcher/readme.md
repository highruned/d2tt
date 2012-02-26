# D2 Trade Tools - Watcher

Watches your bot log files for changes and updates your services (D2JSP, etc) and item database (for your signature).

## Getting starts

If you aren't already, refer to the readme in the main D2 Trade Tools folder.

In order to run the watcher, you will need to use PHP. Open a Terminal or Shell, and navigate to this folder. Then run this command: `php main.php`. That's it.

## Getting your D2JSP cookies

1. Go to your D2JSP profile in Google Chrome. Click the Edit Notes button. Make sure you're logged in. 
![ss](http://o7.no/wFkIe6)
2. Right-click and click `Inspect Element`.
![ss](http://o7.no/xEHYDF)
3. Go to the Network tab. Click the little circle at the bottom.
![ss](http://o7.no/ArUMWR)
![ss](http://o7.no/w9Y27q)
4. Refresh the page. Click `Edit Profile Notes`.
5. Go to the top and click the top `user.php` box. Go to the `Headers` tab on the right. 
![ss](http://o7.no/yHS7aN)
6. Copy the text **after** `Cookie:` until before `Host:`. Put that as your COOKIE in `main.php`.
7. Put the `user_id` value as your `user_id` in `main.php`.
8. Put the `k` value as your `key` in `main.php`.