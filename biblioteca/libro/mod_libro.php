<?php 
require("../../util/header.php");
class Libro{
	public function construct(){
		
	}
	
public function autor($conn,$rdb){
	  $sql="SELECT * FROM biblio.autor  where rdb=$rdb order by nombre";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}



public function editorial($conn,$rdb){
	$sql="SELECT * FROM biblio.editorial where rdb=$rdb";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function categoria($conn,$rdb){
	$sql="SELECT * FROM biblio.categoria  where rdb=$rdb";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function idioma($conn,$rdb){
	$sql="SELECT * FROM biblio.idioma  where rdb=$rdb";
		$result = pg_exec($conn,$sql);
		return $result;	
}


public function repetido($conn,$titulo,$autor,$anio,$rdb){
	  $sql="SELECT * FROM biblio.libro where rdb=$rdb and  titulo like '".utf8_decode($titulo)."' and autor=$autor and ano_publicacion=$anio";
		$result = pg_exec($conn,$sql);
		return $result;	
}

public function GuardarLibro($conn,$isbn,$titulo,$autor,$editorial,$edicion,$ano_publicacion,$categoria,$idioma,$paginas,$lectura_comp,$rdb){
		 $sql="INSERT INTO biblio.libro(isbn,titulo,autor,editorial,edicion,ano_publicacion,categoria,idioma,paginas,lectura_comp,estado,rdb) values ('".utf8_decode($isbn)."','".strtoupper(utf8_decode(sanear_string($titulo)))."',$autor,$editorial,'".utf8_decode($edicion)."', $ano_publicacion,$categoria,$idioma,$paginas,$lectura_comp,1,$rdb)";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}


public function MaxLibro($conn,$rdb){
 $sql="select max(id_libro) from biblio.libro where rdb=$rdb";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function filtraLibros($conn,$tabla,$criterio,$orden,$tp,$rdb){
	
	$an = ($tp!=4)?" and ":"";
	$orden = ($tp!=4)?" titulo ":$orden;
	
   $sql="select li.* from $tabla where li.rdb=$rdb and estado != 3 $an $criterio  order by $orden";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function filtraLibrosAu($conn,$rdb){

    $sql="select li.* from biblio.libro li where li.rdb=$rdb and estado != 3  order by titulo";
$result = pg_exec($conn,$sql);
		
		return $result;	

}
	
public function autorUno($conn,$id){
	$sql="SELECT * FROM biblio.autor where id_autor=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function editorialUno($conn,$id){
		$sql="SELECT * FROM biblio.editorial where id_editorial=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function categoriaUno($conn,$id){
	$sql="SELECT * FROM biblio.categoria where id_categoria=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function idiomaUno($conn,$id){
	$sql="SELECT * FROM biblio.idioma where id_idioma=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function maxcopia($conn,$id){
	    $sql="SELECT max(id_ejemplar) FROM biblio.ejemplares where id_libro=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function libroUno($conn,$id){
	  $sql="SELECT * FROM biblio.libro where id_libro=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function ejemplarUno($conn,$id){
	  $sql="SELECT * FROM biblio.ejemplares where id_ejemplar=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function ejemplarLibro($conn,$id){
	
	   $sql="SELECT * FROM biblio.ejemplares where id_libro=$id and estado!=3 order by codigo";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}
	
public function guardaEjemplar($conn,$id_libro,$ubicacion,$codigo){
   $sql = "insert into biblio.ejemplares(id_libro,estado_prestamo,ubicacion,estado,codigo) values($id_libro,0,'".utf8_decode($ubicacion)."',1,$codigo)";
$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function quitaEjemplar($conn,$id){
	
   $sql="update biblio.ejemplares set estado=3 where id_ejemplar=$id";
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function quitaLibro($conn,$id){
	
	$sql="update biblio.ejemplares set estado=3 where id_libro=$id";
	$result = pg_exec($conn,$sql);
	
	//return $result;
	
   $sql="update biblio.libro set estado=3 where id_libro=$id";
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function modEjemplar($conn,$id,$ubicacion){
 $sql ="update biblio.ejemplares set ubicacion = '".utf8_decode($ubicacion)."' where id_ejemplar=$id";
$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function GuardarLibroE($conn,$isbn,$titulo,$editorial,$edicion,$ano_publicacion,$idioma,$paginas,$lectura_comp,$id_libro,$sacable){
	
	     $sql ="update biblio.libro set isbn='".utf8_decode($isbn)."', titulo='".strtoupper(utf8_decode(sanear_string($titulo)))."',  editorial=$editorial, edicion='".utf8_decode($edicion)."',ano_publicacion=$ano_publicacion, idioma=$idioma, paginas=$paginas, lectura_comp=$lectura_comp,sacable=$sacable where id_libro = $id_libro";
	$result = pg_exec($conn,$sql);
	
	return $result;	
	
	
}


public function AgregarAutor($conn,$nombre,$nacionalidad){
		$sql="INSERT INTO biblio.autor (nombre,nacionalidad) VALUES('".$nombre."','".$nacionalidad."')";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	public function ListadoAutor($conn){
		$sql="SELECT * FROM biblio.autor";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
public function buscaAUtorNombre($conn,$rdb,$autor){
  $sql="select id_autor from biblio.autor where rdb=$rdb and nombre = '$autor'";
$result = pg_exec($conn,$sql);
	return	$result;
}
public function buscaCatNombre($conn,$rdb,$categoria){
   $sql="select id_categoria from biblio.categoria where rdb=$rdb and nombre = '$categoria'";
$result = pg_exec($conn,$sql);
return	$result;
		/*$f = pg_result($result,0);
		return $f;*/
}

public function repetidoNew($conn,$titulo,$autor="",$anio,$rdb,$categoria="",$isbn){
	  $sql="select l.* from biblio.libro l
left join biblio.libro_autor la on la.id_libro = l.id_libro 
left join biblio.libro_categoria ca on ca.id_libro = l.id_libro 
where l.rdb=$rdb
and l.estado=1
and titulo = '".trim($titulo)."'
and ano_publicacion=$anio
and isbn='$isbn'
$autor
$categoria";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function GuardarLibroNew($conn,$isbn,$titulo,$editorial,$edicion,$ano_publicacion,$idioma,$paginas,$lectura_comp,$rdb,$sacable){
		  $sql="INSERT INTO biblio.libro(isbn,titulo,editorial,edicion,ano_publicacion,idioma,paginas,lectura_comp,estado,rdb,sacable) values ('".utf8_decode($isbn)."','".strtoupper(utf8_decode(sanear_string($titulo)))."',$editorial,'".utf8_decode($edicion)."', $ano_publicacion,$idioma,$paginas,$lectura_comp,1,$rdb,$sacable)";
		$result = pg_exec($conn,$sql);
		return $result;	
	}
	
public function maxAutor($conn,$rdb){
 $sql="select max(id_autor) from biblio.autor where rdb=$rdb";
$result = pg_exec($conn,$sql);
return pg_result($result,0);
}
public function maxCategoria($conn,$rdb){
 $sql="select max(id_categoria) from biblio.categoria where rdb=$rdb";
$result = pg_exec($conn,$sql);
return pg_result($result,0);
}

public function juntaAutorLibro($conn,$id_libro,$id_autor){
	 $sql="insert into biblio.libro_autor values($id_libro,$id_autor)";
	$result = pg_exec($conn,$sql);
		return $result;	
	}
	
public function juntaCategoriaLibro($conn,$id_libro,$id_categoria){
	  $sql="insert into biblio.libro_categoria values($id_libro,$id_categoria)";
	 $result = pg_exec($conn,$sql);
		return $result;	
	}
	
public function AgregarCategoria($conn,$nombre,$rdb){
		 $sql="INSERT INTO biblio.categoria (nombre,rdb) VALUES('$nombre',$rdb)";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
public function buscaIdioma($conn,$rbd,$idioma){
  $sql="select id_idioma from biblio.idioma where rdb=$rbd and nombre like'%$idioma%'";
$result = pg_exec($conn,$sql);
		return $result;
}
public function creaIdioma($conn,$rbd,$idioma){
 $sql="INSERT INTO biblio.idioma (nombre,rdb) VALUES('$idioma',$rbd)";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function maxIdioma($conn,$rdb){
 $sql="select max(id_idioma) from biblio.idioma where rdb=$rdb";
$result = pg_exec($conn,$sql);
return pg_result($result,0);
}

public function buscaEditorial($conn,$rbd,$editorial){
   $sql="select id_editorial from biblio.editorial where rdb=$rbd and nombre like'%$editorial%'";
$result = pg_exec($conn,$sql);
		return $result;
}
public function creaEditorial($conn,$rbd,$editorial){
 $sql="INSERT INTO biblio.editorial (nombre,rdb) VALUES('$editorial',$rbd)";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function maxEditorial($conn,$rdb){
$sql="select max(id_editorial) from biblio.editorial where rdb=$rdb";
$result = pg_exec($conn,$sql);
return pg_result($result,0);
}

public function AgregarAutorNew($conn,$nombre,$nacionalidad,$rdb){
		 $sql="INSERT INTO biblio.autor (nombre,nacionalidad,rdb,estado) VALUES('".$nombre."','".$nacionalidad."',$rdb,1)";
		$result = pg_exec($conn,$sql);
		return $result;
	}

public function MaxLibroNew($conn,$rdb){
 $sql="select max(id_libro) from biblio.libro where rdb=$rdb";
$result = pg_exec($conn,$sql);
return pg_result($result,0);
}

public function existeISBN($conn,$rdb,$isbn){
 $sql="select * from biblio.libro  where rdb=$rdb and isbn='$isbn'";
$result = pg_exec($conn,$sql);
return $result;
}

public function existeTitulo($conn,$rdb,$titulo){
 $sql="select * from biblio.libro  where rdb=$rdb and titulo='$titulo'";
$result = pg_exec($conn,$sql);
return $result;
}

public function cantAutores($conn,$id_libro){
$sql="
select a.nombre,a.id_autor
from biblio.autor a
inner join biblio.libro_autor la
on la.id_autor = a.id_autor
where la.id_libro = $id_libro";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cantCategorias($conn,$id_libro){
 $sql="
select a.nombre,a.id_categoria
from biblio.categoria a
inner join biblio.libro_categoria la
on la.id_categoria = a.id_categoria
where la.id_libro = $id_libro";
$result = pg_exec($conn,$sql);
return $result;	
}

//nueva funcion para ver si el titulo esta repetido y validar que no lo vuelvan a registrar... se supone.
public function repetidoV2($conn,$titulo,$anio,$rdb,$isbn){
	  $sql="SELECT * FROM biblio.libro where rdb=$rdb and  titulo like '%$titulo%' and isbn='$isbn' and ano_publicacion=$anio";
		$result = pg_exec($conn,$sql);
		return $result;	
}

public function quitaAutor($conn,$id_libro){
$sql="delete from biblio.libro_autor where id_libro=$id_libro";
$result = pg_exec($conn,$sql);
return $result;
}
public function quitaCategoria($conn,$id_libro){
	$sql="delete from biblio.libro_categoria where id_libro=$id_libro";
$result = pg_exec($conn,$sql);
return $result;
}

public function maxCodigo($conn,$id){
	    $sql="SELECT max(codigo) FROM biblio.ejemplares where id_libro=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function ejemplarSOLO($conn,$id){
	
	   $sql="SELECT * FROM biblio.ejemplares where id_libro=$id and estado!=3 order by codigo desc limit 1";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function modUbicacionejemplar($conn,$id,$ubicacion){
  $sql ="update biblio.ejemplares set ubicacion = '".$ubicacion."' where id_libro=$id";
$result = pg_exec($conn,$sql);
	
	return $result;	
}
}//fin clase
	?>