<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
// logAPI($data);


try {
    check_token($data);
    $input = validate($data, [
        'addres' => 'required|string',
        'client1' => 'required|numeric',
        'client2' => 'required',
        'dataParte' => 'required|string',
        'descripcion' => 'required|string',
        'location' => 'required|string',
        'vehiculo' => 'required|numeric',
        'vehiculo2' => 'required',
        'photo' => 'required',
        'poliza_ids'
    ]);

    // $path = 'images/';
    $imageData = file_get_contents($input->photo);
    $base64Image = base64_encode($imageData);

    $newParte = new Partes($db);

    if (!is_numeric($input->client2)) {
        $client2 = new User($db);
        $client2->dni = $input->client2['dni'];
        $client2->name = $input->client2['name'];
        $client2->surname = $input->client2['surname'];
        $client2->tlf = $input->client2['phone'];
        $client2->dateBirth = $input->client2['dateBirth'];
        $client2->email = $input->client2['email'];
        $client2->isClient = false;
        $client2->save();
        $x = User::getByDNI($db, $client2->dni);
        $idUser = $x['id'];
        $newParte->client2 = $idUser;

        if (!is_numeric($input->vehiculo2)) {
            $vehicle2 = new Vehicle($db);
            $vehicle2->name = $input->vehiculo2['matricula'];
            $vehicle2->marca = $input->vehiculo2['marca'];
            $vehicle2->modelo = $input->vehiculo2['modelo'];
            $vehicle2->usuario = $idUser;
            $vehicle2->save();
            $z = Vehicle::getVehiclesByUser($db, $idUser);
            $idVehi = $z[0]['id'];
            
            $newParte->vehiculo2 = $idVehi;
        } else {
            $newParte->vehiculo2 = $input->vehiculo2;
        }

        $newParte->nameAsegurNoClien = $input->poliza_ids['aseguradora'];
        $newParte->numPoliNoClien = $input->poliza_ids['numPoliza'];

        $newParte->isClient = false;

    } else {
        $newParte->client2 = $input->client2;
        if (!is_numeric($input->vehiculo2)) {
            $vehicle2 = new Vehicle($db);
            $vehicle2->name = $input->vehiculo2['matricula'];
            $vehicle2->marca = $input->vehiculo2['marca'];
            $vehicle2->modelo = $input->vehiculo2['modelo'];
            $vehicle2->usuario =  $input->client2;
            $vehicle2->save();
            $z = Vehicle::getVehiclesByUser($db, $input->client2);
            $idVehi = $z[0]['id'];
            // logAPI($idVehi);
            $newParte->vehiculo2 = $idVehi;
            $newParte->nameAsegurNoClien = $input->poliza_ids['aseguradora'];
            $newParte->numPoliNoClien = $input->poliza_ids['numPoliza'];
            $newParte->isClient = false;
        } else {
            $z = Vehicle::getVehiclesByID($db, $input->vehiculo2);
            // logAPI($z[0]['poliza_ids']);
            if(empty($z[0]['poliza_ids'])){
                $newParte->nameAsegurNoClien = $input->poliza_ids['aseguradora'];
                $newParte->numPoliNoClien = $input->poliza_ids['numPoliza'];
                $newParte->isClient = false;
            }
            $newParte->vehiculo2 = $input->vehiculo2;
        }
    }

    $newParte->dataParte = $input->dataParte;
    $newParte->location = $input->location;
    $newParte->addres = $input->addres;
    $newParte->descripcion = $input->descripcion;
    $newParte->client1 = $input->client1;
    $newParte->vehiculo = $input->vehiculo;

    $newParte->photo = $base64Image;
    $newParte->save();

    // logAPI($newParte);


    Response::sendResponse([
        "parte" => $newParte
    ]);


} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}