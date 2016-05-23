<?php
namespace third;

/**
 * @package Uploader
 *    CLASS:            UPLOAD
 *    VERSION:        1.0
 *    DESCRIPTIONS:    This class upload and resize images.
 *    class can upload and resize multiple images in array form or can upload and resize single image.
 *    AUTHOR:            OBAIDULLAH KHAN
 *    EMAIL:            UBAID23@GMAIL.COM
 *    WEB:            HTTP://WWW.MYHUJRA.COM
 *    COUNTRY:        PAKISTAN
 *    LICENCE:        GNU/GPL

 */
class acuploader
{
	public $FileName;
	public $NewName;
	public $File;
	public $NewWidth = 600;
	public $NewHeight = 450;
	public $TWidth = 100;
	public $THeight = 100;
	public $SavePath;
	public $ThumbPath;
	public $OverWrite;
	public $NameCase;

	private $Image;
	private $width;
	private $height;
	private $Error;

	function __construct()
	{
		$this->FileName = 'lssll.jpg';
		$this->OverWrite = true;
		$this->NameCase = '';
		$this->Error = '';
		$this->NewName = '';
	}

	function UploadFile()
	{
		#die(print_r($this)); die();
		if(is_array($this->File['name']))
		{
			$this->_ArrayUpload();
		}
		else
		{
			$this->_NormalUpload();
		}

		return $this->Error;
	}

	/**
	 * @todo Check and remove
	 */
	function patch($filename = 'YYYYMMDDHHIISSXXXX', $record_id = 0)
	{
		$record_id = (int)$record_id;

		#$image_path = str_replace(PROPERTY_LOCATION, '', "{$this->destination_url}/{$filename}");
		#$image_path = str_replace(__SUBDOMAIN_BASE__, '', "{$this->destination_url}/{$record_id}/{$filename}");
		$image_path = str_replace(__SUBDOMAIN_BASE__, '', "pictures/{$record_id}/{$filename}");
		$patch_sql = "
UPDATE mhe_property_photos SET
	#photo_path='{$photo_path}'
	photo_path=CONCAT('pictures/', property_id, '/', photo_id, '/$filename') 
WHERE
	photo_id={$record_id}
;";
		#print_r($this);
		#die($patch_sql);
		mysql_query($patch_sql);
	}


	function _ArrayUpload()
	{
		for($i = 0; $i < count($this->File['name']); $i++)
		{
			$_FileName = $this->File['name'][$i];

			//if new name is set then apply this.

			$_NewName = $this->NewName[$i];


			if(!empty($this->File['name'][$i]) and $this->_FileExist($_NewName, $_FileName) == false)
			{
				//Upload and resize image
				$this->_UploadImage($this->File['name'][$i], $this->File['tmp_name'][$i], $this->File['size'][$i],
					$this->File['type'][$i], $this->NewName[$i]);

				//==== Creaet Thumb
				if(!empty($this->ThumbPath))
				{
					$this->_ThumbUpload($this->File['name'][$i], $this->File['tmp_name'][$i], $this->File['size'][$i],
						$this->File['type'][$i], $this->NewName[$i]);
				}
				// if save thumb

			}
			//if !empty file name
		}
		//for loop
	}

	function _NormalUpload()
	{
		$_FileName = $this->File['name'];
		//if new name is set then apply this.
		$_NewName = $this->NewName;

		if(!empty($this->File['name']) and $this->_FileExist($_NewName, $_FileName) == false)
		{
			//upload and resize image
			$this->_UploadImage($this->File['name'], $this->File['tmp_name'], $this->File['size'],
				$this->File['type'], $this->NewName);

			//upload thumb
			if(!empty($this->ThumbPath))
			{
				$this->_ThumbUpload($this->File['name'], $this->File['tmp_name'], $this->File['size'],
					$this->File['type'], $this->NewName);
			}
			// if save thumb
		}
		// if check file empty and file exist
	} // function _Normal Upload

	function _UploadImage($FileName, $TmpName, $Size, $Type, $NewName)
	{
		list($width, $height) = getimagesize($TmpName);
		$this->image = new imageresizer($FileName);

		$this->image->newWidth = $this->NewWidth; // new width
		$this->image->newHeight = $this->NewHeight; //new height

		$this->image->PicDir = $this->SavePath;
		$this->image->TmpName = $TmpName;
		$this->image->FileSize = $Size;
		$this->image->FileType = $Type;

		//if user want to change the file name checkname function will do that.
		$this->image->FileName = $this->_CheckName($NewName, $FileName);

		if($width < $this->NewWidth and $height < $this->NewHeight)
		{
			$this->image->Save(); //use this if you wish images without resizing
		}
		else
		{
			$this->image->Resize();
		}
	}

	function _ThumbUpload($FileName, $TmpName, $Size, $Type, $NewName)
	{
		list($width, $height) = getimagesize($TmpName);

		$this->Timage = new imageresizer($FileName);

		$this->Timage->newWidth = $this->TWidth; // new width
		$this->Timage->newHeight = $this->THeight; //new height

		$this->Timage->PicDir = $this->ThumbPath;
		$this->Timage->TmpName = $TmpName;
		$this->Timage->FileSize = $Size;
		$this->Timage->FileType = $Type;

		//if user want to change the file name chackname function will do that.
		$this->Timage->FileName = $this->_CheckName($NewName, $FileName);

		if($width < $this->TWidth and $height < $this->THeight)
		{
			$this->Timage->Save(); //use this if you wish images without resizing
		}
		else
		{
			$this->Timage->Resize();
		}
	}

	function _CheckName($NewName, $UpFile)
	{
		$NewName = preg_replace('/[ %&!@#$^\(\)\{\}\[\],;))]+/', '_', $NewName);

		if(empty($NewName))
		{
			return $this->_ChangeCase($UpFile);
		}
		else
		{
			$Ext = explode(".", $UpFile);
			$Ext = end($Ext);
			$Ext = strtolower($Ext);

			return $this->_ChangeCase($NewName);
		}
	}

	function _ChangeCase($FileName)
	{
		if($this->NameCase == 'lower')
		{
			return strtolower($FileName);
		}
		elseif($this->NameCase == 'upper')
		{
			return strtoupper($FileName);
		}
		else
		{
			return $FileName;
		}
	}

	function _FileExist($_NewName, $_FileName)
	{
		if($this->OverWrite === true)
		{
			if(file_exists($this->SavePath . $this->_CheckName($_NewName, $_FileName)))
			{
				if(!unlink($this->SavePath . $this->_CheckName($_NewName, $_FileName)))
				{
					$this->Error[] = "File: " . _CheckName($_NewName, $_FileName) . " Cannot be overwrite.";
				}
				else
				{
					if(file_exists($this->ThumbPath . $this->_CheckName($_NewName, $_FileName)))
					{
						//also remove thumb
						unlink($this->ThumbPath . $this->_CheckName($_NewName, $_FileName));
					}
				}
			}
		}
		else
		{
			if(file_exists($this->_CheckName($_NewName, $_FileName)))
			{
				$this->Error[] = "File: " . _CheckName($_NewName, $_FileName) . " aready exist";

				return true;
			}
		}
	}
	//function _FileExist
}
