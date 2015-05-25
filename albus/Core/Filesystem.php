<?php

namespace albus\Core;

class Filesystem {

	// default path to save/retrieve files
	private $path = ROOT.DS.'albus'.DS.'files';
	private $errorMessage;

	public function __construct() {

	}
	/**
	 * Description
	 * @param String $path full path to save/retrieve files
	 * @return void
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	/**
	 * Description
	 * @param String $name input name of file (<input name="$name">) 
	 * @return String saved filename
	 * TODO: implement maxsize
	 */
	public function saveImage($name, $maxsize = null) {

		// Check file upload
		if(!isset($_FILES[$name])) {
			$this->errorMessage = 'No image data passed';
			return false;
		}else if ($_FILES[$name]['error'][1]) {
			$this->errorMessage = 'Max image size is 6MB';
			return false;
		}else if($_FILES[$name]['error']) {
			$this->errorMessage = 'An error occured';
			return false;
		}

		if(!$this->isImage($name)) {
			$this->errorMessage = 'Not an image file';
			return false;
		}

		// save file with generated name
		$filename =  $this->genFilename();
		$this->save($name, $filename);

		// return newly filename
		return $filename;
	}

	public function getFile($filename) {
		$full_filename = $this->path.DS.$filename;
		if(file_exists($full_filename))
			return file_get_contents($full_filename);
		else
			return false;
	}

	public function getMessage() {
		return $this->errorMessage;
	}

	private function save($name, $filename) {
		move_uploaded_file($_FILES[$name]["tmp_name"], $this->path.DS.$filename); // IMAGE
	}

	private function isImage($file) {
		return getimagesize($_FILES[$file]["tmp_name"]); // IMAGE
	}

	private function genFilename($size = 16) {
		// Generate random filename until a unique filename is generated
		do {
			// Generate random filename
			do {
				$bytes = openssl_random_pseudo_bytes($size, $cstrong);
			} while(!$cstrong);
			$filename = bin2hex($bytes);

		}while($this->fileExists($filename));

		return $filename;
	}

	private function fileExists($filename) {
		return file_exists($this->path.DS.$filename);
	}

}