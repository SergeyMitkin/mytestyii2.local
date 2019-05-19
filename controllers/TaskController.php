<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 25.10.2018
 * Time: 20:41
 */
namespace app\controllers;

use app\models\FileUpload;
use app\models\filters\TasksFilter;
use app\models\tables\Comments;
use app\models\tables\Picture;
use app\models\tables\Tasks;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class TaskController extends Controller
{
   public function actionIndex()
   {
       $model = new Tasks();
       $monthId = \Yii::$app->request->post('Tasks')['changeMonth'];
       $prompt = $model->getChangeMonth()[$monthId];
       $params = [
           'prompt' => $prompt
       ];

       if($monthId == NULL || $monthId== "0")
       {
           $searchModel = new TasksFilter();
           $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

           return $this->render('index', [
               'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
               'model' => $model,
               'params' => $params
           ]);
       }else{
           $dataProvider = new ActiveDataProvider([
               'query' => Tasks::getByMonthQuery($monthId)
           ]);

           return $this->render('index', [
               'dataProvider' => $dataProvider,
               'model' => $model,
               'params' => $params
           ]);
       }
   }

    public function actionOne($id)
    {
        $taskData = Tasks::findOne($id);
        $taskName = $taskData->task_name;
        $taskDescription = $taskData->description;
        $userName = $taskData->userAccountable->login;
        $userManager = $taskData->userManager->login;
        $date = $taskData->dead_line;
        $taskId = $taskData->id;

        $model = new Comments();
        $dataProvider = new ActiveDataProvider([
            'query' => $model::getByTaskQuery($taskId),
        ]);
        $modelFileUpload = new FileUpload();

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            $model->save();

            $modelFileUpload->file = UploadedFile::getInstance($modelFileUpload, 'file');
            $fileName = $modelFileUpload->rus2translit($modelFileUpload->file->baseName . '.' . $modelFileUpload->file->extension);
            $modelFileUpload->uploadFile($fileName);

            $picture_source = $fileName;
            $picture_title = \Yii::$app->request->post()['Picture']['picture_title'];
            $picture_alt = $picture_title;
            $comment_id = $model->id;

            $pictureData = new Picture([
                'picture_title' => $picture_title,
                'picture_alt' => $picture_alt,
                'picture_source' => $picture_source,
                'comment_id' => $comment_id
            ]);
            $pictureData->save();

            return $this->redirect(\yii\helpers\Url::to(['task/one', 'id' => $id]));
        }

        return $this->render('task_item', [
            'taskName' => $taskName,
            'taskDescription' => $taskDescription,
            'userName' => $userName,
            'userManager' => $userManager,
            'date' => $date,
            'taskId' => $taskId,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelFileUpload' => $modelFileUpload,
        ]);
    }
}