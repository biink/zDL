<?php

require(__DIR__ . '/common/utils.php');

class ZDL {

	private $downloads;
	private $downloads_file;
	private $regdownloads;

	public function __construct() {
		$this->config_file = __DIR__ . '/config.json';
		
		$this->downloads      = array();
		$this->downloads_file = __DIR__ . '/data/downloads.json';
		$this->regdownloads = json_decode(file_get_contents($this->downloads_file));
		$this->config = json_decode(file_get_contents($this->config_file));
	}
	
	public function download( $downloadName, $filename ) {
		$sc =  array(' ');
		$rsc = array('-');
		$dltemplate = array(
			'dlname'     => $downloadName,
			'dlname_nsc' => str_replace($sc, $rsc, rmAccents($downloadName)),
			'location'   => $filename
		);
		// Insert download in array
		array_push($this->downloads, $dltemplate);
		// Insert download JSON file
		$this->saveDownload($dltemplate);
	}

	private function saveDownload($downloadtemplate) {
		// Check for existing download
		$dl_exists = false;
		foreach($this->regdownloads->downloads as $download) {
			if(isset($download->dlname) && $download->dlname == $downloadtemplate['dlname'])
				$dl_exists = true;
		}
		if(!$dl_exists)
			array_push($this->regdownloads->downloads, $downloadtemplate);
		
		// Write in the JSON data file
		$file_hdl = fopen($this->downloads_file, 'w');
		fwrite($file_hdl, json_encode($this->regdownloads, JSON_PRETTY_PRINT));
		fclose($file_hdl);
	}

	public function getLink( $downloadName ) {
		foreach ($this->downloads as $dl) {
			if($dl['dlname'] == $downloadName) {
				if(!$this->config->urlrewrite)
					$link = '?download=' . $dl['dlname_nsc'];

				return $link;
			} else {
				throw new Exception('<strong>' . $downloadName . '</strong> doesn\'t match to any download name');
			}
		}
	}

	public function checkForDownload() {
		if(isset($_GET['download'])) {
			foreach ($this->regdownloads->downloads as $download) {
				if($download->dlname_nsc == $_GET['download']) {
					$this->forceDownload($download->location);
				}
			}
		}
	}

	private function forceDownload( $file ) {
		$size = filesize(basename($file)); 
		header('Content-Type: application/force-download; name="' . basename($file) . '"'); 
		header('Content-Transfer-Encoding: binary'); 
		header('Content-Length:' . $size); 
		header('Content-Disposition: attachment; filename="' . basename($file) . '"'); 
		header('Expires: 0'); 
		header('Cache-Control: no-cache, must-revalidate'); 
		header('Pragma: no-cache'); 
		readfile(basename($file)); 
		exit(); 
	}

}