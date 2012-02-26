<?php

	require_once("extra/common.php");

	class D2TradeTools_Watcher {
		public static $before = array("attributes", "bow and crossbow", "paladin", " (pally only)", "faster run/walk", "enhanced defense", "enhanced damage", " (amazon only)", " (necromancer only)", " over ", "gauntlets", "seconds", "poison", "resist", "fire res", "cold res", "lightning res", "psn res", " (sorceress only)", " (barbarian only)", "better Chance of Getting Magic Items", "two-hand", "poison and bone", "mana stolen per hit", "life stolen per hit", "maximum", "minimum", "crushing blow", "skill levels", "sorceress", "faster hit recovery", "faster cast rate", "mace class - very fast attack speed", "can be inserted into socketed items", " to ", "Damage Reduced by", "Defense", "Magic Find", "Level", "Attack Rating", "Keep in Inventory Gain Bonus", "to Life", "to Mana", "Javelin and Spear Skills (Amazon Only)", "Warcries (Barbarian Only)", "poison damage over", "Dexterity", "Strength", "Required", "Durability", " of ", "Adds ", "lightning", "damage", "One-Hand");
		public static $after = array("attr", "bow", "pally", '', "frw", "ed", "ed", '', '', " / ", "gaunts", "sec", "psn", "res", "fr", "cr", "lr", "pr", '', '', "mf", "2h", "pnb", "ml", "ll", "max", "min", "cb", "skills", "sorc", "fhr", "fcr", '', '', ' ', "reduce dmg", "def", "mf", "lvl", "ar", '', "life", "mana", "javs", "warcries", "/", "dex", "str", "req", "dur", "/", "+", "lite", "dmg", "1h");

		public function __construct() {

		}

		private function get_color_from_code($code) {
			if($code === "c3") // magic
				return "B3E2FF";
			else if($code === "c4") // unique
				return "FFFF8F";
			else if($code === "c9") // rare
				return "FFFFB3";
			else if($code === "c8") // rune
				return "FFFFB3";
			else if($code === "c5") // white
				return "FFFFFF";
			else if($code === "c2") // set
				return "44E040";
			else if($code === "c0") // gem
				return "FFFFFF";
			else // normal
				return "03387E";
		}

		public function get_items($params = array()) {
			$params = array_merge(array(
				'logs' => array()
			), $params);

			extract($params);

			$items = array();

			foreach($logs as $log) {
				$x1 = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', file_get_contents($log));

				foreach(explode("\n", $x1) as $i => $item) {
					$item = json_decode($item, true);

					if(!$item)
						continue;

					$time = $item['timestamp'];
					$details_str = $item['details'];

					$item['details'] = array(); // clear the old details, replace with new below

					$details = explode("|", $details_str);

					if(!preg_match("/#(..)([^#]+)(#..)?$/simU", $details[0], $x2))
						continue;

					$item['color'] = $x2[1];
					$item['title'] = trim($x2[2]);

					foreach(array_slice($details, 1) as $detail) {
						$detail = preg_replace("/#(..)/simU", '', $detail);

						$detail = str_ireplace(self::$before, self::$after, strtolower($detail));

						if(!$detail)
							continue;

						if(stristr($detail, "unidentified"))
							$item['details'][] = 'unid';
						if(!stristr($detail, "dur:"))
							$item['details'][] = $detail;
					}
		
					array_push($items, $item);
				}
			}

			usort($items, function($a, $b) {
				if($a['timestamp'] == $b['timestamp']) {
					return 0;
				}

				return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
			});

			return $items;
		}

		public function get_notes($params) {
			$params = array_merge(array(
				'items' => array()
			), $params);

			extract($params);


			$notes = "[CENTER][SIZE=10]Accepting offers on my recently found items. Please see my trade thread.[/SIZE][/CENTER]

	[SIZE=7][CENTER][U][B]FT List[/B][/U][/CENTER][/SIZE]
	";
			
			$items = array_slice($items, 0, 50);

			foreach($items as $i => $item) {
				$time = $item['timestamp'];
				$details = $item['details'];
				$title = $item['title'];

				$notes .= "[" . ago($time / 1000) . " ago] [COLOR=" . $this->get_color_from_code($item['color']) . "][b]" . $title . "[/b][/COLOR] [I]- ";

				foreach($details as $i => $detail) {
					if($detail === 'unid')
						$notes .= "[COLOR=red]" . $detail . "[/COLOR]";
					else
						$notes .= $detail;

					if($i !== count($details) - 1)
						$notes .= "; ";
				}

				$notes .= "[/I]\n";
			}

			return $notes;
		}

		public function watch($params) {
			$params = array_merge(array(
				'logs' => array(),
				'services' => array(),
				'callback' => null
			), $params);

			extract($params);

			while(true) {
				$items = $this->get_items(array('logs' => $logs));
				$notes = $this->get_notes(array('items' => $items));

				foreach($services as $service) {
					$service->set_notes($notes);
				}

				// write the items to the log file for other components
				$text = json_encode($items);

				$handle = fopen("logs/items.txt", 'w');
				fwrite($handle, $text);
				fclose($handle);

				if($callback)
					$callback();

				// synchronize every minute
				echo "Refreshed.\n";

				sleep(1 * 60);
			}
		}
	}