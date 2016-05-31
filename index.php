<?php
	class FPGrowth
	{
		public $frequentItem;
		public $minimumSupportCount;
		public $minConfidence;
		public $supportCount;
		public $orderedFrequentItem;
		public $FPTree;

		function __construct()
		{
			$this->frequentItem = array();
			$this->minimumSupportCount = 3;
			$this->minConfidence = 60 * 0.01;
			$this->supportCount 	= array();
			$this->orderedFrequentItem = array();
		}

		/*
		*input array of frequent pattern
		*/
		public function set($t)
		{
			if(is_array($t))
			{
				$this->frequentItem[] 	= $t;
			}
		}

		public function get()
		{
			echo "<pre>";
			print_r($this->frequentItem);
			echo "</pre>";
		}

		public function getFrequentItem()
		{
			echo "<pre>";
			print_r($this->frequentItem);
			echo "</pre>";
		}

		public function orderFrequentItem($frequentItem, $supportCount)
		{
			foreach ($frequentItem as $k => $v) {
				$ordered 	= array();
				foreach ($supportCount as $key => $value) {
					if(isset($v[$key]))
					{
						$ordered[$key]	= $v[$key];
					}
				}
				$this->orderedFrequentItem[$k]	= $ordered;
			}
		}

		public function getOrderedFrequentItem()
		{
			echo "<pre>";
			print_r($this->orderedFrequentItem);
			echo "</pre>";
		}

		public function countSupportCount()
		{
			if(is_array($this->frequentItem))
			{
				foreach ($this->frequentItem as $key => $value) {
					if(is_array($value))
					{
						foreach ($value as $k => $v) {
							if (empty($this->supportCount[$v])) {
								$this->supportCount[$v] = 1;
							}else{
								$this->supportCount[$v] = $this->supportCount[$v] + 1;
							}
						}
					}
				}
			}
		}

		public function getSupportCount()
		{
			echo "<pre>";
			print_r($this->supportCount);
			echo "</pre>";
		}

		public function orderBySupportCount()
		{
			ksort($this->supportCount);
			arsort($this->supportCount);
		}

		public function removeByMinimumSupport($supportCount)
		{
			if(is_array($supportCount))
			{
				$this->supportCount = array();
				foreach ($supportCount as $key => $value) {
					if ($value >= $this->minimumSupportCount)
					{
						$this->supportCount[$key] = $value;
					}
				}
			}
		}

		/* struktur array
		* item  : (I1, I2, dst)
		* count : (2, 3, 4)
		* child : (next array)
		*/
		public function buildFPTree($orderedFrequentItem)
		{
			$FPTree[] 	= array(
				'item'	=> 'null',
				'count'	=> 0,
				'child'	=> null,
			);
			$FPTree2[] 	= array();
			if(is_array($orderedFrequentItem))
			{
				$i 	= 0;
				foreach ($orderedFrequentItem as $orderedFrequentItemKey => $orderedFrequentItemValue) {
					// inisiasi ke FPTree 0 // save key FPTree sementara
					$FPTreeTemp 	= $FPTree[0];
					$FPTreeTempKey 	= array(0);

					foreach ($orderedFrequentItemValue as $itemKey => $itemValue) {
						// add key FPTree sementara
						array_push($FPTreeTempKey, $itemValue);
						
						// insert tree ke FPTree
						switch ((count($FPTreeTempKey))) {
							case 2:
								if(empty($FPTree[0]['child'][$itemValue]))
								{
									$FPTree[0]['child'][$itemValue] 	= array(
										'item'	=> $itemValue,
										'count'	=> 1,
										'child'	=> null,
									);
								}else{
									$FPTree[0]['child'][$itemValue]['count'] = $FPTree[0]['child'][$itemValue]['count'] + 1;
								}
								break;

							case 3:
								if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]))
								{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue] 	= array(
										'item'	=> $itemValue,
										'count'	=> 1,
										'child'	=> null,
									);
								}else{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] + 1;
								}
								break;

							case 4:
								if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]))
								{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue] 	= array(
										'item'	=> $itemValue,
										'count'	=> 1,
										'child'	=> null,
									);
								}else{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] + 1;
								}
								break;

							case 5:
								if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]))
								{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue] 	= array(
										'item'	=> $itemValue,
										'count'	=> 1,
										'child'	=> null,
									);
								}else{
									$FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] + 1;
								}
								break;
							
							default:
								
								break;
						}
					}
				}
			}
			return $FPTree;
		}

		public function getFPTree()
		{
			echo "<pre>";
			print_r($this->FPTree);
			echo "</pre>";
		}

	}

	$t1 	= array('I1'=>'I1', 'I2' =>'I2', 'I5' =>'I5');
	$t2 	= array('I2'=>'I2', 'I4'=>'I4');
	$t3 	= array('I2'=>'I2' ,'I3'=>'I3');
	$t4 	= array('I1'=>'I1', 'I2'=>'I2', 'I4'=>'I4');
	$t5 	= array('I1'=>'I1', 'I3'=>'I3');
	$t6 	= array('I2'=>'I2', 'I3'=>'I3');
	$t7 	= array('I1'=>'I1', 'I3'=>'I3');
	$t8 	= array('I1'=>'I1', 'I2'=>'I2', 'I3'=>'I3', 'I5'=>'I5');
	$t9 	= array('I1'=>'I1', 'I2'=>'I2', 'I3'=>'I3');

	$fpgrowth 	= new FPGrowth();
	// Input transaction / frequent 1-item
	$fpgrowth->set($t1);
	$fpgrowth->set($t2);
	$fpgrowth->set($t3);
	$fpgrowth->set($t4);
	$fpgrowth->set($t5);
	$fpgrowth->set($t6);
	$fpgrowth->set($t7);
	$fpgrowth->set($t8);
	$fpgrowth->set($t9);
	// Menampilkan frequent 1-item
	echo "Output Frequent 1-item : ";
	$fpgrowth->get();
	// Menghitung support count untuk setiap item
	$fpgrowth->countSupportCount();
	// Menampilkan item support count
	echo "Item | Support Count not ordered";
	$fpgrowth->getSupportCount();
	// Mengurutkan item by support count
	$fpgrowth->orderBySupportCount();
	echo "Item | Support Count ordered";
	$fpgrowth->getSupportCount();
	$fpgrowth->removeByMinimumSupport($fpgrowth->supportCount);
	echo "Item | Support Count remove support count < minimum support count";
	$fpgrowth->getSupportCount();
	// Mengurutkan frequent 1-item berdasarkan support count 
	// dan menghilangkan item dengan support count kurang dari minimum support count
	$fpgrowth->orderFrequentItem($fpgrowth->frequentItem, $fpgrowth->supportCount);
	// Menampilkan urutan tampilan berdasarkan support count
	echo "Output Frequent 1-item ordered by support count on each item";
	$fpgrowth->getOrderedFrequentItem();
	echo "FP Tree result dislpay in array";
	$fpgrowth->FPTree 	= $fpgrowth->buildFPTree($fpgrowth->orderedFrequentItem);
	$fpgrowth->getFPTree();
?>