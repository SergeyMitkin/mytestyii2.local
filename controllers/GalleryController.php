<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 29.03.2019
 * Time: 10:01
 */

namespace app\controllers;


use app\models\FileUpload;
use app\models\tables\Picture;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class GalleryController extends Controller
{

    public function actionIndex(){
        $model = new Picture();
        $query = Picture::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $modelFileUpload = new FileUpload();

        if(\Yii::$app->request->isPost){
            $modelFileUpload->file = UploadedFile::getInstance($modelFileUpload, 'file');
            $fileName = $modelFileUpload->rus2translit($modelFileUpload->file->baseName . '.' . $modelFileUpload->file->extension);
            $modelFileUpload->uploadFile($fileName);

            $picture_source = $fileName;
            $picture_title = \Yii::$app->request->post()['Picture']['picture_title'];
            $picture_alt = $picture_title;

            $pictureData = new Picture([
                'picture_title' => $picture_title,
                'picture_alt' => $picture_alt,
                'picture_source' => $picture_source
            ]);
            $pictureData->save();
            return $this->redirect(\yii\helpers\Url::to(['gallery/index']));
        }

        if(\Yii::$app->request->isGet){
            //return $this->redirect(\yii\helpers\Url::to(['gallery/index']));
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelFileUpload' => $modelFileUpload,
        ]);
    }

    public function actionOne($id){
        return $this->render('picture_item',[
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Picture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}