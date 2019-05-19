<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 25.10.2018
 * Time: 20:41
 */
namespace app\controllers;

use app\models\tables\Comments;
use app\models\tables\Picture;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class CommentController extends Controller{

    public function actionOne($id)
    {
        $commentData = Comments::findOne($id);
        $commentId = $commentData->id;
        $userName = $commentData->user->login;
        $commentText = $commentData->comment_text;

        $model = new Picture();
        $dataProvider = new ActiveDataProvider([
            'query' => $model::getByCommentQuery($commentId)
        ]);

        return $this->render('comment_item', [
           'userName' => $userName,
           'commentText' => $commentText,
           'dataProvider' => $dataProvider
        ]);
    }
}