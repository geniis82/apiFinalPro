<?php
use Spejder\Odoo\Odoo;
class Asegurance{
    private static string $model_name="final_project.aseguradoramodel";
    private static Odoo $db;
    public int $id;

    public string $name;
    public $photo;

    public static function getById(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('id', '=', $id), self::get_totalfields());
    }

    private static function get_totalfields(): array
    {
        return ['id','name'];
    }
}