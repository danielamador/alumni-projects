<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 * - $representingColumn: the name of the representing column for the table (string) or
 *   the names of the representing columns (array)
 */
$relationColumns = array();
foreach(array_keys($relations) as $name): ?>
<?php 
    $relationData = $this->getRelationData($modelClass, $name);
    if ($relationData[0]== GxActiveRecord::BELONGS_TO) {
        $relationColumns[$relationData[3]] = $relationData[1];
    }
endforeach;
?>
<?php echo "<?php /* BeginFeature:{$modelClass} */"; ?>

/**
 * This is the model base class for the table "<?php echo $tableName; ?>".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "<?php echo $modelClass; ?>".
 *
 * Columns in table "<?php echo $tableName; ?>" available as properties of the model,
<?php if(!empty($relations)): ?>
 * followed by relations of table "<?php echo $tableName; ?>" available as properties of the model.
<?php else: ?>
 * and there are no model relations.
<?php endif; ?>
 *
<?php foreach($columns as $column): ?>
<?php if(isset($relationColumns[$column->name])){ ?>
 * BeginFeature:<?php echo "{$relationColumns[$column->name]}"; ?>    
<?php } ?>
 * @property <?php echo $column->type.' $'.$column->name; ?>
<?php if(isset($relationColumns[$column->name])){ 
        echo "\n";
?>
 * EndFeature:<?php echo "{$relationColumns[$column->name]}"; }?>    
<?php endforeach; ?>
 *
<?php foreach(array_keys($relations) as $name): ?>
<?php 
            $relationData = $this->getRelationData($modelClass, $name);
            $relationType = $relationData[0];
            $relationModel = $relationData[1];
?>
 * BeginFeature:<?php echo "{$relationModel}\n";
?>
 * @property <?php

	switch($relationType) {
		case GxActiveRecord::BELONGS_TO:
		case GxActiveRecord::HAS_ONE:                        
			echo $relationModel;
			break;
		case GxActiveRecord::HAS_MANY:
		case GxActiveRecord::MANY_MANY:
			echo $relationModel . '[]';
			break;
		default:
			echo 'mixed';
	}
	echo ' $' . $name . "\n";
	?>
 * EndFeature:<?php echo "{$relationModel}\n"; ?>
<?php endforeach; ?>
 */
abstract class <?php echo $this->baseModelClass; ?> extends <?php echo $this->baseClass; ?> {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '<?php echo $tableName; ?>';
	}

	public static function label($n = 1) {
		return Yii::t('app', '<?php echo $modelClass; ?>|<?php echo $this->pluralize($modelClass); ?>', $n);
	}

	public static function representingColumn() {
<?php if (is_array($representingColumn)): ?>
		return array(
<?php foreach($representingColumn as $representingColumn_item): ?>
			'<?php echo $representingColumn_item; ?>',
<?php endforeach; ?>
		);
<?php else: ?>
		return '<?php echo $representingColumn; ?>';
<?php endif; ?>
	}

	public function rules() {
		return array(
<?php
//FixMe: Rever último item, pois não tem vírgula
foreach($rules as $rule):
    foreach ($relationColumns as $key => $value) {
        $rule = str_replace("{$key}, ", "'.\n\t\t\t/* BeginFeature:{$value} */\n\t\t\t'{$key}, '.\n\t\t\t/* EndFeature:{$value} */\n\t\t\t'", $rule);
    }
    $rule = str_replace("''.", '', $rule);
    echo "\t\t\t{$rule},\n"; 
endforeach; 

$columnsSearch = implode(', ', array_keys($columns));
foreach ($relationColumns as $key => $value) {
    $columnsSearch = str_replace("{$key}, ", "'.\n\t\t\t/* BeginFeature:{$value} */\n\t\t\t'{$key}, '.\n\t\t\t/* EndFeature:{$value} */\n\t\t\t'", $columnsSearch);
}
$columnsSearch = str_replace("''.", '', $columnsSearch);

?>
			array('<?php echo $columnsSearch; ?>', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
<?php foreach($relations as $name=>$relation):
            $relationModel = $this->getRelationData($modelClass, $name)[1];
            $relationLabel[$name] = $relationModel;
?>
            <?php echo "\t\t/* BeginFeature:{$relationModel} */\n"; ?>
			<?php echo "'{$name}' => {$relation},\n"; ?>
            <?php echo "\t\t/* EndFeature:{$relationModel} */\n"; ?>
<?php endforeach; ?>
		);
	}

	public function pivotModels() {
		return array(
<?php foreach($pivotModels as $relationName=>$pivotModel): ?>
			<?php echo "'{$relationName}' => '{$pivotModel}',\n"; ?>
<?php endforeach; ?>
		);
	}

	public function attributeLabels() {
		return array(
<?php 
$relationlabels = CMap::mergeArray($relationLabel, $relationColumns);
foreach($labels as $name=>$label):
    if($label === null): 
        echo "\t\t\t/* BeginFeature:{$relationlabels[$name]} */\n";
        echo "\t\t\t'{$name}' => null,\n";
        echo "\t\t\t/* EndFeature:{$relationlabels[$name]} */\n"; 
    else: 
        echo "\t\t\t'{$name}' => {$label},\n";
    endif; 
endforeach; ?>
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

<?php foreach($columns as $name=>$column): ?>
<?php $partial = ($column->type==='string' and !$column->isForeignKey); 
 if (isset($relationColumns[$name])) {
     echo "\t\t/* BeginFeature:{$relationColumns[$name]} */\n";
 }
?>
		$criteria->compare('<?php echo $name; ?>', $this-><?php echo $name; ?><?php echo $partial ? ', true' : ''; ?>);
<?php 
 if (isset($relationColumns[$name])) {
     echo "\t\t/* EndFeature:{$relationColumns[$name]} */\n";
 }
endforeach; ?>

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
/* EndFeature:<?php echo $modelClass.' */';