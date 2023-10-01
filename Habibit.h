#ifndef HABIBIT_H
#define HABIBIT_H

#include <string>
#include <vector>

using namespace std;

class Equipment {
public:
    string name;
    string modelName;
    double costPerDay;

    Equipment(const string& n, const string& mn, double cpd);
};

class Lender {
public:
    vector<Equipment> equipmentList;

    void addEquipment(const Equipment& equipment);
};

class Borrower {
public:
    vector<Equipment> borrowedEquipment;
    int daysToRent;

    double calculateTotalCost() const;
};


#endif // HABIBIT_H
