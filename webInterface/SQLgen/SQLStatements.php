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
//#ifndef SQLSTATEMENS_H
//#define SQLSTATEMENS_H
//PORTED FROM C++ BY EADTHEM AKIP

//args  #1 $2 %3 &4
//SELECT
		$SQLGEN_selectClauseFull = "SELECT * FROM # ";//!
		$SQLGEN_selectCountFull = "SELECT COUNT(*) FROM # ";//!
		$SQLGEN_selectCount = "SELECT COUNT(#) FROM # ";//!
		$SQLGEN_selectClause = "SELECT # FROM # ";
		$SQLGEN_selectDistinct = "SELECT DISTINCT # FROM # ";
//WHERE
		$SQLGEN_whereClause = "WHERE # # # ";//!
//AND
		$SQLGEN_andClause = "AND # # # ";//!
//OR
		$SQLGEN_orClause = "OR # # # ";//!
//JOIN
		$SQLGEN_joinLeft = "LEFT JOIN # ON # ";
//DELETE
		$SQLGEN_delete = "DELETE FROM # ";
//INSERT
		$SQLGEN_insertClauseFull = "INSERT INTO # VALUES (";
		$SQLGEN_insert = "INSERT INTO # ( ";
		$SQLGEN_replace = "REPLACE INTO # ( ";
		$SQLGEN_values = " ) VALUES( ";
		$SQLGEN_insertClauseEnd = ")";
		$SQLGEN_autoIncrment = "NULL,";
		$SQLGEN_currentTimestampFunction = "CURRENT_TIMESTAMP";
//UPDATE
		$SQLGEN_updateClauseOne = "UPDATE # SET # = # ";
		$SQLGEN_updateSet = "UPDATE # SET ";
		$SQLGEN_updateSetTo = ' = ';
//OPERATOR
		$SQLGEN_equalTo = "<=>";//!
		/*
		This operator performs an equality comparison like the = operator,
		but returns 1 rather than NULL if both operands are NULL,
		and 0 rather than NULL if one operand is NULL.
		*/
		$SQLGEN_like = "LIKE";
		$SQLGEN_notEqualTo = "<>";
		$SQLGEN_lessThan = "<";
		$SQLGEN_greaterThan = ">";//!
		$SQLGEN_lessThanOrEqual = "<=";
		$SQLGEN_greaterThanOrEqual = ">=";
		$SQLGEN_stdCSVseprator = ",";
		$SQLGEN_stdCSVsepratorYes = true;
		$SQLGEN_stdOtherIsolator = '"';//WILL SANITISE OUT
		$SQLGEN_stdDataIsolator = '\'';//WILL SANITISE OUT
		$SQLGEN_stdVarableIsolator = '`';
		$SQLGEN_stdQueryEnd = ";";
		$SQLGEN_stdDate = " #-#-# ";// # = year 4 diget  $ month    %day   mysql standard 9999-12-31
	//  [] = "<=>";


//GROUP BY
//SELECT year, country, product, SUM(profit) FROM sales GROUP BY year, country, product WITH ROLLUP;
	//  groupByCSV//groupBy//GROUP BY csv
	$SQLGEN_groupBy = "GROUP BY # ";
	//  groupBy//groupBy//GROUP BY `VALUE`
	//  groupNoSort//groupNoSort//ORDER BY NULL
	//  groupAddOrder//groupAddOrder(bool direction) true=assending false=desending//ASC / DESC
	//  groupAddRollup//groupAddRollup//WITH ROLLUP
//ORDER BY
	//orderBy//GROUP BY csv
	$SQLGEN_orderBy = "ORDER BY # ";
	$SQLGEN_assending = "ASC ";
	$SQLGEN_desending = "DESC ";
	//  //orderAddOrder(bool direction) true=assending false=desending//ORDER BY NULL
//LIMIT
	$SQLGEN_limitClause = "LIMIT # , # ";//LIMIT 0 , 200

//#endif
?>