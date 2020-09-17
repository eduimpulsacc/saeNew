
<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
//print_r($_POST);
$_POSP = 5;
$_bot = 8;

$institucion = $_INSTIT;
$ano = $cmb_ano;
$curso = $cmb_curso;
$periodo = $periodo;

$frmModo = $_FRMMODO;

$reporte = $c_reporte;
$c_alumno = $cmb_alumno;

//print_r($_POST);

/* if ($select_cursos>0){
  $Curso_pal = CursoPalabra($curso, 1, $conn);
  } */


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
//$ob_motor = new BuscadorReporte($conn);
//-------------------------	 CONFIGURACION DE REPORTE ------------------
$ob_config = new Reporte();
$ob_config->id_item = $reporte;
$ob_config->institucion = $institucion;
$ob_config->curso = $curso;
$rs_config = $ob_config->ConfiguraReporte($conn);
$fila_config = @pg_fetch_array($rs_config, 0);
$ob_config->CambiaDatoReporte($fila_config);



/* * *****INSITUCION ****************** */
$ob_membrete->institucion = $institucion;
$ob_membrete->institucion($conn);


//echo $ob_config->finicio_curso;
//-********** A�O ESCOLAR*****************
$ob_membrete->ano = $ano;
$ob_membrete->AnoEscolar($conn);
$nro_ano = $ob_membrete->nro_ano;



//-******INSITUCION *******************
$ob_membrete->institucion = $institucion;
$ob_reporte->rdb = $institucion;
$ob_membrete->institucion($conn);
$ob_reporte->ano = $ano;

$ob_reporte->periodo = $periodo;
$ob_reporte->Periodo($conn);


if ($c_alumno == 0) {
    $ob_reporte->ano = $ano;
    $ob_reporte->curso = $curso;
    $result_alu = $ob_reporte->TraeTodosAlumnos($conn);
} else {
    $ob_reporte->ano = $ano;
    $ob_reporte->curso = $curso;
    $ob_reporte->alumno = $c_alumno;
    $result_alu = $ob_reporte->TraeUnAlumno($conn);
}
$cont_alumnos = pg_numrows($result_alu);



