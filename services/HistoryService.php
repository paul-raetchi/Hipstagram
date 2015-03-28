<?php
require_once ('ProcessingService.php');

class HistoryService{
	public $access_token = '43588672.6acf407.51e35be17cf94965a6509ecdd092ea3e';
	public $api_search = 'https://api.instagram.com/v1/media/search';
    private $db;
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
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $database = "hipstagram";
        $dbport = 3306;
        
        // Create connection
        $this->db = new mysqli($servername, $username, $password, $database, $dbport);
        
        // Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        } 
        echo "Connected successfully (".$this->db->host_info.")";
	}

	private function push($data){
	    if (count($data) == 0) 
	        return false;
	        
		foreach ($data as $im){
		    $proc = new ProcessingService('pics/sample-image1.jpg');
            $result = $proc->process();
            if ($result == false) {
                continue;
            }
		    $datetime = date('Y-m-d H:i:s', $im['time']);
		    mysqli_query($this->db,"INSERT INTO bigdata 
		            (`date`,`location`,`image`,`white`,`black`,`navyblue`,`green`,`red`,`darkred`,`purple`,`orange`,`yellow`,`limegreen`,`teal`,`aqualight`,`royalblue`,`hotpink`,`darkgrey`,`lightgrey`,`likes`) 
             VALUES ('$datetime', '{$im['city']}' , '{$im['url']}' , '{$im['white']}','{$im['black']}','{$im['navyblue']}','{$im['green']}','{$im['red']}','{$im['darkred']}','{$im['purple']}','{$im['orange']}','{$im['yellow']}','{$im['limegreen']}','{$im['teal']}','{$im['aqualight']}','{$im['royalblue']}','{$im['hotpink']}','{$im['darkgrey']}','{$im['lightgrey']}' ,'{$im['likes']}' )");
		    
		}
	}

	public function feed($city,$from,$to){
		if (!isset($this->city[$city]))
			 return false;

        $data = array('run');
        $break_after = 600;
        $should_i_break = 0;
		while ($from<$to && count($data)>0) {
			$nice_to = date('Y-m-d H:i:s', $to);
			$data = $this->getFromAPI($city,$to);
			//do something with it
			
			$time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $start = $time;

			echo "Batch of ".count($data)." found.($nice_to) \n";
			$this->push($data); 
			
			$time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 4);
			echo "Batch finished after $total_time \n";
			$should_i_break += $total_time;
			if($should_i_break>$break_after)
			    {
			        echo "Well the 10 minutes of fame passed.BREAK! \n";
			        break;
			    }
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
