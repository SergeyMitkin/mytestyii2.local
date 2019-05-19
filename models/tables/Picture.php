<?php

namespace app\models\tables;

/**
 * This is the model class for table "picture".
 *
 * @property int $id
 * @property string $picture_source
 * @property string $picture_title
 * @property string $picture_alt
 * @property int $comment_id
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picture_source', 'picture_title', 'picture_alt'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture_source' => 'Picture Source',
            'picture_title' => 'Picture Title',
            'picture_alt' => 'Picture Alt',
        ];
    }

    public static function getByCommentQuery($id){
        return static::find()
            ->where(['comment_id' => $id]);
    }
}
