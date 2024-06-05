<?php
use Spejder\Odoo\Odoo;
class Poliza
{

    private static Odoo $db;
    private static string $model_name = "final_project.polizamodel";
    public int $id;
    public int $name;
    public string $startdate;
    public string $enddate;

    public int $vehicleid;
    public int $clientid;
    public int $aseguranceid;

    public function __construct(Odoo $db)
    {
        $this->db = $db;
    }

    public static function getByVehiculoID(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('vehiculo_id.id', '=', $id), self::get_fields());
    }

    public static function getVehiculosWithPoliByIdUser(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('usuario.id', '=', $id), self::get_fieldsVehiculo());
    }

    public static function getPolizasByDni(Odoo $db, string $dni): array
    {
        return $db->searchRead(self::$model_name, build_condition('usuario.dni', '=', $dni), self::get_fields());
    }

    public static function getById(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('id', '=', $id), self::get_fields());
    }
    

    public static function getAll(Odoo $db): array
    {
        return $db->searchRead(self::$model_name,[],self::get_fieldsVehiculo());
    }
    private static function get_fields(): array
    {
        return ['name', 'dataInicio', 'dataFinal', 'vehiculo_id', 'usuario', 'aseguradora_id'];
    }

    private static function get_fieldsVehiculo(): array
    {
        return [ 'vehiculo_id', 'usuario'];
    }

}