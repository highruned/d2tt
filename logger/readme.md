# D2 Trade Tools - Logger

Currently you must modify your bot application to log the items it keeps to a log file. That file must conform to this format:

```
{"timestamp": 9999, "details": "Item 1|Item Description||Attribute 1|Attribute 2|Attribute 3"}
{"timestamp": 9999, "details": "Item 2|Item Description||Attribute 1|Attribute 2|Attribute 3"}
```

Example: 

```
{"timestamp": 1273749057957, "details": "#c8Gul Rune#c0|Can be Inserted into Socketed Items||Weapons: 20% Bonus to Attack Rating|Armor: +5% to Maximum Poison Resist|Helms: +5% to Maximum Poison Resist|Shields: +5% to Maximum Poison Resist|#c0|Required Level: 53"}
{"timestamp": 1273775709873, "details": "#c3Kenshi's Circlet of Speed#c0|Defense: 30#c0|Durability: 20 of 35#c0|Required Level: 45#c3|+3 to Martial Arts (Assassin Only)|+30% Faster Run/Walk"}
```

Here is a script that has been successfully placed into the D2NT `NTTown.ntl` file, right before the `NTC_ItemToCursor` call.

```
var _hfile;

_hfile = FileOpen("log.txt", 2);

if(_hfile)
{
	var _log = new Array();

	while(line = _hfile.ReadLine())
		_log.push(line);

	_hfile.Close();

	_hfile = FileOpen("log.txt", 1);

	if(_hfile)
	{
		var _entry = '';

		var _desc = _items[i].itemdesc.split("\n").reverse();

		while(_desc.length > 1 && _entry.length < 400)
		{
			_entry += _desc.pop() + "|";
		}

		_entry += _desc.pop();

		_log.push('{"timestamp": ' + new Date().getTime() + ', "details": "' + _entry.replace(/ÿ/g, "#") + '"}');	

		_log = _log.slice(_log.length - 20);

		for(var j = 0, k = _log.length; j < k; ++j)
			_hfile.WriteLine(_log[j]);

		_hfile.Close();
	}
}
```