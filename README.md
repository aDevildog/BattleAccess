BattleAccess
============

A work in progress, BattleAccess is a PHP Api that allows you to access Soldier and Server information from Battlefield 4's Battlelog. BattleAccess requires a valid Battlelog email and password to be used to access the Soldier or Server of your choice, which must be provided in your Battlelog intance.

To grab the server information, you need to provide the Server GUID; but can be found fairly simply by pointing your browser to your server's full information. GUID will be located in the address bar, after /bf4/servers/show/pc/. In this following case the GUID would be e7a23c06-4a16-4b9e-a75b-fa6a6882bbdc:

`http://battlelog.battlefield.com/bf4/servers/show/pc/e7a23c06-4a16-4b9e-a75b-fa6a6882bbdc/`



```php
include 'BattleAccess.php';
$battlelog = new Battlelog ('EMAIL', 'PASSWORD');
$server = $battlelog->getServer('server GUID')
```
