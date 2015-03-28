<?php

class HistoryService{
	public $access_token = '43588672.6acf407.51e35be17cf94965a6509ecdd092ea3e';
	public $api_search = 'https://api.instagram.com/v1/media/search';

	public $city = array(
		"bucuresti" => array(
				"lat"=> 44.4268,
				"lng"=> 26.1025
			)
		);
	
	public function HistoryService(){

	}

	private function push($data){
		echo "<Hr><pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function feed($city,$from,$to){
		if (!isset($this->city[$city]))
			 return false;

		while ($from<$to) {
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
		return $this->prepare($data);
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

	private function prepare(&$feed){
		$data = array();

		foreach ($feed->data as $media){
			$data[] = array(
					'likes' => $media->likes->count,
					'media_url' => $media->images->standard_resolution->url,
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

