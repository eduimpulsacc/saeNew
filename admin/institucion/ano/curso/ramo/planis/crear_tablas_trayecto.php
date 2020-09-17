<?php
	require('../../../../../../util/header.inc');
/*
$create_unidad_sql = "CREATE TABLE Plani_Trayecto_Unidad (
  id_plani INTEGER   NOT NULL ,
  unidad_t TEXT    ,
  ofv TEXT    ,
  oft TEXT    ,
  cmo TEXT    ,
  meta_a TEXT    ,
  matriz TEXT    ,
  temas_f TEXT    ,
  conceptos_i TEXT    ,
  ideas_c TEXT    ,
  bibliografia TEXT    ,
  matriz_ev TEXT    ,
  modalidad_e TEXT    ,
  actividad_e TEXT    ,
  instancia_e TEXT    ,
  prodedimientos TEXT    ,
  instrumentos TEXT    ,
  agente TEXT    ,
PRIMARY KEY(id_plani)  ,
  FOREIGN KEY(id_plani)
    REFERENCES Plani(id_plani));";

$create_clase_sql = "CREATE TABLE Plani_Trayecto_Clase (
  id_plani INTEGER   NOT NULL ,
  unidad TEXT    ,
  sesion TEXT    ,
  hh INTEGER    ,
  mm INTEGER    ,
  metas_a TEXT    ,
  objetivo_d TEXT    ,
  c_conceptuales TEXT    ,
  c_procedimentales TEXT    ,
  c_actitudinales TEXT    ,
  matriz TEXT    ,
  modificaciones TEXT    ,
  fundamentaciones TEXT    ,
PRIMARY KEY(id_plani)  ,
  FOREIGN KEY(id_plani)
    REFERENCES Plani(id_plani));";

echo $create_unidad_sql;
if (!@pg_Exec($conn, $create_unidad_sql)) echo pg_last_error();
echo $create_clase_sql;
if (!@pg_Exec($conn, $create_clase_sql)) echo pg_last_error();
*/
$alter = "ALTER TABLE Plani_Trayecto_Unidad RENAME COLUMN Agente TO Agentes;";
echo $alter;
if (!@pg_Exec($conn, $alter)) echo pg_last_error();
?>