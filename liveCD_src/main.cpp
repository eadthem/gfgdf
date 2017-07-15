/*
 * main.cpp
 *
 *  Created on: May 9, 2016
 *      Author: eadthem
 */
#include <stdio.h>
#include <string>
#include <stdint.h>
#include <stdlib.h>
#include <inttypes.h>
#include <cstdio>
#include <time.h>

void writeData(char * string, std::string path, uint64_t position,int speed)
{
	// /dev/sda

	std::string postfix;
	postfix = "/tmp/diskOut";

	for(auto thisChar : path)
	{
		postfix.push_back(thisChar);
		if(thisChar == '/' || thisChar == '\\')
		{
			postfix = "/tmp/diskOut";
			//printf("e");
		}
		
	}
	

	auto fout = fopen(postfix.c_str(),"w");
	if(fout == NULL)
	{
		printf("Invalid file name writing output.  please pass the drive path, (/dev/sda )\n");
		return;
	}
	fprintf(fout,string,path.c_str(),position,speed);
	fclose(fout);

}	

void writeFinalMessage(const char * msg, std::string path)
{
	std::string postfix;
	postfix = "/tmp/diskDone";

	for(auto thisChar : path)
	{
		postfix.push_back(thisChar);
		if(thisChar == '/' || thisChar == '\\')
		{
			postfix = "/tmp/diskDone";
			//printf("e");
		}
		
	}

	
	auto fout = fopen(postfix.c_str(),"w");
	if(fout == NULL)
	{
		printf("Invalid file name writing output.  please pass the drive path, (/dev/sda )\n");
		return;
	}
	fprintf(fout,"%s",msg);
	fclose(fout);
	
}


