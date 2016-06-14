<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormCSV extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }
    
    public function upload()
    {
     
            $this->csvFile->saveAs('uploadscsv/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
			
     }
	public function save()
	{
		return true;
	}
}
?>

