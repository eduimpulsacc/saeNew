function validar(formulario) 
{ 

rut=formulario.rut.value; 
var count=0; 
var count2=0; 
var factor=2; 
var suma=0; 
var sum=0; 
var digito=0; 
count2=rut.length - 1; 

while(count < rut.length) 
{ 

sum = factor * (parseInt(rut.substr(count2,1))); 
suma = suma + sum; 
sum=0; 

count = count + 1; 
count2 = count2 - 1; 
factor = factor + 1; 

if(factor > 7) 
{ 
factor=2; 
} 

} 

digito= 11 - (suma % 11) 

if(digito==11) 
{ 
digito=0; 
} 

if(digito==10) 
{ 
digito="k"; 
} 

if((digito==formulario.dig.value) && (form.rut.value!="")&& (form.dig.value!=""))
{ 
;
} 
else 
{ 
alert("Rut Inválido");
return false; 
} 


} 

//validar rut alumno
function validar_alu(formulario) 
{ 

rut_alu=formulario.rut_alu.value; 
var count=0; 
var count2=0; 
var factor=2; 
var suma=0; 
var sum=0; 
var digito=0; 
count2=rut_alu.length - 1; 

while(count < rut_alu.length) 
{ 

sum = factor * (parseInt(rut_alu.substr(count2,1))); 
suma = suma + sum; 
sum=0; 

count = count + 1; 
count2 = count2 - 1; 
factor = factor + 1; 

if(factor > 7) 
{ 
factor=2; 
} 

} 

digito= 11 - (suma % 11) 

if(digito==11) 
{ 
digito=0; 
} 

if(digito==10) 
{ 
digito="k"; 
} 

if((digito==formulario.dig_alu.value) && (form2.rut_alu.value!="")&& (form2.dig_alu.value!=""))
{ 
;
} 
else 
{ 
alert("Rut Inválido - Alumno");
return false; 
} 


} 

//validar padre
function validar_padre(formulario) 
{ 

rut_padre=formulario.rut_padre.value; 
var count=0; 
var count2=0; 
var factor=2; 
var suma=0; 
var sum=0; 
var digito=0; 
count2=rut_padre.length - 1; 

while(count < rut_padre.length) 
{ 

sum = factor * (parseInt(rut_padre.substr(count2,1))); 
suma = suma + sum; 
sum=0; 

count = count + 1; 
count2 = count2 - 1; 
factor = factor + 1; 

if(factor > 7) 
{ 
factor=2; 
} 

} 

digito= 11 - (suma % 11) 

if(digito==11) 
{ 
digito=0; 
} 

if(digito==10) 
{ 
digito="k"; 
} 

if((digito==formulario.dig_padre.value) && (form2.rut_padre.value!="")&& (form2.dig_padre.value!=""))
{ 
;
} 
else 
{ 
alert("Rut Inválido - Padre");
return false; 
} 


} 

//valido rut madre
function validar_madre(formulario) 
{ 

rut_madre=formulario.rut_madre.value; 
var count=0; 
var count2=0; 
var factor=2; 
var suma=0; 
var sum=0; 
var digito=0; 
count2=rut_madre.length - 1; 

while(count < rut_madre.length) 
{ 

sum = factor * (parseInt(rut_madre.substr(count2,1))); 
suma = suma + sum; 
sum=0; 

count = count + 1; 
count2 = count2 - 1; 
factor = factor + 1; 

if(factor > 7) 
{ 
factor=2; 
} 

} 

digito= 11 - (suma % 11) 

if(digito==11) 
{ 
digito=0; 
} 

if(digito==10) 
{ 
digito="k"; 
} 

if((digito==formulario.dig_madre.value) && (form2.rut_madre.value!="")&& (form2.dig_madre.value!=""))
{ 
;
} 
else 
{ 
alert("Rut Inválido - Madre");
return false; 
} 


} 


//validar datos apoderado

function validar_apoderado(formulario) 
{ 

rut_apoderado=formulario.rut_apoderado.value; 
var count=0; 
var count2=0; 
var factor=2; 
var suma=0; 
var sum=0; 
var digito=0; 
count2=rut_apoderado.length - 1; 

while(count < rut_apoderado.length) 
{ 

sum = factor * (parseInt(rut_apoderado.substr(count2,1))); 
suma = suma + sum; 
sum=0; 

count = count + 1; 
count2 = count2 - 1; 
factor = factor + 1; 

if(factor > 7) 
{ 
factor=2; 
} 

} 

digito= 11 - (suma % 11) 

if(digito==11) 
{ 
digito=0; 
} 

if(digito==10) 
{ 
digito="k"; 
} 

if((digito==formulario.dig_apoderado.value) && (form2.rut_apoderado.value!="")&& (form2.dig_apoderado.value!=""))
{ 
;
} 
else 
{ 
alert("Rut Inválido - Apoderado");
return false; 
} 


} 

