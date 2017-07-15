/*
 * main.cpp
 *
 *  Created on: May 9, 2016
 *      Author: eadthem
 */
#include <stdio.h>
#include <string>


int main(int argc, char* argv[])
{
	const static uint64_t offset = 1048576-10240;//1MB
	//const static uint64_t offset = 1073741-10240;//1MB


	if(argc != 2)
	{
		printf("Invalid argument count.  please pass the drive path, (/dev/sda )\n");
		return -1;
	}
	std::string path = argv[1];

	printf("%s\n",path.c_str());

	auto file = fopen(path.c_str(),"r");

	if(file == NULL)
	{
		printf("Invalid file name.  please pass the drive path, (/dev/sda )\n");
		return -1;
	}
	bool error = false;
	bool run = true;

	int j = 0;
	while(run)
	{
		//read
		for(uint64_t i= 0;i < 10240;i++)
		{
			int val = fgetc(file);
			if(val == EOF)
			{
				run = false;
				break;
			}
			if(val != 0)
			{
				return 1;
			}
		}
		if(run == false)
		{
			if(ferror(file))printf("error reading from file\n");
			break;
		}

		//printf("at = %u000MB\n",j);

		//seek
		if(fseek(file,offset,SEEK_CUR) != 0)
		{
			break;
		}
		j++;
	}


	return 0;
}
