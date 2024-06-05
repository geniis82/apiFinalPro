<?php
use Spejder\Odoo\Odoo;

class User
{
    private static Odoo $db;
    private static string $model_name = "final_project.usuariomodel";
    public int $id;
    public string $dni;
    public string $name;
    public string $surname;
    public string $password;
    public string $tlf;
    public string $dateBirth;
    public string $email;
    public bool $isClient;

    public function __construct(Odoo $db)
    {
        $this::$db = $db;
    }

    public function save(): int
    {
        return $this::$db->create(self::$model_name, json_decode(json_encode(get_object_vars($this)), true));
    }

    public static function getByDNI(Odoo $db, string $dni): array
    {
        $res = $db->searchRead(self::$model_name, build_condition('dni', '=', $dni), self::get_fields(true));

        if (empty($res)) {
            createException('userNotFound', 404);
        }
        return $res[0];
    }

    public static function getUsers(Odoo $db): array
    {
        return $db->searchRead(self::$model_name, [], self::get_fields());
    }
    public static function getUserPass(Odoo $db, string $dni): array
    {
        return $db->searchRead(self::$model_name, build_condition('dni', '=', $dni), ['password']);
    }
    public static function getUser(Odoo $db, string $dni): array
    {
        return $db->searchRead(self::$model_name, build_condition('dni', '=', $dni), self::get_fields());
    }

    public static function getUserById(Odoo $db, string $id): array
    {
        return $db->searchRead(self::$model_name, build_condition('id', '=', $id), self::get_fields());
    }

    public static function setNameSurname(Odoo $db, string $id, string $name, string $surname): array
    {
        $ids = $db->search(self::$model_name, [['id', '=', $id]], 0, 1);
        return $db->write(self::$model_name, $ids, ['name' => $name, 'surname' => $surname]);
    }

    public static function setEmailPhone(Odoo $db, string $id, string $email, string $phone): array
    {
        $ids = $db->search(self::$model_name, [['id', '=', $id]], 0, 1);
        return $db->write(self::$model_name, $ids, ['email' => $email, 'tlf' => $phone]);
    }

    public static function setNewPassword(Odoo $db, string $id, string $pass): array
    {
        $ids = $db->search(self::$model_name, [['id', '=', $id]], 0, 1);
        return $db->write(self::$model_name, $ids, ['password' => $pass]);
    }

    private static function get_fields(bool $includePass = false): array
    {
        if ($includePass) {
            return ['dni', 'name', 'surname', 'password', 'tlf', 'dateBirth', 'email','isClient'];
        }
        return ['dni', 'name', 'surname', 'tlf', 'dateBirth', 'email', 'id','isClient'];
    }


}