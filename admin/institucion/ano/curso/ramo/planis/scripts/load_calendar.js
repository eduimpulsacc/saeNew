// Thanks to CalendarPopup, script by Matt Kruse <matt@mattkruse.com> -->
var cal1 = new CalendarPopup();
cal1.setReturnFunction("setCal1MultipleValues");
function setCal1MultipleValues(y,m,d) {
     document.form_detalles.text_ano_inicio.value=y; 
     document.form_detalles.text_mes_inicio.value=LZ(m); 
     document.form_detalles.text_dia_inicio.value=LZ(d); 
     }
cal1.showYearNavigation();
cal1.setMonthNames('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'); 
cal1.setDayHeaders('D','L','M','W','J','V','S'); 
cal1.setWeekStartDay(1); 
cal1.setTodayText("Hoy");

var cal2 = new CalendarPopup();
cal2.setReturnFunction("setCal1MultipleValues2");
function setCal1MultipleValues2(y,m,d) {
     document.form_detalles.text_ano_fin.value=y; 
     document.form_detalles.text_mes_fin.value=LZ(m); 
     document.form_detalles.text_dia_fin.value=LZ(d); 
     }
cal2.showYearNavigation();
cal2.setMonthNames('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'); 
cal2.setDayHeaders('D','L','M','W','J','V','S'); 
cal2.setWeekStartDay(1); 
cal2.setTodayText("Hoy");

var cal3 = new CalendarPopup();
cal3.setReturnFunction("setCal1MultipleValues3");
function setCal1MultipleValues3(y,m,d) {
     document.form_detalles.text_ano_abor.value=y; 
     document.form_detalles.text_mes_abor.value=LZ(m); 
     document.form_detalles.text_dia_abor.value=LZ(d); 
     }
cal3.showYearNavigation();
cal3.setMonthNames('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'); 
cal3.setDayHeaders('D','L','M','W','J','V','S'); 
cal3.setWeekStartDay(1); 
cal3.setTodayText("Hoy");