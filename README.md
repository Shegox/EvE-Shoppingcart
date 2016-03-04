# EvE-Shoppingcart
This is a small script to allow you to import shoppingcarts though the EvE-fitting api


# Use

You can use it to import list of items in the format:

"Quantity"TAB"Name"

"Quantity>TAB"Name"

And the script will then push these data to a capsule with the given name in your fitting area and allowes you to use the Buy-all option on these to buy your whole shoppingcart at once.

Productive can be found here: https://www.eve-shoppingcart.ovh/

# Setup

You need a database with the needed itemname<->itemid table (invTypes) and mysql and apache2.
Also is needed that you have php5-mysqlnd and php5-curl installed.

You can setup the database though the sql.php file and thats it. 

That's it!

#LICENSE

Published for the EVE-API challenge under the MIT-License (LICENSE)
