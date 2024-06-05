<?php
use Spejder\Odoo\Odoo;

class Partes
{
    private static Odoo $db;
    private static string $model_name = "final_project.partesmodel";
    public int $id;
    public int $id_name;
    public string $descripcion;
    public string $dataParte;
    public ?string $photo;
    public string $location;
    public string $addres;
    public int $client1;    //relation
    public User|int $client2;
    public int $vehiculo;   //relation
    public Vehicle|int $vehiculo2;   //relation
    public bool $isClient;
    public function __construct(Odoo $db)
    {
        $this::$db = $db;
    }

    // public function save(): int
    // {
    //     return $this::$db->create(self::$model_name, json_decode(json_encode(get_object_vars($this)), true));
    // }

    public function save(): int
    {
        $data = json_decode(json_encode(get_object_vars($this)), true);

        // Incluir la foto en los datos a enviar
        $data['photo'] = $this->photo;

        return $this::$db->create(self::$model_name, $data);
    }
    
    
    public function update(): array
    {
        return $this::$db->write(self::$model_name, [self::$id], [self::$photo]);
    }
    public static function getById(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('id', '=', $id), self::get_totalfields())[0];
    }

    public static function getAllbyUser(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('client1.id', '=', $id), self::get_fields());
    }

    private static function get_fields(): array
    {
        return ['name', 'descripcion', 'dataParte', 'addres', 'location'];
    }

    private static function get_totalfields(): array
    {
        return ['descripcion', 'dataParte', 'addres', 'location', 'client1', 'client2', 'vehiculo', 'vehiculo2','photo'];
    }
}