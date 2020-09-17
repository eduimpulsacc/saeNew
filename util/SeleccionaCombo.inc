<script type="text/javascript">

function SeleccionaCombo(Objeto, valor)
  	{
		
		for (i=0;i < Objeto.options.length; i ++) 
		{
		
			if (Objeto.options[i].value == valor)
			{
		
				Objeto.options[i].selected = true; 
			}
		}
	}

</script>