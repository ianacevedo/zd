<?php 

class Exam {
	public function loadJSON($rows) {
		foreach (explode("\n", file_get_contents($rows)) as $row) {
	
			if (empty($row)) break; 
			$item = json_decode($row);			
			$result =  $this->getContents('https://lookup.binlist.net/' .$item->bin);
			$isEu = $this->isEu($result->country->alpha2);
			$rate = $this->getRate($item->currency);
			
			if ($item->currency == 'EUR' || $rate == 0) {
				$amntFixed = $item->amount;
			}
			if ($item->currency != 'EUR' || $rate > 0) {
				$amntFixed = $item->amount / $rate;
			} 
			
			$amt =  $this->formatAmount($amntFixed * ($isEu == 'yes' ? 0.01 : 0.02));	
			print $amt."\n";
		}	
	}
	
	public function formatAmount($amt) {
		return ceil($amt * 100) / 100;
	}
	public function getContents($url) {
		return json_decode(file_get_contents($url));
	}
	public function getRate($currency) {
		$r = json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);
		return (isset($r['rates'][$currency])) ? $r['rates'][$currency] : 0;
	}
	
	public function isEu($c) {
		$euCountryCodes = array(
			'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL',
			'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV',
			'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
		);	
		return (in_array($c, $euCountryCodes));
	}
	
}

$exam = new Exam();
$exam->loadJSON($argv[1]);
