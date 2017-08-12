<?php
//
//THIS FILE IS PART OF THE SQLGEN LIBARAY
//
//Copyright(C) GPL 2010  Eadthem Akip
//
//SQLgen is free software: you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
//(at your option) any later version.

//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

//You should have received a copy of the GNU General Public License
//along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//
//#include "varable.h"
//#include "SQLgen.h"
//#include "SQLgenSQL.h"
//#include "SQLstatements.h"
//PORTED FROM C++ BY EADTHEM AKIP
//
//THIS FILE IS PART OF THE SQLGEN LIBARAY
//
//Copyright(C) GPL 2008  Eadthem Akip
//
//SQLgen is free software: you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
//(at your option) any later version.

//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

//You should have received a copy of the GNU General Public License
//along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//
#ifndef SQLGEN_H
#define SQLGEN_H

//#include "tlog.h"
//#include "config.h"
#include "stdio.h"
#include "SQLconnect\SQLconnect.h"
//#include "Sockets.h"
//#include "opcodes.h"
//#include "bitmasks.h"
//#include "CParam.h"
	require_once ('SQLStatements.php');
class SQLgen 
{
	


	//DEFINED VARABLES
		//#define SQL_DATA_RESERVE    200
		//#define SQL_DATA_INCRMENT    100

	//PRIVATE LOCATION AND SIZEING VARABLES
		//unsigned int _ReadPos;              //initalize to 0. Increment on read.
		//$_WritePos = 0;	//initialize to 0. Increment on write.
		//char ** _ptrbin;
		//$_capacity;		//current max size of the buffer
		//$this->_scoop;		//clause write scoop
		//THE BUFFER
		public $_buffer = " ";			//the buffer handled by malloc realloc free only.
		public $colquote=true;

	//CONSTRUCTOR DESTRUCTOR
public function __construct()
		{
			//$this->_buffer = ' ';
			$this->_WritePos = 0;
			$this->_scoop = 0;
			//_bincount = 0;
			//_buffer = (char*)malloc(sizeof(char)*SQL_DATA_RESERVE);
			//$this->_buffer
   			$this->insertNotFinished=false;
			$this->notFinished=true;
			$this->clean=false;
			$this->csvon=false;
			$this->colquote=true;

		}
public function clearAll()
		{
			$this->_scoop = 0;
			$this->_buffer = ' ';
			$this->insertNotFinished=false;
			$this->notFinished=true;
			$this->csvon=false;
			$this->_WritePos = 0;// set write position back to 0  data wont be removed but it will be unavalable
			$this->colquote=true;
		}
public function __destruct()
		{
			//cleanGarbage();
			//if(clean==false)
			//{
				//free(_buffer);
				//$delete _buffer;
			//	$clean=true;
			//}
			//else
			//{
			//	echo "ERROR DOUBLE CLEANUP DETECTED";
			//}
		
		}
		//$clean;//prevents double deconstructing and warns of such voodoo
//private://RAW WRITE INTERNAL
			//UNSANATIZED
				//void ClauseWrite($string);//write using global scoop to buffer //stop at  # $ % & //resume a write bypassing  # $ % &
				//void ColWriteNQ($string);//write without sanitization //untell null //FOR SAFE VARABLES ONLY
			//SANATIZED
				//void ValueWriteNQ($string);//write with sanatisation //untell null
				//void DataWriteNQ($string,unsigned int len);//write with santization //untel len reached //IGNORE NULLS
			//WITH QUOTES
				//UNSANATIZED
					//void ColWrite($string);//write without sanitization //WITH QUOTES //FOR SAFE VARABLES ONLY
				//SANATIZED
					//void ValueWrite($string);//write with sanatisation //WITH QUOTES //untell null
					//void DataWrite($string,unsigned int len);//write with santization //WITH QUOTES //untel len reached //IGNORE NULLS
			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
//public:	//BUFFER MERGE
			//void            writeBUFFER(SQLgen& data);
			//void            writeBUFFER(SQLgen* data);
			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
	//OPERATORS		//OPERATORS		//OPERATORS		//OPERATORS		//OPERATORS		//OPERATORS
//public:
		//SQLgen& operator=(SQLgen& from); //will return a refrence to the current instance of this class
		//char &operator      [](int index);
		//char& operator[](int index); //allows for using the [] operator with the ByteBuffer
			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
	//GET DATA
		#ifdef _SQL_NO_DBG_
		#define _SQL_LOW_DBG_
		#endif
		#ifdef _SQL_NO_DBG_
		#define _SQL_LOW_DBG_
		#endif

