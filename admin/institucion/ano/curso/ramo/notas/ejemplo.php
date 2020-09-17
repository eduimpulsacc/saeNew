<html>
<head>
<title> Ejemplo </title>
<SCRIPT LANGUAGE=javascript>

function fn(form,field)
{
	var next=0, found=false
	var f=form
	if(event.keyCode!=32) return;
	for(var i=0;i<f.length;i++)	{
		if(field.name==f.item(i).name){
			next=i+1;
			found=true
			break;
		}
	}
	while(found){
		if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
			f.item(next).focus();
			break;
		}
		else{
			if(next<f.length-1)
				next=next+1;
			else
				break;
		}
	}
}
</SCRIPT>
</head>

<body>
<FORM name=fx>
<TABLE border=0 cellPadding=1 cellSpacing=1 width="75%">
  <TR>
    <TD><b>Campo 1:</b></TD>
    <TD><INPUT id=text1 name=text1 onkeyup=fn(this.form,this)></TD>
  </TR>
  <TR>
    <TD><b>Campo 2:</b></TD>
    <TD><INPUT id=text2 name=text2 onkeyup=fn(this.form,this)></TD>
  </TR>
  <TR>
    <TD><b>Campo 3:</b></TD>
    <TD><INPUT id=text3 name=text3 onkeyup=fn(this.form,this)></TD>
  </TR>
  <TR>
    <TD><b>Campo 4:</b></TD>
    <TD><INPUT disabled id=text4 name=text4 onkeyup=fn(this.form,this) value=Disabled></TD>
  </TR>
  <TR>
    <TD><b>Campo 5:</b></TD>
    <TD><INPUT id=text5 name=text5 onkeyup=fn(this.form,this)><SELECT disabled id=select1 
      name=select2 onkeyup=fn(this)> <OPTION selected>disabled</OPTION> 
        <OPTION>nitin</OPTION></SELECT></TD>
  </TR>
  <TR>
    <TD><b>Campo 6:</b></TD>
    <TD><INPUT id=text6 name=text6 onkeyup=fn(this.form,this)></TD>
  </TR>
  <TR>
    <TD><b>Campo 7:</b></TD>
    <TD><SELECT id=select12 name=select1 onkeyup=fn(this.form,this)> <OPTION 
        selected>value1</OPTION> <OPTION>Value2</OPTION></SELECT></TD>
  </TR>
  <TR>
    <TD><b>Campo 8:</b></TD>
    <TD><INPUT id=checkbox1 name=checkbox1 onkeyup=fn(this.form,this) type=checkbox><INPUT disabled id=che2ckbox1 name=checkbox2 onkeyup=fn(this.form,this) type=checkbox>
	</TD>
  </TR>
  <TR>
	<TD colspan=2 align="center">
		<INPUT name=boton onclick="alert('Fin del formulario');" type=button value="  Fin  ">
    </TD>
  </TR>

 </TABLE>
  </FORM>
</body>
</html>

