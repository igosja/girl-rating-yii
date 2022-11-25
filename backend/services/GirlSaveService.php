<?php
declare(strict_types=1);

namespace backend\services;

use common\interfaces\ExecutableInterface;
use common\models\Girl;
use yii\web\UploadedFile;

class GirlSaveService implements ExecutableInterface
{
    /**
     * @var Girl $model
     */
    private Girl $model;

    /**
     * @param Girl $model
     */
    public function __construct(Girl $model)
    {
        $this->model = $model;
    }

    public function execute():bool
    {
        $this->model->imageFile = UploadedFile::getInstance($this->model, 'imageFile');

        if (!$this->model->validate()) {
            return false;
        }

        return $this->saveModel() && $this->savePhoto();
    }

    /**
     * @return bool
     */
    private function saveModel(): bool
    {
        return $this->model->save();
    }

    /**
     * @return bool
     */
    private function savePhoto(): bool
    {
        if (!$this->model->imageFile) {
            return true;
        }

        return $this->deleteOldPhoto() && $this->saveNewPhoto();
    }

    /**
     * @return bool
     */
    private function deleteOldPhoto(): bool
    {
        if (file_exists($this->model->getFilePath())) {
            unlink($this->model->getFilePath());
        }
        return true;
    }

    /**
     * @return bool
     */
    private function saveNewPhoto(): bool
    {
        return $this->model->imageFile->saveAs($this->model->getFilePath());
    }
}