#include <iostream>
#include <iomanip>
#include <string>
#include <vector>
#include "Habibit.h"

using namespace std;

// Function prototypes
void displayMainMenu();
void createAccount(vector<string>& accounts);
bool signIn(const vector<string>& accounts);
void lenderMenu(Lender& lender);
void addEquipment(Lender& lender);
void borrowerMenu(Lender& lender, Borrower& borrower);
void borrowEquipment(Lender& lender, Borrower& borrower);
void displayEquipment(const Lender& lender);
void checkout(const Lender& lender, const Borrower& borrower);



int main() {
    Lender lender;
    Borrower borrower;
    vector<string> accounts;

    while (true) {
        displayMainMenu();
        int choice;
        cin >> choice;

        switch (choice) {
            case 1:
                createAccount(accounts);
                break;
case 2:
    if (signIn(accounts)) {
        cout << "Sign in successful!\n";
        while (true) {
            cout << "Choose an option:\n";
            cout << "1. Lender Menu\n";
            cout << "2. Borrower Menu\n";
            cout << "3. Logout\n";
            cin >> choice;

            if (choice == 1) {
                lenderMenu(lender);
            } else if (choice == 2) {
                borrowerMenu(lender, borrower);
            } else if (choice == 3) {
                cout << "Logging out...\n";
                break;
            } else {
                cout << "Invalid choice. Please select a valid option (1, 2, or 3).\n";
            }
        }
    } else {
        cout << "Sign-in failed. Please try again.\n";
    }
    break;
            case 3:
                return 0; // Exit the program
            default:
                cout << "Invalid choice. Please select a valid option (1, 2, or 3)." << endl;
        }
    }

    return 0;
}

void displayMainMenu() {
    cout << "Main Menu:\n";
    cout << "1. Create Account\n";
    cout << "2. Sign In\n";
    cout << "3. Exit\n";
}

void createAccount(vector<string>& accounts) {
    string username, password;
    cout << "Create Account\n";
    cout << "Enter username: ";
    cin >> username;
    cout << "Enter password: ";
    cin >> password;
    accounts.push_back(username + ":" + password);
    cout << "Account created successfully.\n";
}

bool signIn(const vector<string>& accounts) {
    string username, password;
    cout << "Sign In\n";
    cout << "Enter username: ";
    cin >> username;
    cout << "Enter password: ";
    cin >> password;
    string account = username + ":" + password;
    for (const string& storedAccount : accounts) {
        if (storedAccount == account) {
            return true; // Sign-in successful
        }
    }
    return false; // Sign-in failed
}

void lenderMenu(Lender& lender) {
    while (true) {
        cout << "Lender Menu:\n";
        cout << "1. Add Equipment\n";
        cout << "2. Display Equipment\n";
        cout << "3. Back to Main Menu\n";
        int choice;
        cin >> choice;

        switch (choice) {
            case 1:
                addEquipment(lender);
                break;
            case 2:
                displayEquipment(lender);
                break;
            case 3:
                return; // Return to the main menu
            default:
                cout << "Invalid choice. Please select a valid option (1, 2, or 3).\n";
        }
    }
}

void addEquipment(Lender& lender) {
    string name, modelName;
    double costPerDay;

    cout << "Enter equipment name: ";
    cin.ignore();
    getline(cin, name);
    cout << "Enter model name: ";
    getline(cin, modelName);
    cout << "Enter cost per day: ";
    cin >> costPerDay;

    Equipment equipment(name, modelName, costPerDay);
    lender.addEquipment(equipment);
    cout << "Equipment added successfully.\n";
}

void borrowerMenu(Lender& lender, Borrower& borrower) {
    while (true) {
        cout << "Borrower Menu:\n";
        cout << "1. Borrow Equipment\n";
        cout << "2. Checkout\n";
        cout << "3. Back to Main Menu\n";

        int choice;
        cin >> choice;

        switch (choice) {
            case 1:
                borrowEquipment(lender, borrower);
                break;
            case 2:
                checkout(lender, borrower);
                return;
                break;
            case 3:
                return; // Return to the main menu
            default:
                cout << "Invalid choice. Please select a valid option (1 or 2).\n";
        }
    }
}

void borrowEquipment(Lender& lender, Borrower& borrower) {
    displayEquipment(lender);

    cout << "Choose equipment to borrow (enter equipment numbers separated by spaces, 0 to finish):\n";
    vector<int> choices;
    int choice;

    while (cin >> choice) {
        if (choice == 0) {
            break;  // Exit the loop if 0 is entered
        }

        if (choice > 0 && choice <= lender.equipmentList.size()) {
            choices.push_back(choice);
        } else {
            cout << "Invalid choice. Please enter a valid equipment number or 0 to finish: ";
        }
    }

    cout << "Enter the number of days to rent: ";
    cin >> borrower.daysToRent;

    cout << "Selected Equipment:\n";
    double totalCost = 0.0;

    for (int choice : choices) {
        Equipment equipment = lender.equipmentList[choice - 1];
        totalCost += equipment.costPerDay * borrower.daysToRent;
        borrower.borrowedEquipment.push_back(equipment);

        cout << equipment.name << " (" << equipment.modelName << ") - Cost per day: $" << equipment.costPerDay << " - Days to rent: " << borrower.daysToRent << endl;
    }

    cout << fixed << setprecision(2);
    cout << "Total Cost (including 2.5% tax): $" << totalCost << endl;
    cout << "This will be delivered to you in 5 days." << endl;

    // Clear the choices vector for the next borrower
    choices.clear();
}
void displayEquipment(const Lender& lender) {
    cout << "Equipment List:\n";

    if (lender.equipmentList.empty()) {
        cout << "No equipment available.\n";
    } else {
        for (int i = 0; i < lender.equipmentList.size(); i++) {
            const Equipment& equipment = lender.equipmentList[i];
            cout << i + 1 << ". " << equipment.name << " (" << equipment.modelName << ") - Cost per day: $" << equipment.costPerDay << endl;
        }
    }
}
void checkout(const Lender& lender, const Borrower& borrower) {
    cout << "Checkout Page:\n";

    if (borrower.borrowedEquipment.empty()) {
        cout << "No equipment selected for rental.\n";
        return;
    }

    cout << "Selected Equipment:\n";
    double totalCost = 0.0;

    for (const Equipment& equipment : borrower.borrowedEquipment) {
        cout << equipment.name << " (" << equipment.modelName << ") - Cost per day: $" << equipment.costPerDay << " - Days to rent: " << borrower.daysToRent << endl;
        totalCost += equipment.costPerDay * borrower.daysToRent;
    }

    cout << fixed << setprecision(2);
    cout << "Total Cost (including 2.5% tax): $" << totalCost << endl;

    // Add code here to implement the payment and confirmation process.
    // You can prompt the borrower for payment information and confirm the rental.

    cout << "Rental confirmed! Your equipment will be delivered to you in 5 days." << endl;
}