//validar resto del formulario
function comprobar(form2)
{
	
	if(form2.curso.value==0)
	{
		alert("Seleccione Curso");	
		form2.curso.focus();
		return false;
	}
	
	if(form2.num_mat.value=="")
	{
		alert("Ingrese número matrícula");	
		form2.num_mat.focus();
		return false;
	}
	
	if(form2.rut_alu.value=="")
	{
		alert("Ingrese rut");	
		form2.rut_alu.focus();
		return false;
	}
	
	if(form2.dig_alu.value=="")
	{
		alert("Ingrese DV");	
		form2.dig_alu.focus();
		return false;
	}
	
	if(form2.ape_pat.value=="")
	{
		alert("Ingrese Apellido Paterno Alumno");	
		form2.ape_pat.focus();
		return false;
	}
	
	if(form2.ape_mat.value=="")
	{
		alert("Ingrese Apellido Materno Alumno");	
		form2.ape_mat.focus();
		return false;
	}
	
	if(form2.nombre_alu.value=="")
	{
		alert("Ingrese Nombre Alumno");	
		form2.nombre_alu.focus();
		return false;
	}
	
	if(form2.sexo.value==0)
	{
		alert("Seleccione sexo");	
		form2.sexo.focus();
		return false;
	}
	
	if(form2.fecha_nacimiento.value=="")
	{
		alert("Seleccione Fecha de Nacimiento");	
		form2.fecha_nacimiento.focus();
		return false;
	}
	
	if(form2.calle.value=="")
	{
		alert("Digite Nombre de calle");	
		form2.calle.focus();
		return false;
	}
	
	if(form2.nro.value=="")
	{
		alert("Digite número casa");	
		form2.nro.focus();
		return false;
	}
	
	if(form2.fecha_inc_cur.value=="")
	{
		alert("Seleccione Fecha Incorporación curso");	
		form2.fecha_inc_cur.focus();
		return false;
	}
	
	if(form2.comuna.value==0)
	{
		alert("Seleccione Comuna - Alumno");	
		form2.comuna.focus();
		return false;
	}
	
	if(form2.alu_cqv.value=="")
	{
		alert("Especifique con quién vive alumno");	
		form2.alu_cqv.focus();
		return false;
	}
	
	
	if(form2.nom_apo.value=="")
	{
		alert("Digite nombre apoderado");	
		form2.nom_apo.focus();
		return false;
	}
	
	
	if(form2.ape_pat_apo.value=="")
	{
		alert("Digite apellido paterno apoderado");	
		form2.ape_pat_apo.focus();
		return false;
	}
	
	if(form2.ape_mat_apo.value=="")
	{
		alert("Digite apellido materno apoderado");	
		form2.ape_mat_apo.focus();
		return false;
	}
	
	if(form2.ape_pat_apo.value=="")
	{
		alert("Digite apellido paterno apoderado");	
		form2.ape_pat_apo.focus();
		return false;
	}
	
	if(form2.parent_apo.value==0)
	{
		alert("Seleccione Parentezco con alumno");	
		form2.parent_apo.focus();
		return false;
	}
	
	if(form2.dom_apo.value=="")
	{
		alert("Digite dirección apoderado");	
		form2.dom_apo.focus();
		return false;
	}
	if(form2.nro_apo.value=="")
	{
		alert("Digite número casa apoderado");	
		form2.nro_apo.focus();
		return false;
	}
	
	if(form2.comuna_apo.value==0)
	{
		alert("Seleccione Comuna apoderado");	
		form2.comuna_apo.focus();
		return false;
	}
	
	if(form2.n_educ_apo.value==0)
	{
		alert("Seleccione nivel educacional apoderado");	
		form2.n_educ_apo.focus();
		return false;
	}
	
	if(form2.nom_func_mat.value==0)
	{
		alert("Digite nombre funcionario que matricula");	
		form2.nom_func_mat.focus();
		return false;
	}
	
	
	repite=-1;
				for(i=0;i<form2.rep.length;i++)
				{
					if(form2.rep[i].checked)
						repite=1;
						
				}
				if (repite==-1)
				{
				alert("Debe indicar si ha repetido algún curso ");
				form2.rep[0].focus();
				return false
				}
				
				//repitio =si
				if (form2.rep[0].checked == true) {
				if (form2.cursosrep.value == "") {
				alert("Indique qué cursos ha repetido.");
				form2.cursosrep.focus();
				return false;
				}
				}
				
				
	relig=-1;
				for(i=0;i<form2.rel.length;i++)
				{
					if(form2.rel[i].checked)
						relig=1;
						
				}
				if (relig==-1)
				{
				alert("Debe indicar si profesa alguna religión ");
				form2.rel[0].focus();
				return false
				}
				
				//religion =si
				if (form2.rel[0].checked == true) {
				if (form2.religion.value == "") {
				alert("Indicar religión.");
				form2.religion.focus();
				return false;
				}
				}
				
					unif=-1;
				for(i=0;i<form2.tie_unif.length;i++)
				{
					if(form2.tie_unif[i].checked)
						unif=1;
						
				}
				if (unif==-1)
				{
				alert("Debe indicar si alumno posee uniforme ");
				form2.tie_unif[0].focus();
				return false
				}
				
				
	
}