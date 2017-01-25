<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    public $startDate;
    public $endDate;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
            ['endDate','rangeDate'],
            [['startDate','endDate'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function rangeDate($attribute, $params)
    {
        $start_date = str_replace("-","",$this->startDate);
        $end_date = str_replace("-","",$this->endDate);
        
        $selisih =((abs(strtotime ($this->startDate) - strtotime ($this->endDate)))/(60*60*24));

        if ((int)$start_date > (int)$end_date) 
            $this->addError("startDate","Start Date Must be small then End Date");
        
        if ($selisih > 31) 
            $this->addError("endDate","Search report should only be up to 31 days");        
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchReport($params)
    {
        $query = <?=$searchModelClass?>::find();
        if (isset($params['<?=$searchModelClass?>'])) {
            $query = <?=$searchModelClass?>::find()->where(['between','last_update',$params['<?=$searchModelClass?>']['startDate'].' 00:00:00',$params['<?=$searchModelClass?>']['endDate'].' 23:59:59']);
        }
        else
            $query = <?=$searchModelClass?>::find()->where(['between','last_update','1970-01-01 00:00:00','1970-01-01 00:00:00 23:59:59']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        <?= implode("\n        ", $searchConditions) ?>

        return $dataProvider;
    }
}