		#ifdef _SQL_LOW_DBG_
		#define c_strmute c_str //terminates unfinished querrys  adds ending null and retuns the pointer
		#else
		#define c_strdbg c_str //terminates unfinished querrys  adds ending null and retuns the pointer prints query
		#endif
		//const char * c_strdbg();//terminates unfinished querrys  adds ending null and retuns the pointer prints query to screen
		//const char * c_strmute();//terminates unfinished querrys  adds ending null and retuns the pointer
		//void clearAll();
			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
	//OTHER
//public:
	//INCLUDE SQL functions
		//#include	"SQLgenSQL.h"


			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
			//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS

			//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS		//SQL FUNCTIONS
//private:
		//char numBuffer[51];//size of uint64 + some extra  size to handle a float
		#define numBufferSize 50
			//S
			//P
			//A
			//C
			//E
			//-------------------------------------------------------------------------------------------------------
//statement varables are 35# 36$ 37% 38&
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//SELECT		//SELECT		//SELECT		//SELECT		//SELECT		//SELECT		//SELECT
function selectCol1()//STEP 1 //SELECT
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectClause);
}
function selectCol2($fromtable)//STEP 2 ADD STDCSV TABLE LIST BEFORE USING//FROM `v`//USE SELECTCOL(); FIRST
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectClause);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectClause);
}
function select($fromtable)//STEP 1//SELECT * FROM `v`
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectClauseFull);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectClauseFull);
}
function selectCount($fromtable)//STEP 1//SELECT * FROM `v`
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectCountFull);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectCountFull);
}
/*function selectCount($colname,$fromtable)//STEP 1//SELECT * FROM `v`
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectCount);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_selectCount);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectCount);
}*/
function selectDistinct($colname,$fromtable)//STEP 1//SELECT * FROM `v`
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectDistinct);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_selectDistinct);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectDistinct);
}
function selectDistincts()//STEP 1//SELECT DISTINCT #
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectDistinct);
}
function selectDistinctsFrom($fromtable)//STEP 1//FROM # USE GROUP BY TO DEFINE THE COL TO DESTINCT BY OR WHOLE ROWS WILL BE USED
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_selectDistinct);
	$this->ColWrite($fromtable);
	$this->ClauseWrite($SQLGEN_selectDistinct);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//HIGH LEVAL INPUT		//HIGH LEVAL INPUT		//HIGH LEVAL INPUT		//HIGH LEVAL INPUT		//HIGH LEVAL INPUT
 function ColWrite($string)//write without sanitization //WITH QUOTES //FOR SAFE VARABLES ONLY
{
	include 'SQLStatements.php';
	if($this->colquote) $this->_buffer[$this->_WritePos]=$SQLGEN_stdVarableIsolator;$this->_WritePos++;
	$this->ColWriteNQ($string);
	if($this->colquote) $this->_buffer[$this->_WritePos]=$SQLGEN_stdVarableIsolator;$this->_WritePos++;
}
 function ValueWrite($string)//write with sanatisation //WITH QUOTES //untell null
{
	include 'SQLStatements.php';
	if(is_string($string))
	{
		$this->_buffer[$this->_WritePos]=$SQLGEN_stdDataIsolator;$this->_WritePos++;
		$this->ValueWriteNQ($string);
		$this->_buffer[$this->_WritePos]=$SQLGEN_stdDataIsolator;$this->_WritePos++;
	}
	else $this->ValueWriteNQ((string)$string);
}
 function DataWrite($string,$len)//write with santization //WITH QUOTES //untel len reached //IGNORE NULLS
{
	include 'SQLStatements.php';
	$this->_buffer[$this->_WritePos]=$SQLGEN_stdDataIsolator;$this->_WritePos++;
	DataWriteNQ($string,len);
	$this->_buffer[$this->_WritePos]=$SQLGEN_stdDataIsolator;$this->_WritePos++;
}

 function noColquote()
{
	$this->colquote = false;
}
 function yesColquote()
{
	$this->colquote = true;
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E

function ClauseWriteSpecial($string)//write using global scoop to buffer //stop at  # $ % & //resume a write bypassing  # $ % &
{
	$this->insertNotFinished = false;
	$this->checkclearCSV();
	$this->_scoop=0;
	//echo "x".$string."x";
	include 'SQLStatements.php';
	//string < 35 or string > 38

	while(@(NULL != (string)$string[$this->_scoop] && (string)$string[$this->_scoop]!= '#' ))
	{
		//echo $string[$this->_scoop];
		//makefit(1);
		(string)$this->_buffer[$this->_WritePos] = (string)$string[$this->_scoop];
		$this->_scoop++;
		$this->_WritePos++;
	}
	if(@(NULL != (string)$string[$this->_scoop]))
	{
		$this->_scoop++;//bypass what stopped it from moving on unless it was a null
	}
	//echo "<br>X".$this->_buffer;//shuld say SELECT   but says  Array instead
	//skip 35# 36$ 37% 38&
	$this->checkclearCSV();
	$this->_scoop=0;
}

function ClauseWrite($string)//write using global scoop to buffer //stop at  # $ % & //resume a write bypassing  # $ % &
{
	//echo "x".$string."x";
	include 'SQLStatements.php';
	//string < 35 or string > 38
	
	while(@(NULL != (string)$string[$this->_scoop] && (string)$string[$this->_scoop]!= '#' ))
	{
		//echo $string[$this->_scoop];
		//makefit(1);
		(string)$this->_buffer[$this->_WritePos] = (string)$string[$this->_scoop];
		$this->_scoop++;
		$this->_WritePos++;
	}
	if(@(NULL != (string)$string[$this->_scoop]))
	{
		$this->_scoop++;//bypass what stopped it from moving on unless it was a null
	}
	//echo "<br>X".$this->_buffer;//shuld say SELECT   but says  Array instead
	//skip 35# 36$ 37% 38&
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//LOW LEVAL INPUT		//LOW LEVAL INPUT		//LOW LEVAL INPUT		//LOW LEVAL INPUT		//LOW LEVAL INPUT
function ColWriteNQ($string)//write without sanitization //untell null //FOR SAFE VARABLES ONLY
{
	include 'SQLStatements.php';
	//$i;
	$i=0;
	while(@(NULL != $string[$i]))
	{
		//makefit(1);
		$this->_buffer[$this->_WritePos] = $string[$i];
		$i++;
		$this->_WritePos++;
	}
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function ValueWriteNQ($string)//write with sanatisation //untell null
{
	include 'SQLStatements.php';
	//$i;
	$i=0;
	while(@(NULL != $string[$i]))
	{
		//makefit(1);
		//_buffer[$this->_WritePos] = $string[$i];
		//i++;
		//_WritePos++;
		if($string[$i] == '\"')
		{
			//makefit(2);//ya wer writing 2 now
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = SQLGEN_stdDataIsolator;//"
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\'')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\'';//'
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '�')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '�';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '�')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '�';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\\')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\\';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\n')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\n';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\r')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\r';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == NULL)
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = NULL;
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\0')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\0';
			$i++;
			$this->_WritePos++;
		}
		else
		{
			//makefit(1);
			$this->_buffer[$this->_WritePos] = $string[$i];
			$i++;
			$this->_WritePos++;
		}
	}
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function DataWriteNQ($string,$len)//write with santization //untel len reached //IGNORE NULLS
{
	include 'SQLStatements.php';
	//$i;
	$i=0;
	while($i > $len)//because if its = to then wer 1 beond the right len
	{
		if($string[$i] == '\"')
		{
			//makefit(2);//ya wer writing 2 now
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = SQLGEN_stdDataIsolator;//"
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\'')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\'';//'
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '�')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '�';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '�')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '�';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\\')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\\';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\n')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\n';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\r')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\r';
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == NULL)
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = NULL;
			$i++;
			$this->_WritePos++;
		}
		else if($string[$i] == '\0')
		{
			//makefit(2);
			$this->_buffer[$this->_WritePos] = '\\';
			$this->_WritePos++;
			$this->_buffer[$this->_WritePos] = '\0';
			$i++;
			$this->_WritePos++;
		}
		else
		{
			//makefit(1);
			$this->_buffer[$this->_WritePos] = $string[$i];
			$i++;
			$this->_WritePos++;
		}
	}
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//CSV			//CSV			//CSV			//CSV			//CSV			//CSV			//CSV
 function setCSV()//STEP 1 // sets csvon
{
	$this->csvon = true;
}
// void SQLgen::andEquilTo(char* colname,char* value,unsigned int size)
function addCSVcol($col)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ColWrite($col);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}
function addCSVAutoincrment()//adds a autoincrment varable to the values section  aka a null or ""
{
	include 'SQLStatements.php';
	$this->csvon = true;
	$this->ColWriteNQ($SQLGEN_autoIncrment);
}
function addCSVCurrentTimestamp()//adds a autoincrment varable to the values section  aka a null or ""
{
	include 'SQLStatements.php';
	$this->csvon = true;
	$this->ColWriteNQ($SQLGEN_currentTimestampFunction);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
	//addCSV(&currentTimestampFunction[0]);
}
function addCSVdata($data,$len)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	DataWrite($data[0],len);
	$this->ColWriteNQ($stdCSVseprator);
}
function addCSVvalue($value)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	
	$this->ValueWrite($value);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}
