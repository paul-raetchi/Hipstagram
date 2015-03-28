<?php

class HistoryService{
	public $access_token = '43588672.6acf407.51e35be17cf94965a6509ecdd092ea3e';
	public $api_search = 'https://api.instagram.com/v1/media/search';

	public $city = array(
		"bucuresti"   => array(
		        "id"  => 1,
				"lat" => 44.4268,
				"lng" => 26.1025
			    ),
		'cluj'        => array(
		        "id"  => 2,
		        "lat" => 46.7667,
		        "lng" => 23.5833 
		        ),
		 'timisoara'  => array(
		        "id"  => 3,
		        "lat" => 45.7597,
		        "lng" => 21.2300
		        )
		);
	
	public function HistoryService(){

	}

	private function push($data){
	    if (count($data) == 0) 
	        return false;
	        
		foreach ($data as $im){
		    //echo "<img src='{$im['url']}' style='width:300px;height:300px;margin-right:5px;margin-bottom:5px;' />";
		}
	}

	public function feed($city,$from,$to){
		if (!isset($this->city[$city]))
			 return false;

        $data = array('run');
           
		while ($from<$to && count($data)>0) {
			$data = $this->getFromAPI($city,$to);
			//do something with it
			$this->push($data); 
		}
	}

	private function getFromAPI($city,&$timestamp){

		$query = array();
		$query['access_token'] 	= $this->access_token;
		$query['lat'] 			= $this->city[$city]['lat'];
		$query['lng'] 			= $this->city[$city]['lng'];

		if($timestamp !== false){
			$query['max_timestamp'] = $timestamp;
		} 

		$query_str = http_build_query($query);

		$raw = file_get_contents($this->api_search."?".$query_str);
		$data = json_decode($raw);

		$this->discard($data,$timestamp);
		return $this->prepare($data,$city);
	}

	private function discard(&$feed,&$timestamp){
		$i = 0;
		while (is_array($feed->data) && $i<count($feed->data)){

			//update timestamp
			if ($feed->data[$i]->created_time < $timestamp || $timestamp === false){
				$timestamp = $feed->data[$i]->created_time;
			}

			//discard filtered & videos
			if ($feed->data[$i]->filter == "Normal" && $feed->data[$i]->type == "image"){
				$i++;
			} else {
				array_splice($feed->data,$i,1);
			}

		}
	}

	private function prepare(&$feed,$city){
		$data = array();

		foreach ($feed->data as $media){
			$data[] = array(
			        'city' => $this->city[$city]['id'],
			        'time' => $media->created_time,
					'likes' => $media->likes->count,
					'url' => $media->images->standard_resolution->url,
			);
		}
		return $data; 
	}



}

/*
$hf = new HistoryService();

$yesterday = time() - (1 * 24 * 60 * 60); 
$today_3_hours_ago = time() - (3 *60*60);
$today = time(); 


$hf->feed('bucuresti',$today_3_hours_ago,$today);
*/

