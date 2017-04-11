<?php /* BeginFeature:Vehicle */
/**
 * This is the model base class for the table "vehicle".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Vehicle".
 *
 * Columns in table "vehicle" available as properties of the model,
 * followed by relations of table "vehicle" available as properties of the model.
 *
 * @property integer $id    
 * @property string $code    
 * BeginFeature:VehicleType    
 * @property integer $id_vehicle_type
 * EndFeature:VehicleType    
 * BeginFeature:VehicleModel    
 * @property integer $id_vehicle_model
 * EndFeature:VehicleModel    
 * @property integer $capacity    
 * @property integer $active    
 * @property string $manufacturing_year    
 * @property double $fuel_capacity    
 * @property string $color    
 * @property string $bus_plate    
 * @property double $plane_true_airspeed_knots    
 * @property integer $plane_cruising_altitude    
 *
 * BeginFeature:Travel
 * @property Travel[] $travels
 * EndFeature:Travel
 * BeginFeature:VehicleModel
 * @property VehicleModel $idVehicleModel
 * EndFeature:VehicleModel
 * BeginFeature:VehicleType
 * @property VehicleType $idVehicleType
 * EndFeature:VehicleType
 * BeginFeature:VehicleSeat
 * @property VehicleSeat[] $vehicleSeats
 * EndFeature:VehicleSeat
 */
abstract class BaseVehicle extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vehicle';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Vehicle|Vehicles', $n);
	}

	public static function representingColumn() {
		return 'code';
	}

	public function rules() {
		return array(
			array('code, '.
			/* BeginFeature:VehicleType */
			'id_vehicle_type, '.
			/* EndFeature:VehicleType */
			'capacity', 'required'),
			array(
			/* BeginFeature:VehicleType */
			'id_vehicle_type, '.
			/* EndFeature:VehicleType */
			
			/* BeginFeature:VehicleModel */
			'id_vehicle_model, '.
			/* EndFeature:VehicleModel */
			'capacity, active, plane_cruising_altitude', 'numerical', 'integerOnly'=>true),
			array('fuel_capacity, plane_true_airspeed_knots', 'numerical'),
			array('code, color', 'length', 'max'=>45),
			array('manufacturing_year', 'length', 'max'=>4),
			array('bus_plate', 'length', 'max'=>20),
			array(
			/* BeginFeature:VehicleModel */
			'id_vehicle_model, '.
			/* EndFeature:VehicleModel */
			'active, manufacturing_year, fuel_capacity, color, bus_plate, plane_true_airspeed_knots, plane_cruising_altitude', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, code, '.
			/* BeginFeature:VehicleType */
			'id_vehicle_type, '.
			/* EndFeature:VehicleType */
			
			/* BeginFeature:VehicleModel */
			'id_vehicle_model, '.
			/* EndFeature:VehicleModel */
			'capacity, active, manufacturing_year, fuel_capacity, color, bus_plate, plane_true_airspeed_knots, plane_cruising_altitude', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
            		/* BeginFeature:Travel */
			'travels' => array(self::HAS_MANY, 'Travel', 'id_vehicle'),
            		/* EndFeature:Travel */
            		/* BeginFeature:VehicleModel */
			'idVehicleModel' => array(self::BELONGS_TO, 'VehicleModel', 'id_vehicle_model'),
            		/* EndFeature:VehicleModel */
            		/* BeginFeature:VehicleType */
			'idVehicleType' => array(self::BELONGS_TO, 'VehicleType', 'id_vehicle_type'),
            		/* EndFeature:VehicleType */
            		/* BeginFeature:VehicleSeat */
			'vehicleSeats' => array(self::HAS_MANY, 'VehicleSeat', 'id_vehicle'),
            		/* EndFeature:VehicleSeat */
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'code' => Yii::t('app', 'Code'),
			/* BeginFeature:VehicleType */
			'id_vehicle_type' => null,
			/* EndFeature:VehicleType */
			/* BeginFeature:VehicleModel */
			'id_vehicle_model' => null,
			/* EndFeature:VehicleModel */
			'capacity' => Yii::t('app', 'Capacity'),
			'active' => Yii::t('app', 'Active'),
			'manufacturing_year' => Yii::t('app', 'Manufacturing Year'),
			'fuel_capacity' => Yii::t('app', 'Fuel Capacity'),
			'color' => Yii::t('app', 'Color'),
			'bus_plate' => Yii::t('app', 'Bus Plate'),
			'plane_true_airspeed_knots' => Yii::t('app', 'Plane True Airspeed Knots'),
			'plane_cruising_altitude' => Yii::t('app', 'Plane Cruising Altitude'),
			/* BeginFeature:Travel */
			'travels' => null,
			/* EndFeature:Travel */
			/* BeginFeature:VehicleModel */
			'idVehicleModel' => null,
			/* EndFeature:VehicleModel */
			/* BeginFeature:VehicleType */
			'idVehicleType' => null,
			/* EndFeature:VehicleType */
			/* BeginFeature:VehicleSeat */
			'vehicleSeats' => null,
			/* EndFeature:VehicleSeat */
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('code', $this->code, true);
		/* BeginFeature:VehicleType */
		$criteria->compare('id_vehicle_type', $this->id_vehicle_type);
		/* EndFeature:VehicleType */
		/* BeginFeature:VehicleModel */
		$criteria->compare('id_vehicle_model', $this->id_vehicle_model);
		/* EndFeature:VehicleModel */
		$criteria->compare('capacity', $this->capacity);
		$criteria->compare('active', $this->active);
		$criteria->compare('manufacturing_year', $this->manufacturing_year, true);
		$criteria->compare('fuel_capacity', $this->fuel_capacity);
		$criteria->compare('color', $this->color, true);
		$criteria->compare('bus_plate', $this->bus_plate, true);
		$criteria->compare('plane_true_airspeed_knots', $this->plane_true_airspeed_knots);
		$criteria->compare('plane_cruising_altitude', $this->plane_cruising_altitude);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
/* EndFeature:Vehicle */