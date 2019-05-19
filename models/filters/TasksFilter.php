<?php

namespace app\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tables\Tasks;

/**
 * TasksFilter represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TasksFilter extends Tasks
{
    public $userManagerName;
    public $userAccountableName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['task_name', 'description', 'dead_line'], 'safe'],
            [['userManagerName', 'userAccountableName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tasks::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'task_name',
                'description',
                'dead_line',
                'userManagerName' => [
                    'asc' => ['man.login' => SORT_ASC],
                    'desc' => ['man.login' => SORT_DESC],
                    'label' => 'Manager'
                ],
                'userAccountableName' => [
                    'asc' => ['acc.login' => SORT_ASC],
                    'desc' => ['acc.login' => SORT_DESC],
                    'label' => 'Accountable'
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Users
             * для работы сортировки.
             */
            $query->joinWith(['userManager as man', 'userAccountable as acc']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query
            ->andFilterWhere([
                'tasks.id' => $this->id,
                'dead_line' => $this->dead_line,
            ]);
        $query
            ->andFilterWhere(['like', 'task_name', $this->task_name])
            ->andFilterWhere(['like', 'description', $this->description])
        ;

        $query->joinWith(['userManager as man' => function ($q) {
            $q->where('man.login LIKE "%' . $this->userManagerName . '%" ');
        },
                'userAccountable as acc' => function ($q) {
                $q->where('acc.login LIKE "%' . $this->userAccountableName . '%"');
            }
            ]);

       /*$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        return $dataProvider;
    }
}
