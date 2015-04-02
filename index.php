<?php
	class something{
		public function sort(&$something){
			$t = microtime();
			sort($something);
			return microtime()-$t;
		}
		
		private function start_timer(){
			return microtime();
		}
		
		private function stop_timer($start){
			return microtime()-$start;
		}
		
		public function populate(&$something){
			$t = $this->start_timer();
			for($a = 0; $a < 100; ++$a){
				$something[] = rand(0,9000000000);
			}
			return $this->stop_timer()-$t;
		}
		
		public function traverse(&$something){
			$t = $this->start_timer();
			foreach($something as $f){
				//echo 'tsting';
			}
			return $this->stop_timer($t);
		}
		
		public function print_results(){
			echo '<table>';
			foreach($this->testResults as $k=>$p){
				echo '<tr>';
				echo '<td style="font-weight: bold;">'.ucwords(str_replace('_',' ',$k)).'</td><td>'.$p.'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	
	class info{
		var $testResults = array();
		var $something = array();
		
		public function __construct(){
			$this->testResults['setup'] = $this->populate();
			$this->testResults['array_traverse'] = $this->traverse();
			$t = $this->start_timer();
			sort($this->something);
			$this->testResults['sort'] = $this->stop_timer($t);
			$this->testResults['sort_traverse'] = $this->traverse();
			$this->print_results();
			
		}
		
		private function start_timer(){
			return microtime();
		}
		private function stop_timer($start){
			return microtime()-$start;
		}
		public function populate(){
			$t = $this->start_timer();
			for($a = 0; $a < 100; ++$a){
				$this->something[] = rand(0,90000000000000000000000000000000000000000000000000000);
			}
			return $this->stop_timer()-$t;
		}
		
		public function traverse(){
			$t = $this->start_timer();
			foreach($this->something as $f){
				//echo 'tsting';
			}
			return $this->stop_timer($t);
		}
		
		public function print_results(){
			echo '<table>';
			foreach($this->testResults as $k=>$p){
				echo '<tr>';
				echo '<td style="font-weight: bold; width: 200px">'.ucwords(str_replace('_',' ',$k)).'</td><td>'.$p.'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	
	echo '<h2>Class Results</h2>';
	$new = new info();

	function arrayTests(){
		$testResults = array();
		$something = array();
	
		$t = microtime();
		for($a = 0; $a < 100; ++$a){
			$something[] = rand(0,90000000000000000000000000000000000000000000000000000000000);
		}
		$l = microtime();
		
		$testResults['setup'] = $l-$t;
	
		$t = microtime();
		foreach($something as $f){
			//echo $f.'<br/>';
		}
		$l = microtime();
		
		$testResults['array_traverse'] = $l-$t;
	
		$t = microtime();
		sort($something);
		$l = microtime();
		
		$testResults['sort'] = $l-$t;
	
		$t = microtime();
		foreach($something as $f){
			//echo $f.'<br/>';
		}
		$l = microtime();
		
		$testResults['sort_traverse'] = $l-$t;
		return $testResults;
	}
	
	$testing = array();
	for($i = 0; $i < 10000; ++$i){
		$testing[] = arrayTests();
	}
	
	$sortaverage = array('setup'=>0,'array_traverse'=>0,'sort'=>0,'sort_traverse'=>0);
	foreach($testing as $k=>$a){
		$sortaverage['setup'] = ($a['setup']+$sortaverage['setup'])/$k;
		$sortaverage['array_traverse'] = ($a['array_traverse']+$sortaverage['array_traverse'])/$k;
		$sortaverage['sort'] = ($a['sort']+$sortaverage['sort'])/$k;
		$sortaverage['sort_traverse'] = ($a['sort_traverse']+$sortaverage['sort_traverse'])/$k;
	}
	
	unset($testing);
	
	echo '<h2>Procedural</h2>';
	
	echo '<table>';
	foreach($sortaverage as $k=>$f){
		echo '<tr>';
		echo '<td style="font-weight: bold; width: 200px;">'.ucwords(str_replace('_',' ',$k)).'</td><td>'.$f.'</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	echo '<h2>Class Prodedural</h2>';
	$something = array();
	$testing = new something();
	
	echo '<table>';
	echo '<tr><td style="width: 200px;"><strong>Setup</strong></td><td>'.$testing->populate($something).'</td></tr>';
	echo '<tr><td><strong>Array Traverse</strong></td><td>'.$testing->traverse($something).'</td></tr>';
	echo '<tr><td><strong>Something</strong></td><td>'.$testing->sort($something).'</td></tr>';
	echo '<tr><td><strong>Sort</strong></td><td>'.$testing->traverse($something).'</td></tr>';
	
	
	
	//print '<pre>'.print_r($sortaverage,true).'</pre>';
?>
