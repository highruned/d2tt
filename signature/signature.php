<?php

	define('PATH_D2TRADETOOLS_SIGNATURE', realpath(dirname(__FILE__)));

	class D2TradeTools_Signature {
		public function __construct() {

		}

		private function get_color_from_code($im, $code) {
			if($code == "c3") // magic
				return ImageColorAllocate($im, 179, 226, 255);
			else if($code == "c4") // unique
				return ImageColorAllocate($im, 255, 225, 143);
			else if($code == "c9") // rare
				return ImageColorAllocate($im, 255, 255, 179);
			else if($code == "c8") // rune
				return ImageColorAllocate($im, 255, 255, 179);
			else if($code == "c5") // white
				return ImageColorAllocate($im, 255, 255, 255);
			else if($code == "c2") // set
				return ImageColorAllocate($im, 68, 224, 64);
			else if($code == "c0") // gem
				return ImageColorAllocate($im, 255, 255, 255);
			else // normal
				return ImageColorAllocate($im, 3, 56, 126);
		}

		public function show($params = array()) {
			$params = array_merge(array(
				'name' => 'UNKNOWN',
				'log' => null
			), $params);

			extract($params);

			$filename = PATH_D2TRADETOOLS_SIGNATURE . "/cache/sig.png";

			if(file_exists($filename)) {
				$mtime = filemtime($filename);
				
				$updated_since = time() - $mtime;
				
				if($updated_since < 1 * 60) {// has the file changed in the last minute? if not, let's refresh it
					header("Content-type: image/png");

					die(file_get_contents($filename));
				}
			}

			$im = imagecreatefrompng('backgrounds/texture1.png');
			imagecolortransparent($im, imagecolorallocate($im, 84, 255, 0));

			$title = $name . "'S UPDATED FT LIST...";
			$title_color = ImageColorAllocate($im, 255, 255, 255);
			$title_shadow_color = ImageColorAllocate($im, 3, 56, 126);

			imagestring($im, 3, 5 - 1, 5, $title, $title_shadow_color);
			imagestring($im, 3, 5, 5 - 1, $title, $title_shadow_color);
			imagestring($im, 3, 5 + 1, 5, $title, $title_shadow_color);
			imagestring($im, 3, 5, 5 + 1, $title, $title_shadow_color);
			imagestring($im, 3, 5 + 1, 5 + 1, $title, $title_shadow_color);
			imagestring($im, 3, 5 - 1, 5 - 1, $title, $title_shadow_color);
			imagestring($im, 3, 5, 5, $title, $title_color);

			$items = array_slice(json_decode(file_get_contents($log), true), 0, 7);

			foreach($items as $i => $item) {
				$time = $item['timestamp'];
				$details = $item['details'];
				$title = $item['title'];

				$title_shadow_color = ImageColorAllocate($im, 3, 56, 126);
				$title_color = $this->get_color_from_code($im, $item['color']);

				imagestring($im, 3, 13 - 1, 22 + (15 * $i), $title, $title_shadow_color);
				imagestring($im, 3, 13, 22 + (15 * $i) - 1, $title, $title_shadow_color);
				imagestring($im, 3, 13 + 1, 22 + (15 * $i), $title, $title_shadow_color);
				imagestring($im, 3, 13, 22 + (15 * $i) + 1, $title, $title_shadow_color);
				imagestring($im, 3, 13 + 1, 22 + (15 * $i) + 1, $title, $title_shadow_color);
				imagestring($im, 3, 13 - 1, 22 + (15 * $i) - 1, $title, $title_shadow_color);

				imagestring($im, 3, 13, 22 + (15 * $i), $title, $title_color);

				$title_color = $this->get_color_from_code($im, NULL);

				$x = strlen($title) * imagefontwidth(3) + 20;

				if(in_array('unid', $details)) {
					$text = " - unid";
				}
				else {
					$text = ' - ' . implode('; ', $details);
				}

				$title_shadow_color = ImageColorAllocate($im, 3, 56, 126);
				$title_color = ImageColorAllocate($im, 255, 255, 255);

				imagestring($im, 3, $x - 1, 22 + (15 * $i), $text, $title_shadow_color);
				imagestring($im, 3, $x, 22 + (15 * $i) - 1, $text, $title_shadow_color);
				imagestring($im, 3, $x + 1, 22 + (15 * $i), $text, $title_shadow_color);
				imagestring($im, 3, $x, 22 + (15 * $i) + 1, $text, $title_shadow_color);
				imagestring($im, 3, $x + 1, 22 + (15 * $i) + 1, $text, $title_shadow_color);
				imagestring($im, 3, $x - 1, 22 + (15 * $i) - 1, $text, $title_shadow_color);

				imagestring($im, 3, $x, 22 + (15 * $i), $text, $title_color);
			}

			$title = "...VISIT MY PROFILE FOR TOPIC AND DETAILS";
			$title_color = ImageColorAllocate($im, 255, 255, 255);
			$title_shadow_color = ImageColorAllocate($im, 3, 56, 126);

			imagestring($im, 3, 110 - 1, 135, $title, $title_shadow_color);
			imagestring($im, 3, 110, 135 - 1, $title, $title_shadow_color);
			imagestring($im, 3, 110 + 1, 135, $title, $title_shadow_color);
			imagestring($im, 3, 110, 135 + 1, $title, $title_shadow_color);
			imagestring($im, 3, 110 + 1, 135 + 1, $title, $title_shadow_color);
			imagestring($im, 3, 110 - 1, 135 - 1, $title, $title_shadow_color);
			imagestring($im, 3, 110, 135, $title, $title_color);

			// get the image data
			ob_start();
			imagegif($im);
			$data = ob_get_contents();
			ob_end_clean();

			// write the image data
			$handle = fopen(PATH_D2TRADETOOLS_SIGNATURE . "/cache/sig.png", 'w');
			fwrite($handle, $data);
			fclose($handle);

			imagedestroy($im);

			// display the image data
			header("Content-type: image/png");

			die($data);
		}
	}