//datos plantilla
$ob_reporte->ano = $ano;
$ob_reporte->curso = $curso;
$ob_reporte->alumno = $alumno;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>SAE - Sistema de Administraci&oacute;n Escolar</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../../../../../../<?= $_ESTILO ?>" rel="stylesheet" type="text/css">
        <STYLE>
            H1.SaltoDePagina
            {
                PAGE-BREAK-AFTER: always
            }
            .titulo
            {
                font-family:<?= $ob_config->letraT; ?>;
                font-size:<?= $ob_config->tamanoT; ?>px;
            }
            .item
            {
                font-family:<?= $ob_config->letraI; ?>;
                font-size:<?= $ob_config->tamanoI; ?>px;

            }
            .subitem
            {
                font-family:<?= $ob_config->letraS; ?>;
                font-size:<?= $ob_config->tamanoS; ?>px;
            }
        </style>
        <SCRIPT language="JavaScript">
            function MM_goToURL() { //v3.0
                var i, args = MM_goToURL.arguments;
                document.MM_returnValue = false;
                for (i = 0; i < (args.length - 1); i += 2)
                    eval(args[i] + ".location='" + args[i + 1] + "'");
            }

        </script>

        <script language="JavaScript" type="text/JavaScript">
            <!--

            function imprimir(){
            Element = document.getElementById("layer1")
            Element.style.display='none';
            Element = document.getElementById("layer2")
            Element.style.display='none';
            window.print();
            Element = document.getElementById("layer1")
            Element.style.display='';
            Element = document.getElementById("layer2")
            Element.style.display='';
            }

            function MM_preloadImages() { //v3.0
            var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
            var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
            if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
            }

            function MM_swapImgRestore() { //v3.0
            var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
            }

            function MM_findObj(n, d) { //v4.01
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n); return x;
            }

            function MM_swapImage() { //v3.0
            var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
            if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
            }
            //-->
        </script>
        <script>
            function imprimir()
            {
                document.getElementById("capa0").style.display = 'none';
                window.print();
                document.getElementById("capa0").style.display = 'block';
            }

            function exportar() {
                //	window.location='printCartaApoderado_C.php?cmb_curso=<?= $curso ?>&cmb_alumno=<?= $alumno ?>&xls=1';
                return false;
            }

        </script>
        <script>
            function cerrar() {
                window.close()
            }
        </script>
        <STYLE>
            H1.SaltoDePagina
            {
                PAGE-BREAK-AFTER: always
            }

        </style>

    </head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg', '../../../../../cortes/b_info_r.jpg', '../../../../../cortes/b_mapa_r.jpg', '../../../../../cortes/b_home_r.jpg')">


        <!-- INICIO CUERPO DE LA PAGINA -->

        <?


        ?>


        <div id="capa0">
            <table width="650" align="center">
                <tr>
                    <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
                    </td>
                    <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
                        <? if($_PERFIL==0){?>		  
                              <!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
                        <? }?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        for ($cont_paginas = 0; $cont_paginas < $cont_alumnos; $cont_paginas++) {
            $fila_alumno = pg_fetch_array($result_alu, $cont_paginas);
            //continuidad
            $ob_reporte->alumno = $fila_alumno['rut_alumno'];
            $ob_reporte->periodo = $periodo;
            $rs_continiudad = $ob_reporte->contPlan($conn);
            $fila_cont = pg_fetch_array($rs_continiudad, 0);
            $fila_plan = pg_fetch_array($rs_continiudad, 0);
            ?>


            <table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
                <tr>
                    <td><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>

                                <td width="178" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
                                <td width="10" class="item"><strong>:</strong></td>
                                <td width="310" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
                                <td width="156" rowspan="7" align="center" valign="top" ><?
                                    $result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
                                    $arr=@pg_fetch_array($result,0);
                                    $fila_foto  = @pg_fetch_array($result,0);
                                    ## c&oacute;digo para tomar la insignia

                                    if($institucion!=""){
                                    echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
                                    }else{
                                    echo "<img src='".$d."menu/imag/logo.gif' >";
                                    }?>    </td>

                            </tr>
                            <tr>
                                <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
                                <td class="item"><strong>:</strong></td>
                                <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
                            </tr>
                            <tr>
                                <td class="item">&nbsp;</td>
                                <td class="item">&nbsp;</td>
                                <td class="item">&nbsp;</td>
                            </tr>

                            <tr>
                                <td class="item">&nbsp;</td>
                                <td class="item">&nbsp;</td>
                                <td class="item">&nbsp;</td>
                            </tr>

                        </table>
                        <BR><BR>

                        <table  width="650" border="1" align="center" class="tableindex" style="border-collapse:collapse">
                            <tr>
                                <td align="center">PLAN DE APOYO INDIVIDUAL</td>
                            </tr>
                        </table>

                        <BR>
                        <br>
                        <table width="650" border="0" align="center">
                            <tr>
                                <td colspan="6" class="textonegrita">I.- IDENTIFICACI&Oacute;N</td>
                            </tr>
                            <tr>
                                <td width="117">&nbsp;</td>
                                <td width="110">&nbsp;</td>
                                <td width="77">&nbsp;</td>
                                <td width="88">&nbsp;</td>
                                <td width="117">&nbsp;</td>
                                <td width="115">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="textonegrita">NOMBRE</td>
                                <td class="textosimple"><? $nombre_alumno = ucwords(strtoupper(trim($fila_alumno['ape_pat']) . " " . trim($fila_alumno['ape_mat']) . " " . trim($fila_alumno['nombre_alu'])));
                                    echo $ob_reporte->tildeM($nombre_alumno);  ?></td>
                                <td class="textonegrita">EDAD</td>
                                <td class="textosimple"><?php echo CalcularEdad($fila_alumno['fecha_nac']); ?> a&ntilde;os</td>
                                <td class="textonegrita">CURSO</td>
                                <td class="textosimple"><?php echo CursoPalabra($curso, 1, $conn); ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="textonegrita">DIAGN&Oacute;STICO</td>
                                <td class="textosimple"><?php echo trim($fila_alumno['txt_tastornosaprendizaje']) ?></td>
                                <td class="textonegrita">PERIODO</td>
                                <td class="textosimple"><?php echo $ob_reporte->nombre_periodo ?></td>
                                <td class="textonegrita">ESPECIALISTA</td>
                                <td class="textosimple">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <table width="650" border="1" align="center" style="border-collapse:collapse">
                            <tr >
                                <td colspan="5" class="textonegrita" >II. ESTRATEGIAS ESPEC&Iacute;FICAS PARA FAVORECER EL ACCESO, LA PARTICIPACI&Oacute;N Y EL APRENDIZAJE</td>
                            </tr>
                            <tr >
                                <td colspan="5" >&nbsp;</td>
                            </tr>

                            <tr >
                                <td colspan="5" align="center">&nbsp;</td>
                            </tr>
                            <tr class="tableindex">
                                <td width="25%">TIPO DE APOYO</td>
                                <td width="25%">DESCRIPCI&Oacute;N</td>
                                <td width="25%">RESPONSABLE</td>
                                <td width="25%">CONTEXTO<br />
                                    (Aula de recursos,aula com&uacute;n, taller, otros)</td>
                                <td width="25%" align="center">CONTINUIDAD PERIODO</td>
                            </tr>
                            <tr >
                                <td class="tableindex">PERSONAL<br />
                                    (Tipo de profesional que apoya y periodos)</td>
                                <td class="textosimple"><?php echo $fila_plan['personal_descripcion'] ?></td>
                                <td class="textosimple">

                                    <?php
                                    $cad_personal = "";
                                    if ($fila_plan['personal_responsable'] != "0,") {
                                        $sep = explode(",", substr($fila_plan['personal_responsable'], 0, -1));
                                        // echo count($sep);
                                        for ($cp = 0; $cp < count($sep); $cp++) {
                                            $ob_reporte->empleado = $sep[$cp];
                                            $p_responsable = $ob_reporte->temp($conn);
                                            $f_responsable = pg_fetch_array($p_responsable, 0);
                                            $cad_personal.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                        }
                                    }
                                    echo $cad_personal;
                                    ?></td>
                                <td class="textosimple"><?php echo $fila_plan['personal_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['personal'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td class="tableindex">CURRICULAR<br />
                                    (Se&ntilde;ala asignaturas y periodos)</td>
                                <td class="textosimple" ><?php echo $fila_plan['curricular_descripcion'] ?></td>
                                <td class="textosimple">
                                    <?php
                                    $cad_curricular = "";
                                    if ($fila_plan['curricular_responsable'] != "0,") {
                                        $sep2 = explode(",", substr($fila_plan['curricular_responsable'], 0, -1));
                                        // echo count($sep);
                                        for ($cp = 0; $cp < count($sep2); $cp++) {
                                            $ob_reporte->empleado = $sep2[$cp];
                                            $p_responsable = $ob_reporte->temp($conn);
                                            $f_responsable = pg_fetch_array($p_responsable, 0);
                                            $cad_curricular.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                        }
                                    }
                                    echo $cad_curricular;
                                    ?>
                                </td>
                                <td class="textosimple"><?php echo $fila_plan['curricular_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['curricular'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td class="tableindex">MEDIOS Y RECURSOS MATERIALES Y/O TENCOL&Oacute;GICOS</td>
                                <td class="textosimple"><?php echo $fila_plan['medios_descripcion'] ?></td>
                                <td><span class="textosimple">
                                        <?php
                                        $cad_medios = "";
                                        if ($fila_plan['medios_responsable'] != "0,") {
                                            $sep3 = explode(",", substr($fila_plan['medios_responsable'], 0, -1));
                                            // echo count($sep);
                                            for ($cp = 0; $cp < count($sep3); $cp++) {
                                                $ob_reporte->empleado = $sep3[$cp];
                                                $p_responsable = $ob_reporte->temp($conn);
                                                $f_responsable = pg_fetch_array($p_responsable, 0);
                                                $cad_medios.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                            }
                                        }
                                        echo $cad_medios;
                                        ?>

                                    </span></td>
                                <td class="textosimple"><?php echo $fila_plan['medios_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['medios'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td class="tableindex">ORGANIZACI&Oacute;N Y AGRUPAMIENTO EN EL AULA<br />
                                    (Tiempo, espacio, forma de agrupar en la sala,tutor, etc.)</td>
                                <td class="textosimple"><?php echo $fila_plan['org_descripcion'] ?></td>
                                <td class="textosimple"><?php
                                    $cad_org = "";
                                    if ($fila_plan['medios_responsable'] != "0,") {
                                        $sep3 = explode(",", substr($fila_plan['org_responsable'], 0, -1));
                                        // echo count($sep);
                                        for ($cp = 0; $cp < count($sep3); $cp++) {
                                            $ob_reporte->empleado = $sep3[$cp];
                                            $p_responsable = $ob_reporte->temp($conn);
                                            $f_responsable = pg_fetch_array($p_responsable, 0);
                                            $cad_org.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                        }
                                    }
                                    echo $cad_org;
                                    ?></td>
                                <td class="textosimple"><?php echo $fila_plan['org_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['organizacion'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td class="tableindex">FAMILIAR</td>
                                <td class="textosimple"><?php echo $fila_plan['familar_descripcion'] ?></td>
                                <td class="textosimple">
                                    <?php
                                    $cad_fam = "";
                                    if ($fila_plan['familar_responsable'] != "0,") {
                                        $sep3 = explode(",", substr($fila_plan['familar_responsable'], 0, -1));
                                        // echo count($sep);
                                        for ($cp = 0; $cp < count($sep3); $cp++) {
                                            $ob_reporte->empleado = $sep3[$cp];
                                            $p_responsable = $ob_reporte->temp($conn);
                                            $f_responsable = pg_fetch_array($p_responsable, 0);
                                            $cad_fam.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                        }
                                    }
                                    echo $cad_fam;
                                    ?>
                                </td>
                                <td class="textosimple"><?php echo $fila_plan['familar_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['familiar'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td class="tableindex">OTROS</td>
                                <td class="textosimple"><?php echo $fila_plan['otros_descripcion'] ?></td>
                                <td class="textosimple">
                                    <?php
                                    $cad_otr = "";
                                    if ($fila_plan['otros_responsable'] != "0,") {
                                        $sep3 = explode(",", substr($fila_plan['otros_responsable'], 0, -1));
                                        // echo count($sep);
                                        for ($cp = 0; $cp < count($sep3); $cp++) {
                                            $ob_reporte->empleado = $sep3[$cp];
                                            $p_responsable = $ob_reporte->temp($conn);
                                            $f_responsable = pg_fetch_array($p_responsable, 0);
                                            $cad_otr.=$f_responsable['ape_pat'] . " " . $f_responsable['ape_mat'] . " " . $f_responsable['nombre_emp'] . "<br>";
                                        }
                                    }
                                    echo $cad_otr;
                                    ?>

                                </td>
                                <td class="textosimple"><?php echo $fila_plan['otros_contexto'] ?></td>
                                <td align="center" class="textosimple"><?php echo ($fila_cont['otros'] == 1) ? "SI" : ""; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" >&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right" >&nbsp;</td>
                            </tr>
                        </table>
                        <H1 class=SaltoDePagina></H1>
                        <table width="650" border="0" align="center">
                            <tr >
                                <td colspan="5" class="textonegrita" >OBSERVACIONES</td>
                            </tr>
                            <tr >
                                <td colspan="5" class="textosimple" ><?php echo $fila_cont['observaciones']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><br>
            <br>
            <br>
            <br>
            <br>
            <br>

            <?php
            $ruta_timbre = 5;
            $ruta_firma = 3;
            //$concur=0;
            include("../../firmas/firmas.php");
            ?>
            <table width="650" border="0" align="center">
                <tr>
                    <td></td>
                </tr>

                <tr>
                    <td><br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <?php
                        $fecha = (date("d-m-Y"));
                        $fecha = fecha_espanol($fecha);
                        ?>
                        <div align="right" class="subitem"><?php echo trim($ob_membrete->comuna) ?>,<?= $fecha; ?></div></td>
                </tr>


            </table>
            <?php if ($cont_alumnos > 1) { ?>
                <H1 class=SaltoDePagina></H1>
                <?php } ?>

        <?php } ?>



    </body>
</html>
<? pg_close($conn);?>