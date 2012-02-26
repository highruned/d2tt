# D2 Trade Tools - Signature

Provides you with a trading list signature.

![signature](http://o7.no/xuer8F)

Place this directory somewhere publicly on your web server. Simply send a request to the directory and it will return your signature based upon your log.

Your log file must conform to this format:

```json
[
	{"timestamp": 99999, "title": "Item 1", "color": "c4", "details": ["Detail 1", "Detail 2", "Detail 3"]},
	{"timestamp": 99999, "title": "Item 2", "color": "c4", "details": ["Detail 1", "Detail 2", "Detail 3"]}
]
```

Example: 

```json
[{"timestamp":1273892762307,"details":["fuscina","2h dmg: 108 204","req dex: 15","req str: 67","req lvl: 33","spear class - slow attack speed","+180% ed","+30-50 dmg","slows target by 75%","+10 str","+117 life (based on character lvl)","fr +50%","ethereal (cannot be repaired)"],"color":"c4","title":"Kelpie Snare"},{"timestamp":1273867897867,"details":["def: 784","req str: 164","req lvl: 61","ethereal (cannot be repaired)"],"color":"c5","title":"Kraken Shell"},{"timestamp":1273844292901,"details":["def: 641","req str: 230","req lvl: 64","+15% ed"],"color":"c0","title":"Superior Shadow Plate"},{"timestamp":1273831092484,"details":["weapons: 20% bonus ar","armor: +5% max pr","helms: +5% max pr","shields: +5% max pr","req lvl: 53"],"color":"c8","title":"Gul Rune"},{"timestamp":1273804773960,"details":["req lvl: 45","+3 combat skills","+10% fcr"],"color":"c3","title":"Rose Branded Amulet of the Apprentice"},{"timestamp":1273798399906,"details":["def: 63","req str: 50","unid","unidentified"],"color":"c4","title":"Spiderweb Sash"},{"timestamp":1273781615380,"details":["req lvl: 24","+2 str","+8 mana"],"color":"c3","title":"Snake's Small Charm of Strength"},{"timestamp":1273775709873,"details":["def: 30","req lvl: 45","+3 martial arts (assassin only)","+30% frw"],"color":"c3","title":"Kenshi's Circlet of Speed"},{"timestamp":1273749057957,"details":["weapons: 20% bonus ar","armor: +5% max pr","helms: +5% max pr","shields: +5% max pr","req lvl: 53"],"color":"c8","title":"Gul Rune"}]
```