#include "Habibit.h"

using namespace std;

Equipment::Equipment(const string& n, const string& mn, double cpd)
    : name(n), modelName(mn), costPerDay(cpd) {}

void Lender::addEquipment(const Equipment& equipment)
{
    equipmentList.push_back(equipment);
}

double Borrower::calculateTotalCost() const
 {
    double totalCost = 0.0;
    for (const Equipment& equipment : borrowedEquipment) {
        totalCost += equipment.costPerDay;
    }
    return totalCost + (totalCost * 0.025); // Apply 2.5% tax
}

