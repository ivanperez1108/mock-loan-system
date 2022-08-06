# mock-loan-system

This is a mock loan system REST API that can do basic operations. The url for this api is https://mock-loan-system.herokuapp.com/. Below are the endpoints that you can hit:

```
/create-loan
type: POST
body:
  float amount // The amount of the loan
  float interest_rate // The interest rate of the loan
  int length // The length of the loan in months
response: JSON
  {
    "success":true|false,
    "loan":
      {
        "id": int, // Unique identifier for the loan
        "amount": float, // Amount of the loan
        "interest_rate": float, // Interest rate of the loan
        "length": int, // Length of loan in months
        "payment": float // Monthly payment for the loan
      }
  }
  
  
/get-loan
type: GET
body:
  int id // The id of the loan you want to grab
response: JSON
  {
    "success":true|false,
    "loan":
      {
        "id": int, // Unique identifier for the loan
        "amount": float, // Amount of the loan
        "interest_rate": float, // Interest rate of the loan
        "length": int, // Length of loan in months
        "payment": float // Monthly payment for the loan
      }
  }


/update-loan
type: POST
body:
  int id // The id of the loan you want to grab
  float amount // The amount of the loan
  float interest_rate // The interest rate of the loan
  int length // The length of the loan in months
 response: JSON
  {
    "success":true|false,
    "loan":
      {
        "id": int, // Unique identifier for the loan
        "amount": float, // Amount of the loan
        "interest_rate": float, // Interest rate of the loan
        "length": int, // Length of loan in months
        "payment": float // Monthly payment for the loan
      }
  }
  
```
