#include <iostream>
#include <fstream>
#include <stdio.h>
#include <string>
#include <string.h>
#include <vector>
#include <unistd.h>

#define studenti_prezenti "studenti_prezenti.txt" // lista cu studentii recunoscuti de script.py (acetia au si cont)
// NUME PRENUME1 [PRENUME2] 
#define lista_studenti "lista_studenti.txt" // lista cu toti studentii care trebuie sa dea examenul
// NUME PRENUME1 [PRENUME2] [PROBA] [SALA]

using namespace std;

struct Student {
	int id;
	string nume;
	string prenume;
	string proba;
	string sala;

	bool isPresent = false;
};

struct StudPrez {
	string nume;
	string prenume;
};

int existsInVector(vector<Student> vStud, string nume, string prenume)
{
	for (int i = 0; i < vStud.size(); i++)
	{
		if (vStud[i].nume == nume)
			return vStud[i].id;
		else if (vStud[i].prenume == prenume)
			return vStud[i].id;
	}
	return -1;
}

void printBegin()
{
	cout << "id\tNUME\tPRENUME\tPROBA\tSALA\n";
}

void goUp(int nrLines)
{
	for(int i = 0; i < nrLines; i++)
		cout << "\033[A";
}

void printVectorGreen(vector<Student> vStd, int id)
{
	
	for (int i = 0; i < vStd.size(); i++)
	{
		Student std = vStd[i];

		if (std.isPresent == true)
		{
			cout << "\033[1;32m";
			cout << std.id << "\t" << std.nume << "\t\t" << std.prenume << "\t\t" << std.proba << "\t\t" << std.sala << "\n";
			cout << "\033[0m";
	
		}
		else
		{
			cout << "\033[1;31m";
			cout << std.id << "\t" << std.nume << "\t\t" << std.prenume << "\t\t" << std.proba << "\t\t" << std.sala << "\n";
			cout << "\033[0m";
		}

	}
}

int main()
{
	ifstream file1, file2;

	string line_file1;
	string line_file2;

	string garbage;
	vector<Student> vector_studenti;
	vector<StudPrez> vector_stdPrez;

	int id = 1;

	file1.open(studenti_prezenti);
	file2.open(lista_studenti);

	for (int i = 0; i < 10; i++)
	{
		getline(file2, garbage);
		if (garbage == "")
			continue;
		char buffer[256];
		strcpy(buffer,garbage.c_str());
		buffer[strlen(buffer)] = '\0'; // sau -2 
		printf("%s\t", buffer);
	}

	printf("\n");

 	while (!file2.eof())
	{
		Student std;
		std.id = id++;
		getline(file2, garbage);
		std.nume = garbage;
		getline(file2, garbage);
		getline(file2, garbage);
		std.prenume = garbage;
		getline(file2, garbage);
		getline(file2, garbage);
		std.proba = garbage;
		getline(file2, garbage);
		getline(file2, garbage);
		std.sala = garbage;
		getline(file2, garbage);

		cout << "\033[1;31m";
		cout << std.id << "\t" << std.nume << "\t\t" << std.prenume << "\t\t" << std.proba << "\t\t" << std.sala << "\n";
		cout << "\033[0m";

		vector_studenti.push_back(std);
	}

	file2.open(lista_studenti);
	
	while (1)
	{
		while (!file1.eof())
		{
			StudPrez stdP;

			string temp;
			file1 >> garbage;
			stdP.nume = garbage;
			file1 >> garbage;
			temp = garbage;
			file1 >> garbage;
			temp += " " + garbage;

			stdP.prenume = temp;
			int id = existsInVector(vector_studenti, stdP.nume, stdP.prenume);
			if (id != -1)
			{
				//system("clear");
				goUp(vector_studenti.size()+1);
				vector_studenti[id - 1].isPresent = true;
				printBegin();
				printVectorGreen(vector_studenti, id);
				sleep(1);
				//system("clear");
			}

		
		}
		file1.clear();
		file1.seekg(0);
	}

return 1;
}