int main(int argc, char* argv[])
{

	static_assert(UINT64_MAX > SIZE_MAX,"size_t IS TO SMALL.  Disks wont be fully wiped!!!");

	const static char failureMessage[] = "!!!!!DISK FAILURE, DISK FAILURE, DISK FAILURE !!!!!/n!!!!!!!!!!!!!!DRIVE NOT WIPED!!!!!!!!!!!!!!\n";
	const static char passedMessage[] = "===== PASSED,  Drive Erased. v.6.25  PASSED";

	srand (time(NULL));
	const static uint64_t offset = 1048576-10240;//1MB
	//const static uint64_t offset = 1073741-10240;//1MB

	const static int screenRefreshInterval = 100;

	time_t startTime;
		time(&startTime);


	if(argc != 2)
	{
		printf("Invalid argument count.  please pass the drive path, (/dev/sda )\n");
		//writeFinalMessage(failureMessage,path);		
		return -1;
	}
	std::string path = argv[1];

	std::string syncCommand;
	syncCommand="fsync ";
	syncCommand += path;

	auto file = std::fopen(path.c_str(),"r+");
	setvbuf(file,NULL,_IONBF,0);

	if(file == NULL)
	{
		printf("Invalid file name.  please pass the drive path, (/dev/sda )\n");
		writeFinalMessage(failureMessage,path);	
		return -1;
	}
	//bool error = false;
	bool run = true;

	const static int randomDataSize = 1048576;
	char randomData[randomDataSize + 1000];

	for(int i = 0; i < randomDataSize; i++)
	{
		randomData[i] = rand();

	}

	time_t startRWTime;
	time(&startRWTime);

	uint64_t totalRandWrittenMB = 0;
	int j = 0;
	while(true)
	{

		size_t written = std::fwrite(&randomData,1,randomDataSize,file);
		if(written != randomDataSize)
		{
			if(std::ferror(file) == 0)
			{
				writeFinalMessage(failureMessage,path);	
				return 1;
			}
			break;
		}
		if(std::fflush(file) != 0)
		{
			writeFinalMessage(failureMessage,path);	
			return 1;
		}
		totalRandWrittenMB++;


		if(j >= screenRefreshInterval)
		{
			time_t now;
			time(&now);
			int nowElapsed = difftime(now,startRWTime);
			if(nowElapsed == 0)nowElapsed = 1;
			int nowSpeed = (totalRandWrittenMB)/nowElapsed;//x2 for 2 passes,

			j=0;
			writeData("Writing Random data {Pass 1}: %s ; MB Written:%llu %iMBps\n",path,totalRandWrittenMB,nowSpeed);
			system(syncCommand.c_str());
		}
		j++;

	}

	

	std::fseek(file,0,SEEK_SET);


	//system(syncCommand.c_str());


	for(int i = 0; i < randomDataSize; i++)
	{
		randomData[i] = 0;

	}

	uint64_t totalZeroWrittenMB = 0;
	time_t startZWTime;
	time(&startZWTime);
	j = 0;
	while(true)
	{

		size_t written = std::fwrite(&randomData,1,randomDataSize,file);
		if(written != randomDataSize)
		{
			if(std::ferror(file) == 0)
			{
				writeFinalMessage(failureMessage,path);	
				return 1;
			}
			break;
		}
		if(std::fflush(file) != 0)
		{
			writeFinalMessage(failureMessage,path);	
			return 1;
		}
		totalZeroWrittenMB++;
		

		if(j >= screenRefreshInterval)
		{
			time_t now;
			time(&now);
			int nowElapsed = difftime(now,startZWTime);
			if(nowElapsed == 0)nowElapsed = 1;
			int nowSpeed = totalZeroWrittenMB/nowElapsed;//x2 for 2 passes,
			j=0;
			writeData("Overwriteing Zeros  {Pass 2}: %s ; MB Written:%llu %iMBps\n",path,totalZeroWrittenMB,nowSpeed);
			system(syncCommand.c_str());
		}
		j++;

	}

	std::fseek(file,0,SEEK_SET);

	time_t stopTime;
	time(&stopTime);

	int elapsedTimeSeconds = difftime(stopTime,startTime);
	//system(syncCommand.c_str());
	time_t startZVTime;
	time(&startZVTime);
	uint64_t totalZeroTestMB = 0;
	j = 0;
	while(run)
	{
		//read
		for(uint64_t i= 0;i < 10240;i++)
		{
			int val = std::fgetc(file);
			if(val == EOF)
			{
				run = false;
				break;
			}
			if(val != 0)
			{
				writeFinalMessage(failureMessage,path);	
				return 1; //Error
			}
		}
		if(run == false)
		{
			if(std::ferror(file) == 0)
			{
				printf("error reading from file\n");
				writeFinalMessage(failureMessage,path);	
				return 1;  //Error
			}
			break;
		}

		//seek
		if(std::fseek(file,offset,SEEK_CUR) != 0)
		{
			break;
		}
		if(j >= screenRefreshInterval)
		{
			time_t now;
			time(&now);
			int nowElapsed = difftime(now,startZVTime);
			if(nowElapsed == 0)nowElapsed = 1;
			int nowSpeed = (totalZeroTestMB)/nowElapsed;//x2 for 2 passes,
			j=0;
			writeData("Verifying Zeros 10Kb:1MB    : %s ; MB Sampled:%llu %iMBps\n",path,totalZeroTestMB,nowSpeed);
			system(syncCommand.c_str());
		}

		totalZeroTestMB++;

		j++;
	}

	char finalMessage[188];

	if(totalZeroTestMB != totalRandWrittenMB || totalZeroTestMB != totalZeroWrittenMB)
	{
		snprintf(finalMessage,180,"!!!!! FAILURE, Drive size changed between Random Write, Zero Write, and Zero verify. RW%llu ZW%llu ZV%llu FAILURE !!!!!\n!!!!!!!!!!!!!!DRIVE NOT WIPED!!!!!!!!!!!!!!\n",totalRandWrittenMB,totalZeroWrittenMB,totalZeroTestMB);
		writeFinalMessage(finalMessage,path);
		return 1;  //Error
	}


	int minimumAllowedTime = 10*60; //20 Min
	if(elapsedTimeSeconds == 0)elapsedTimeSeconds = 1;
	int speedMBperSec = (totalZeroTestMB*2)/elapsedTimeSeconds;//x2 for 2 passes,

	if(elapsedTimeSeconds < minimumAllowedTime)
	{
		snprintf(finalMessage,120,"!!!!! FAILURE, Drive finished wipeing in to short of a time. FAILURE !!!!!\nElapsed Sec %i < Min Sec %i  !!!!!!!!!!!!!!DRIVE NOT WIPED!!!!!!!!!!!!!!\n",elapsedTimeSeconds,minimumAllowedTime);
		writeFinalMessage(finalMessage,path);
		return 1;  //Error
	}
	else if(speedMBperSec > 120)//Do not exeed 100MB per sec, Or are we really wiping?
	{//This threshold is tight for a reason,  In practice no single drive should be more than 100MBPS
		//as we are counting the verify time, but not its data xfer.
		snprintf(finalMessage,120,"!!!!! FAILURE, Drive impossibly fast, %iMBps > 120MBps FAILURE !!!!!\n!!!!!!!!!!!!!!DRIVE NOT WIPED!!!!!!!!!!!!!!\n",speedMBperSec);
		writeFinalMessage(finalMessage,path);
		return 1;  //Error
	}
	else
	{
		int elapsedTimeMin = elapsedTimeSeconds/60;
		snprintf(finalMessage,120,"%s: in %i Min, %i MBps =====\n",passedMessage,elapsedTimeMin,speedMBperSec);
		writeFinalMessage(finalMessage,path);
	}


	return 0;
}
