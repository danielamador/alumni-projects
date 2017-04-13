<?php /* BeginFeature:Manufacturer */
/**
 * This is the model base class for the table "manufacturer".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Manufacturer".
 *
 * Columns in table "manufacturer" available as properties of the model,
 * followed by relations of table "manufacturer" available as properties of the model.
 *
 * @property integer $id    
 * @property string $name    
 * @property integer $active    
 *
 * BeginFeature:VehicleModel
 * @property VehicleModel[] $vehicleModels
 * EndFeature:VehicleModel
 */
abstract class BaseManufacturer extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'manufacturer';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Manufacturer|Manufacturers', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('active', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
            		/* BeginFeature:VehicleModel */
			'vehicleModels' => array(self::HAS_MANY, 'VehicleModel', 'id_manufactorer'),
            		/* EndFeature:VehicleModel */
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'active' => Yii::t('app', 'Active'),
			/* BeginFeature:VehicleModel */
			'vehicleModels' => null,
			/* EndFeature:VehicleModel */
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
/* EndFeature:Manufacturer */