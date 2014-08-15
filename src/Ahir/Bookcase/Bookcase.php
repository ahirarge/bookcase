<?php namespace Ahir\Bookcase;

use Exception;
use Pathman;
use Security\SecurityInterface;

class Bookcase {

	/**
	* Defer properties
	*/
	protected $defer = true;

	/**
	* Temp Name
	*/
	protected $newFileName = false;

	/**
	* File Size
	*/
	protected $fileSize = 0;

	/**
	 * Construct
	 *
	 * @param  SecurityInterface 	$fileSecurity
	 * @param  SecurityInterface 	$imageSecurity
	 * @return null
	 */
	public function __construct($fileSecurity, $imageSecurity)
	{
		$this->fileSecurity = $fileSecurity;
		$this->imageSecurity = $imageSecurity;
	}	

	/**
	* Security
	*
	* @param  string $params
	* @return boolean
	*/
	public function upload($params)
	{
		// Parametreler ayarlanır.
		try {
			$this->setParameters($params);
			// Gerekli dizinler ayarlanır.
			$this->checkPaths();
			// Dosya yüklenmiş mi kontrol edilir.
			$this->checkFile();
			// Dosya boyutu kontrolü
			$this->checkFileSize();
			// Yükleme zaman klasörleri oluşturulur.
			$this->libraryPath = Pathman::timeFolders($this->libraryPath);
			// Güvenlik doğrulamasından geçirilmesi işlemi.
			$this->copy();
			return $this->result();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	* Parameters are set
	*
	* @param  array $params
	* @return null
	*/
	protected function setParameters($params)
	{
		// Checking parameter count
		if (is_string($params)) {
			// Just one string params
			\Config::set('bookcase::input', $this->input);
		} else if (is_array($params)) {
			// All parameters are set
			foreach ($params as $key => $value) {
				\Config::set("bookcase::$key", $value);				
			}
		} else {
			// Wrond parameter exception
			throw new Exception($this->lang('wrongParameter'));
		}
	}	

	/**
	* Check Paths
	*
	* @return null
	*/
	protected function checkPaths()
	{
		# Paths settings
		$this->libraryPath = '../'.$this->config('libraryPath');
		$this->tempPath = $this->libraryPath.$this->config('tempPath');
		# Path configuration
		Pathman::set($this->libraryPath);
		Pathman::set($this->tempPath);
	}

	/**
	* Checking File 
	*
	* @return null
	*/
	protected function checkFile()
	{
		if (!\Input::hasFile($this->config('input'))) {
			throw new Exception($this->lang('fileNotUpload'));				
		}
	}

	/**
	* Checking File Size
	*
	* @return null
	*/
	public function checkFileSize()
	{
		$this->fileSize = \Input::file($this->config('input'))->getSize();
		if ($this->fileSize > $this->config('maxSize')) {
			throw new Exception(
					$this->lang('errorFileSize').
					$this->_sizeStr($this->config('maxSize'))
				);
		}
	}

	/**
	* Copy file
	*
	* @return null
	*/
	protected function copy()
	{
		// File temp path
		$file = \Input::file($this->config('input'));
		try {
			// Checking image status
			$stream = imagecreatefromstring(file_get_contents($file->getRealPath()));		
			// Yes, this is a image file.
			$this->fileType = 'jpg';
			$this->imageSecurity
				 ->control(
					$file, 
					$this->getName('jpg')
				 );
		} catch (Exception $e) {
			if (strpos($e->getMessage(), 'imagecreatefromstring') !== false) {
			} else {
				throw new Exception($e->getMessage());
			}
			// File Security
			$this->fileType = 'zip';
			$this->fileSecurity
				 ->control(
					$file, 
					$this->getName('zip')
				 );
		} 
	}

	/**
	* Result
	*
	* @return object
	*/
	public function result()
	{
		return (object) array(
				'type' => $this->fileType,
				'size' => $this->fileSize,
				'path' => str_replace('../public_html/', '', $this->getName())
			);
	}

	/**
	* Config
	*
	* @param  string $key
	* @return string
	*/
	protected function config($key)
	{
		return \Config::get("bookcase::$key");
	}

	/**
	* Lang
	*
	* @param  string $key
	* @return string
	*/
	protected function lang($key)
	{
		return \Lang::get("bookcase::lang.$key");
	}

	/**
	* Get Temp Tanem
	*
	* @param  $extension
	* @return string
	*/
	public function getName($extension = '')
	{
		if ($this->newFileName === false) {
			$this->newFileName = $this->libraryPath.md5(uniqid(rand(), true)).".$extension";
		}
		return $this->newFileName;
	}

	/**
	* Size Str
	*
	* @param  integer $bytes
	* @return string
	*/
	protected function _sizeStr($bytes)
	{
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' Byte';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' Byte';
        } else {
            $bytes = '0 Byte';
        }
        return $bytes;
	}

}