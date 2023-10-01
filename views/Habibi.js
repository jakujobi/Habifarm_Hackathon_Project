class Equipment {
    constructor(name, modelName, costPerDay) {
      this.name = name;
      this.modelName = modelName;
      this.costPerDay = costPerDay;
    }
  }
  
  class Lender {
    constructor() {
      this.equipmentList = [];
    }
  
    addEquipment(equipment) {
      this.equipmentList.push(equipment);
    }
  }
  
  class Borrower {
    constructor() {
      this.borrowedEquipment = [];
      this.daysToRent = 0;
    }
  
    calculateTotalCost() {
      let totalCost = 0;
      for (const equipment of this.borrowedEquipment) {
        totalCost += equipment.costPerDay;
      }
      return totalCost + totalCost * 0.025; // Apply 2.5% tax
    }
  }
  
  function displayMainMenu() {
    console.log("Main Menu:");
    console.log("1. Create Account");
    console.log("2. Sign In");
    console.log("3. Exit");
  }
  
  // Account is an array
  function createAccount(accounts) {
    const username = prompt("Enter username: ");
    const password = prompt("Enter password: ");
    accounts.push(username + ":" + password);
    console.log("Account created successfully.");
  }
  
  // sign in
  function signIn(accounts) {
    const username = prompt("Enter username: ");
    const password = prompt("Enter password: ");
    const account = username + ":" + password;
    for (const storedAccount of accounts) {
      if (storedAccount === account) {
        return true; // Sign-in successful
      }
    }
    return false; // Sign-in failed
  }
  
  function lenderMenu(lender) {
    while (true) {
      console.log("Lender Menu:");
      console.log("1. Add Equipment");
      console.log("2. Display Equipment");
      console.log("3. Back to Main Menu");
  
      const choice = prompt("Enter your choice: ");
  
      switch (choice) {
        case "1":
          addEquipment(lender);
          break;
        case "2":
          displayEquipment(lender);
          break;
        case "3":
          return; // Return to the main menu
        default:
          console.log("Invalid choice. Please select a valid option (1, 2, or 3).");
      }
    }
  }
  
  function addEquipment(lender, name, costPerDay, modelName) {
    //const name = prompt("Enter equipment name: ");
    //const modelName = prompt("Enter model name: ");
    //const costPerDay = parseFloat(prompt("Enter cost per day: "));
  
    const equipment = new Equipment(name, modelName, costPerDay);
    lender.addEquipment(equipment);
    console.log("Equipment added successfully.");
  }
  
  function borrowerMenu(lender, borrower) {
    while (true) {
      console.log("Borrower Menu:");
      console.log("1. Borrow Equipment");
      console.log("2. Checkout");
      console.log("3. Back to Main Menu");
  
      const choice = prompt("Enter your choice: ");
  
      switch (choice) {
        case "1":
          borrowEquipment(lender, borrower);
          break;
        case "2":
          checkout(lender, borrower);
          break;
        case "3":
          return; // Return to the main menu
        default:
          console.log("Invalid choice. Please select a valid option (1 or 2).");
      }
    }
  }
  
  function borrowEquipment(lender, borrower) {
    displayEquipment(lender);
  
    console.log("Choose equipment to borrow (enter equipment numbers separated by spaces, 0 to finish):");
    const choices = [];
    
    while (true) {
      const choice = parseInt(prompt("Enter your choice (0 to finish): "));
      
      if (choice === 0) {
        break; // Exit the loop if 0 is entered
      }
      
      if (choice > 0 && choice <= lender.equipmentList.length) {
        choices.push(choice);
      } else {
        console.log("Invalid choice. Please enter a valid equipment number or 0 to finish.");
      }
    }
  
    borrower.daysToRent = parseInt(prompt("Enter the number of days to rent: "));
  
    let totalCost = 0;
  
    console.log("Selected Equipment:");
    for (const choice of choices) {
      const equipment = lender.equipmentList[choice - 1];
      totalCost += equipment.costPerDay * borrower.daysToRent;
      borrower.borrowedEquipment.push(equipment);
  
      console.log(`${equipment.name} (${equipment.modelName}) - Cost per day: $${equipment.costPerDay} - Days to rent: ${borrower.daysToRent}`);
    }
  
    console.log("Total Cost (including 2.5% tax): $" + (totalCost + totalCost * 0.025));
    console.log("This will be delivered to you in 5 days.");
  
    choices.length = 0; // Clear the choices array for the next borrower
  }
  
  function displayEquipment(lender) {
    console.log("Equipment List:");
    if (lender.equipmentList.length === 0) {
      console.log("No equipment available.");
    } else {
      for (let i = 0; i < lender.equipmentList.length; i++) {
        const equipment = lender.equipmentList[i];
        console.log(`${i + 1}. ${equipment.name} (${equipment.modelName}) - Cost per day: $${equipment.costPerDay}`);
      }
    }
  }
  
  function checkout(lender, borrower) {
    console.log("Checkout Page:");
  
    if (borrower.borrowedEquipment.length === 0) {
      console.log("No equipment selected for rental.");
      return;
    }
  
    console.log("Selected Equipment:");
    let totalCost = 0;
  
    for (const equipment of borrower.borrowedEquipment) {
      console.log(`${equipment.name} (${equipment.modelName}) - Cost per day: $${equipment.costPerDay} - Days to rent: ${borrower.daysToRent}`);
      totalCost += equipment.costPerDay * borrower.daysToRent;
    }
  
    console.log("Total Cost (including 2.5% tax): $" + (totalCost + totalCost * 0.025));
  
    // Add code here to implement the payment and confirmation process.
    // You can prompt the borrower for payment information and confirm the rental.
  
    console.log("Rental confirmed! Your equipment will be delivered to you in 5 days.");
  }
  
  // Main Program
  const lender = new Lender();
  const borrower = new Borrower();
  const accounts = [];
  
  while (true) {
    displayMainMenu();
    const choice = prompt("Enter your choice: ");
  
    switch (choice) {
      case "1":
        createAccount(accounts);
        break;
      case "2":
        if (signIn(accounts)) {
          console.log("Sign in successful!");
          while (true) {
            console.log("Choose an option:");
            console.log("1. Lender Menu");
            console.log("2. Borrower Menu");
            console.log("3. Logout");
  
            const choice = prompt("Enter your choice: ");
  
            if (choice === "1") {
              lenderMenu(lender);
            } else if (choice === "2") {
              borrowerMenu(lender, borrower);
            } else if (choice === "3") {
              console.log("Logging out...");
              break;
            } else {
              console.log("Invalid choice. Please select a valid option (1, 2, or 3).");
            }
          }
        } else {
          console.log("Sign-in failed. Please try again.");
        }
        break;
      case "3":
        return; // Exit the program
      default:
        console.log("Invalid choice. Please select a valid option (1, 2, or 3).");
    }
  }