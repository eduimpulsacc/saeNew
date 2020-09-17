/*------------------------------------------------------------------- 

Author's Statement:

This script is based on ideas of the author.

You may copy, modify and use it for any purpose. The only condition is that if you publish web pages that use this script you point to its author at a suitable place and don't remove this Statement from it.

It's your responsibility to handle possible bugs even if you didn't modify anything. I cannot promise any support.

Dieter Bungers

GMD (www.gmd.de) and infovation (www.infovation.de)

--------------------------------------------------------------------*/

function genHeadNums() {

	var theTags = document.all;

	var N = theTags.length;

	var numArray = new Array(-1,0,0,0,0,0,0,0,0,0);

	var oldLevel = 0, isFirstHead=true;

	for(i=0;i<N;i++) {

		var theTagName = theTags[i].tagName;

		if(theTagName.substring(0,1)=="H" && theTagName.length==2  && 

		!isNaN(theTagName.substring(1,2))) {

			var theLevel = eval(theTagName.substring(1,2))-1;

			++numArray[theLevel];

			var theNumber = new String(numArray[0]);

			for (k=1; k<=theLevel; k++) {

				theNumber += "."+numArray[k];

			}

			var preNum = (isFirstHead)?"":theNumber;

			isFirstHead = false;

			var str = "<A name=\"" + theNumber + "\">" + preNum + "</A> ";

			theTags[i].insertAdjacentHTML("afterBegin", str);

			// as this increases the number of the document's tags by 1 

			// N must be incremented accordingly !!

			N++;

			if (theLevel < oldLevel) {

				for (k=theLevel+1; k<10; k++) {

					numArray[k] = 0;

				}

			}

			oldLevel = theLevel;

		}

	}

	resCont = window.open("", "");

	resCont.document.write("<HTML>\n<HEAD>\n");

	var theHead = document.all.tags("HEAD")[0].innerHTML;

	var newHead = theHead.substring(0,theHead.toUpperCase().indexOf("<SCRIPT")-1) +

		theHead.substring(theHead.toUpperCase().indexOf("</SCRIPT>")+9,theHead.length);

	resCont.document.writeln(newHead);

	resCont.document.writeln( "</HEAD>\n<BODY>\n" + 

		document.all.tags("BODY")[0].innerHTML + 

		"\n</BODY>\n</HTML>" );

}



function genTocTable(docName) {

	var theTags = resCont.document.all;

	var N = theTags.length, j = 0, nCols = 0, isFirstHead=true;

	var seperator = " ";

	resToc = window.open("", "");

	resToc.document.writeln("var tocTab = new Array();");

	for(i=0;i<N;i++) {

		var theTagName = theTags[i].tagName;

		if(theTagName.substring(0,1)=="H" && theTagName.length==2  && 

		!isNaN(theTagName.substring(1,2))) {

			var txt = theTags[i].innerText;

			if (isFirstHead) {

				var theNum = "0";

				var theText = txt;

				isFirstHead = false

			}

			else {

				var textArray = txt.split(seperator);

				var theNum = textArray[0];

				var theText=txt.substring(txt.indexOf(seperator)+1, txt.length);

			}

			var theLine = "tocTab["+j+"] = new Array (\""+theNum+"\", \""+theText+"\", \"" + docName + "#" + theNum+"\");"

			resToc.document.writeln(theLine);

			j++;

			nCols = Math.max(nCols,theNum.split(".").length);

		}

	}

	resToc.document.write("var nCols = " + nCols + ";");

}