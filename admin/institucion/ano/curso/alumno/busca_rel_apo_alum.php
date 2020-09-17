<?php
require('../../../../../util/header.inc');
class busca_apoderado{
	
	private $buscar_apo;
	
	public function busca_apo($rut_apo)
	{
		$sql="select * from apoderado where rut_apo=$rut_apo";
		$rs_apo=pg_exec($conn,$sql);
		
		while ($reg=pg_fetch_assoc($rs_apo))
		{
			$this->buscar_apo=$reg;
		}
			return $this->buscar_apo;	
	}
	
	
	}


?>