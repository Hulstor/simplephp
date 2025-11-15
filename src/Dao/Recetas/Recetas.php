<?php

namespace DAO\Recetas;


use Dao\Table;

class Recetas extends Table
{
    public static function getAll()
    {
        $sql = "SElECT id_receta, nombre, ingrediente_principal, dificultad, tiempo_preparacion_min, tipo cocina from RecetasComida 
        where id_receta =:id_receta ORDER BY nombre;";
        return self::obtenerUnRegistro($sql, array());
    }
    public static function getByid($id_receta)
    {
        $sql = "SELECT id_receta,
        nombre,
        ingrediente_principal,
        dificultad,
        tiempo_preparacion_min,
        tipo_cocina
        FROM RecetasComida
        WHERE id_recetas= :id_receta;";

        return self::obtenerUnRegistro($sql, array(
            "id_receta" => $id_receta
        ));
    }

    public static function insert(
        $nombre,
        $ingrediente_principal,
        $dificultad,
        $tiempo_preparacion_min,
        $tipo_cocina
    ) {
        $sql = "INSERT INTO RecetasComida
            (nombre,
             ingrediente_principal,
             dificultad,
              tiempo_preparacion_min, 
              tipo_cocina)
            values (:nombre,
            :ingrediente_principal,
            :dificultad,
            :tiempo_preparacion_min,
            :tipo_cocina);";

        return self::executeNonQuery($sql, array(
            "nombre" => $nombre,
            "ingrediente_principal"  => $ingrediente_principal,
            "dificultad"  =>  $dificultad,
            "tiempo_preparacion_min"  => $tiempo_preparacion_min,
            "tipo_cocina"   => $tipo_cocina
        ));
    }
    public static function update(
        $nombre,
        $Ingrediente_principal,
        $dificultad,
        $tiempo_preparacion_min,
        $tipo_cocina,
        $id_receta
    ) {
        $sql = "UPDATE RecetasComida
            SET nombre = :nombre
            ingrediente_principal = :ingrediente_principal
            dificultad = :dificultad
            tiempo_preparacion_min = :tiempo_preparacion_min
            tipo_cocina = :tipo_cocina
            WHERE id_receta = :id_receta;";

        return self::executeNonQuery($sql, array(
            "nombre"    => $nombre,
            "ingrediente_principal"   => $Ingrediente_principal,
            "dificultad"  =>  $dificultad,
            "tiempo_preparacion_min"  => $tiempo_preparacion_min,
            "tipo_cocina"   => $tipo_cocina,
            "id_receta"    => $id_receta
        ));
    }
    public static function delete($id_receta)
    {
        $sql = "DELETE FROM REcetasComida
            WHERE id_receta = :id_recetas;";
        return self::executeNonQuery($sql, array(
            "id_receta"  => $id_receta
        ));
    }
}
