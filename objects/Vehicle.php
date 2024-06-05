<?php
use Spejder\Odoo\Odoo;
class Vehicle{

    private static Odoo $db;
    private static string $model_name = "final_project.vehiculosmodel";

    public int $id;
    public string $plate;
    public string $brand;
    public string $model;
    public int $user_id;
    public int $poliza_id;

    public function __construct(Odoo $db)
    {
        $this::$db = $db;
    }

    public function save(): int
    {
        return $this::$db->create(self::$model_name, json_decode(json_encode(get_object_vars($this)), true));
    }

    public static function getVehicles(Odoo $db): array
    {
        return $db->searchRead(self::$model_name, [], self::get_fields());
    }
    public static function getVehiclesByUser(Odoo $db,string $userid): array{
        return $db->searchRead(self::$model_name,build_condition('usuario.id','=', $userid), self::get_fields());
    }

    public static function getVehiclesByID(Odoo $db,string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('id','=', $id), self::get_fields());
    }

    private static function get_fields(): array
    {
        return ['name', 'marca', 'modelo', 'poliza_ids','id'];
    }
}