function addCSVnumber($value)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	if(!isset($value) || $value == "")$this->ValueWrite($value);
	else $this->ValueWriteNQ(strval($value));
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}
function addCSVDateSql($year, $month, $day)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{//$SQLGEN_stdDate = "#-$-%";
	$this->addCSVDate($month, $day, $year);
}
function addCSVDate($month, $day, $year)//STEP 2[STEP 2[STEP 2]]...//SELECT * FROM `v`c
{//$SQLGEN_stdDate = "#-$-%";
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ClauseWrite($SQLGEN_values);
	$this->ValueWriteNQ(strval($value));
	$this->ClauseWrite($SQLGEN_values);
	$this->ValueWriteNQ(strval($value));
	$this->ClauseWrite($SQLGEN_values);
	$this->ValueWriteNQ(strval($value));
	$this->ClauseWrite($SQLGEN_values);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}

 function checkclearCSV()//checks for csvon if on   clear and back 1 char in the buffer
{
	include 'SQLStatements.php';
	if($this->csvon)
	{
		$this->csvon=false;
		if($SQLGEN_stdCSVsepratorYes)
		{
			$this->_WritePos--;
			//if($this->_WritePos < 0)
			$this->_buffer[$this->_WritePos]=' ';//swap comma for space
			$this->_WritePos++;
		}
	}
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 //-------------------------------------------------------------------------------------------------------------------
//INSERT		//INSERT		//INSERT		//INSERT		//INSERT		//INSERT		//INSERT
 function insertFull($intoTable)//INSERT INTO `#` VALUES (
 {
 	include 'SQLStatements.php';
	$this->insertNotFinished = true;
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_insertClauseFull);
	$this->ColWrite($intoTable);
	$this->ClauseWrite($SQLGEN_insertClauseFull);
 }
 function replacePartialINSERT($intoTable)//REPLACE INTO # (
 {
 	include 'SQLStatements.php';
 	$this->insertNotFinished = true;
 
 	$this->_scoop=0;
 	$this->checkclearCSV();
 	$this->ClauseWrite($SQLGEN_replace);
 	$this->ColWrite($intoTable);
 	$this->ClauseWrite($SQLGEN_replace);
 }
