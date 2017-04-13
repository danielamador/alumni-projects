<?php /* BeginFeature:Line */
/**
 * This is the model base class for the table "line".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Line".
 *
 * Columns in table "line" available as properties of the model,
 * followed by relations of table "line" available as properties of the model.
 *
 * @property integer $id    
 * @property string $name    
 * BeginFeature:Station    
 * @property integer $id_station_departure
 * EndFeature:Station    
 * BeginFeature:Station    
 * @property integer $id_station_arrival
 * EndFeature:Station    
 * @property integer $active    
 *
 * BeginFeature:Station
 * @property Station $idStationArrival
 * EndFeature:Station
 * BeginFeature:Station
 * @property Station $idStationDeparture
 * EndFeature:Station
 * BeginFeature:Segment
 * @property Segment[] $segments
 * EndFeature:Segment
 * BeginFeature:Travel
 * @property Travel[] $travels
 * EndFeature:Travel
 */
abstract class BaseLine extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'line';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Line|Lines', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, '.
			/* BeginFeature:Station */
			'id_station_departure, '.
			/* EndFeature:Station */
			'id_station_arrival', 'required'),
			array(
			/* BeginFeature:Station */
			'id_station_departure, '.
			/* EndFeature:Station */
			
			/* BeginFeature:Station */
			'id_station_arrival, '.
			/* EndFeature:Station */
			'active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('active', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, '.
			/* BeginFeature:Station */
			'id_station_departure, '.
			/* EndFeature:Station */
			
			/* BeginFeature:Station */
			'id_station_arrival, '.
			/* EndFeature:Station */
			'active', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
            		/* BeginFeature:Station */
			'idStationArrival' => array(self::BELONGS_TO, 'Station', 'id_station_arrival'),
            		/* EndFeature:Station */
            		/* BeginFeature:Station */
			'idStationDeparture' => array(self::BELONGS_TO, 'Station', 'id_station_departure'),
            		/* EndFeature:Station */
            		/* BeginFeature:Segment */
			'segments' => array(self::HAS_MANY, 'Segment', 'id_line'),
            		/* EndFeature:Segment */
            		/* BeginFeature:Travel */
			'travels' => array(self::HAS_MANY, 'Travel', 'id_line'),
            		/* EndFeature:Travel */
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
			/* BeginFeature:Station */
			'id_station_departure' => null,
			/* EndFeature:Station */
			/* BeginFeature:Station */
			'id_station_arrival' => null,
			/* EndFeature:Station */
			'active' => Yii::t('app', 'Active'),
			/* BeginFeature:Station */
			'idStationArrival' => null,
			/* EndFeature:Station */
			/* BeginFeature:Station */
			'idStationDeparture' => null,
			/* EndFeature:Station */
			/* BeginFeature:Segment */
			'segments' => null,
			/* EndFeature:Segment */
			/* BeginFeature:Travel */
			'travels' => null,
			/* EndFeature:Travel */
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		/* BeginFeature:Station */
		$criteria->compare('id_station_departure', $this->id_station_departure);
		/* EndFeature:Station */
		/* BeginFeature:Station */
		$criteria->compare('id_station_arrival', $this->id_station_arrival);
		/* EndFeature:Station */
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
/* EndFeature:Line */