function insertPartialINSERT($intoTable)//INSERT INTO # (
 {
 	include 'SQLStatements.php';
	$this->insertNotFinished = true;

	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_insert);
	$this->ColWrite($intoTable);
	$this->ClauseWrite($SQLGEN_insert);
 }
function insertPartialVALUES()// ) VALUES(
 {
 	include 'SQLStatements.php';
	$this->insertNotFinished = true;

	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_values);


 }
function insertEnd()// );
 {
 	include 'SQLStatements.php';
	$this->insertNotFinished=true;
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_insertClauseEnd);
 }

//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
  //-------------------------------------------------------------------------------------------------------------------
//UPDATE		//UPDATE		//UPDATE		//UPDATE		//UPDATE		//UPDATE		//UPDATE
function updateOneNum($table,$col,$number)//UPDATE `#` SET `$` = % ;
{
	include 'SQLStatements.php';//"UPDATE # SET # = # ";
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($table);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($col);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ValueWriteNQ(strval($number));
	$this->ClauseWrite($SQLGEN_updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function updateOne($table,$col,$newData)//UPDATE `#` SET `$` = '%' ;
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($table);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($col);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ValueWrite($newData);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function update($table)///UPDATE `#` SET `$` = '%' ;
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($table);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	///ColWrite($col);
	//ClauseWrite($updateClauseOne);
	///ValueWrite($newData);
	//ClauseWrite($updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function setValueNQ($colname,$value)// col = val,
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ColWrite($colname);
	//set equal  =
	$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[0];
	$this->_WritePos++;
	$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[1];
	$this->_WritePos++;
	$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[2];
	$this->_WritePos++;
	$this->ValueWriteNQ($value);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}
function setValue($colname,$value)// col = val,
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ColWrite($colname);
	//set equal  =
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[2];
		$this->_WritePos++;
	$this->ValueWrite($value);
	$this->ColWriteNQ($SQLGEN_stdCSVseprator);
}
function setMath($colname,$value,$math)// col = val,
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ColWrite($colname);
	//set equal  =
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[2];
		$this->_WritePos++;
	$this->ValueWrite($value);
	$this->_buffer[$this->_WritePos] = ' ';
	$this->_WritePos++;
	$this->ColWriteNQ($math);
	$this->_buffer[$this->_WritePos] = ' ';
	$this->_WritePos++;
	$this->ColWriteNQ($stdCSVseprator);
}
function setCol($colname,$colname2)// col = val,
{
	include 'SQLStatements.php';
	$this->csvon=true;//IF UNSET SET CSV
	$this->ColWrite($colname);
	//set equal  =
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_updateSetTo[2];
		$this->_WritePos++;
	$this->ColWrite($colname2);
	$this->ColWriteNQ($stdCSVseprator);
}
function update2()//UPDATE `#` SET `$` = '%' ;
{
	include 'SQLStatements.php';
	//_scoop=0;
	$this->checkclearCSV();
	//ClauseWrite($updateClauseOne);
	//ColWrite($table);
	//ClauseWrite($updateClauseOne);
	///ColWrite($col);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	///ValueWrite($newData);
	//ClauseWrite($updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function update3()//UPDATE `#` SET `$` = '%' ;
{
	include 'SQLStatements.php';
	//_scoop=0;
	$this->checkclearCSV();
	//ClauseWrite($updateClauseOne);
	//ColWrite($table);
	//ClauseWrite($updateClauseOne);
	///ColWrite($col);
	//ClauseWrite($updateClauseOne);
	///ValueWrite($newData);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//DELETE		//DELETE		//DELETE		//DELETE		//DELETE		//DELETE		//DELETE
function delete($table)//DELETE FROM # 
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_delete);
	$this->ColWrite($table);
	$this->ClauseWrite($SQLGEN_delete);
	///ColWrite($col);
	//ClauseWrite($updateClauseOne);
	///ValueWrite($newData);
	//ClauseWrite($updateClauseOne);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//JOIN		//JOIN		//JOIN		//JOIN		//JOIN		//JOIN		//JOIN
function preJoin()//USE BEFORE STARTING A JOIN STATEMENT
{
	$this->colquote=false;
}
function joinLeft($table2,$mergePoint1,$mergePoint2)//USE preJoin() BEFORE STARTING A JOIN STATEMENT
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_joinLeft);//LEFT JOIN
	$this->ColWrite($table2);//2ND `table` TO JOIN ON TO THE FROM `table` SATEMENT
	$this->ClauseWrite($SQLGEN_joinLeft);//ON
	$this->ColWrite($mergePoint1);//merge method/alignment statement
	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = ' ';
		$this->_WritePos++;
	$this->ColWrite($mergePoint2);
	$this->ClauseWrite($SQLGEN_joinLeft);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//DELETE		//DELETE		//DELETE		//DELETE		//DELETE		//DELETE		//DELETE
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//WHERE			//WHERE			//WHERE			//WHERE			//WHERE			//WHERE			//WHERE

function whereEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = ' ';
		$this->_WritePos++;
		
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function whereLike($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[3];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = ' ';
		$this->_WritePos++;
		
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereNotEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write not equil <> see above on  null compatablty
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
 }
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereLessThan($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(1);//write less than <
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThan[0];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereGreaterThan($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(1);//write greater than >
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThan[0];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereLessThanEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write less than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereGreaterThanEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write greater than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function whereColEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = ' ';
		$this->_WritePos++;
		
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereColNotEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write not equil <> see above on  null compatablty
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
 }
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereColLessThan($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(1);//write less than <
		$this->_buffer[$this->_WritePos] = $lessThan[0];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereColGreaterThan($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(1);//write greater than >
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThan[0];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereColLessThanEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write less than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function whereColGreaterThanEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_whereClause);
	//makefit(2);//write greater than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[1];
		$this->_WritePos++;
	$this->ClauseWrite($SQLGEN_whereClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_whereClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 //-------------------------------------------------------------------------------------------------------------------
//AND		//AND		//AND		//AND		//AND		//AND		//AND		//AND		//AND		//AND		//AND

function andEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
function andEquilToNQ($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(3);//write  equil  <=> null compatable
	/*
	This operator performs an equality comparison like the = operator,
	but returns 1 rather than NULL if both operands are NULL,
	and 0 rather than NULL if one operand is NULL.
	*/
	$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
	$this->_WritePos++;
	$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
	$this->_WritePos++;
	$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
	$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWriteNQ($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
function orEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_orClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_orClause);

	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_orClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_orClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function orLike($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_orClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_orClause);

	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[3];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_orClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_orClause);
}

function andLike($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[2];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_like[3];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andNotEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write not equil <> see above on  null compatablty
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andLessThan($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(1);//write less than <
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThan[0];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andGreaterThan($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(1);//write greater than >
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThan[0];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andLessThanEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write less than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andGreaterThanEquilTo($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write greater than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWrite($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
function andGreaterThanEquilToNQ($colname,$value)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write greater than or =
	$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[0];
	$this->_WritePos++;
	$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[1];
	$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ValueWriteNQ($value);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
function andColEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(3);//write  equil  <=> null compatable
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[1];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_equalTo[2];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andColNotEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write not equil <> see above on  null compatablty
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_notEqualTo[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andColLessThan($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(1);//write less than <
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThan[0];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andColGreaterThan($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(1);//write greater than >
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThan[0];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andColLessThanEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write less than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_lessThanOrEqual[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
 function andColGreaterThanEquilTo($colname,$colname2)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname);
	$this->ClauseWrite($SQLGEN_andClause);

	//makefit(2);//write greater than or =
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[0];
		$this->_WritePos++;
		$this->_buffer[$this->_WritePos] = $SQLGEN_greaterThanOrEqual[1];
		$this->_WritePos++;

	$this->ClauseWrite($SQLGEN_andClause);
	$this->ColWrite($colname2);
	$this->ClauseWrite($SQLGEN_andClause);
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//GROUPBY		//GROUPBY		//GROUPBY		//GROUPBY		//GROUPBY		//GROUPBY		//GROUPBY		//GROUPBY
//GROUP BY
//SELECT year, country, product, SUM(profit) FROM sales GROUP BY year, country, product WITH ROLLUP;
	//const static char groupBy()//groupBy//GROUP BY csv
	//const static char groupBy()//groupBy//GROUP BY `VALUE`
	//const static char groupNoSort()//groupNoSort//ORDER BY NULL
	//const static char groupAddOrder()//groupAddOrder(bool direction) true=assending false=desending//ASC / DESC
	//const static char groupAddRollup()//groupAddRollup//WITH ROLLUP
function groupBy($colname,$assending)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_groupBy);
	$this->ColWrite($colname);
	$this->_scoop=0;
	if( $assending == "none")
	{
		
	}		
	else if($assending == true)
	{
		$this->ClauseWrite($SQLGEN_assending);
	}
	else
	{
		$this->ClauseWrite($SQLGEN_desending);
	}		
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//ORDERBY		//ORDERBY		//ORDERBY		//ORDERBY		//ORDERBY		//ORDERBY		//ORDERBY		//ORDERBY
//ORDER BY
	//const static char //orderBy(bool direction)//ORDER BY csv
	//const static char //orderBy(bool direction)//ORDER BY `VALUE`
	//const static char //orderAddOrder(bool direction) true=assending false=desending//ORDER BY NULL
function orderBy($colname,$assending)
{
	include 'SQLStatements.php';
	$this->checkclearCSV();
	$this->_scoop=0;
	$this->ClauseWrite($SQLGEN_orderBy);
	$this->ColWrite($colname);
	$this->_scoop=0;
	if($assending == true)
	{
		$this->ClauseWrite($SQLGEN_assending);
	}
	else
	{
		$this->ClauseWrite($SQLGEN_desending);
	}		
}
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT		//LIMIT
/*
function limit()
{
}
function updateOneNum($table,$col,$number)//UPDATE `#` SET `$` = % ;
{
	include 'SQLStatements.php';//"UPDATE # SET # = # ";
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($table);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ColWrite($col);
	$this->ClauseWrite($SQLGEN_updateClauseOne);
	$this->ValueWriteNQ(strval($number));
	$this->ClauseWrite($SQLGEN_updateClauseOne);
}
*/
function limit($noMoreRowsThan)
{
	include 'SQLStatements.php';
	$this->_scoop=0;
	$this->checkclearCSV();
	$this->ClauseWrite($SQLGEN_limitClause);
	$this->ValueWriteNQ(strval(0));
	$this->ClauseWrite($SQLGEN_limitClause);
	$this->ValueWriteNQ(strval($noMoreRowsThan));
	$this->ClauseWrite($SQLGEN_limitClause);
}
/*
function limit($noMoreRowsThan,$startingWithRow)
{
}
*/
//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//OPTIMISATIONS		//OPTIMISATIONS		//OPTIMISATIONS		//OPTIMISATIONS		//OPTIMISATIONS		//OPTIMISATIONS
function bigresult()//use only if expecting large result applys SQL_BUFFER_RESULT and SQL_BIG_RESULT(TODO)
{
}
		//not needed unless the sql server will be bussy doing somthing
		//grabs all data needed right away and then releases its lock on the table  allowing the next
		//querry to run

//F
//U
//N
//C
//T
//I
//O
//N
///DO NOT REMOVE
//S
//P
//A
//C
//E
//-------------------------------------------------------------------------------------------------------------------
//GET DATA
function enddbg()
{
	include 'SQLStatements.php';
	if($this->insertNotFinished)
	{
		$this->insertNotFinished=false;
		$this->insertEnd();
	}
	if($this->notFinished)
	{
		$this->notFinished=false;
		$this->ColWriteNQ($SQLGEN_stdQueryEnd);//close query ;
	}
	$this->colquote=true;
	//$this->_buffer[$this->_WritePos]=0;//null termnate but dont incrment write position so one can still add data like normal
	echo "<br>SQLgENdBG| ".$this->_buffer." |SQLgENdBG<br>";
	//$this->_buffer[0];
}
function end()
{
	include 'SQLStatements.php';
	if($this->insertNotFinished)
	{
		$this->insertNotFinished=false;
		$this->insertEnd();
	}
	if($this->notFinished)
	{
		$this->notFinished=false;
		$this->ColWriteNQ($SQLGEN_stdQueryEnd);//close query ;
	}
	$this->colquote=true;
	//$this->_buffer[$this->_WritePos]=NULL;//null termnate but dont incrment write position so one can still add data like normal
	//printf("\nSQL %s SQL\n",_buffer);
	//return & _buffer[0];
}
}
?>