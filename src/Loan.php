<?php

/**
 * This class contains a blueprint for a Loan object
 */
class Loan {
    /** @var int $id The unique identifier of the loan */
    private int $id;

    /** @var float $amount The total amount of the loan */
    private float $amount;

    /** @var float $interestRate The interest rate of the loan */
    private float $interestRate;

    /** @var int $lengthOfLoan The length of the loan in months */
    private int $lengthOfLoan;

    /** @var float $payment The calculated monthly payment for the loan */
    private float $payment;


    /**
     * This constructs a new Loan object
     * 
     * The constructor is private because we want the user to create a Loan object by 
     * either calling the createLoan() function, or by calling the getLoan() function
     * 
     * @param int $id The identifier of the loan
     * @param float $amount The total amount of the loan
     * @param float $interestRate The interest rate of the loan
     * @param int $lengthOfLoan The length of the loan in months
     */
    private function __construct(int $id, float $amount, float $interestRate, int $lengthOfLoan) {
        $this->id =  $id;
        $this->amount = $amount;
        $this->interestRate = $interestRate;
        $this->lengthOfLoan = $lengthOfLoan;
        $this->payment = $this->calculateMonthlyPayment();
    }

    /**
     * Calculates the monthly payment for the loan
     * 
     * I used the formula found at https://www.kasasa.com/blog/how-to-calculate-loan-payments-in-3-easy-steps
     * to calculate the monthly payment
     * 
     * @return float Returns the monthly payment amount
     */
    private function calculateMonthlyPayment(): float {
        $a = $this->amount;
        $r = $this->interestRate / 12;
        $n = $this->lengthOfLoan;
        $payment = $a * ($r * pow(1 + $r, $n) / (pow(1 + $r, $n) - 1));

        return round($payment, 2);
    }

    /**
     * This creates a new Loan by first inserting the loan into the database,
     * then constructing the loan object with the id
     * 
     * @param float $amount The total amount of the loan
     * @param float $interestRate The interest rate of the loan
     * @param int $lengthOfLoan The length of the loan in months
     * @return Loan Returns a newly constructed Loan object
     */
    public static function createLoan(float $amount, float $interestRate, int $lengthOfLoan): self {
        $f3 = \Base::instance();
        $db = $f3->get('DB');

        // Sanitize the input
        $amount = floatval($amount);
        $interestRate = floatval($interestRate);
        $lengthOfLoan = intval($lengthOfLoan);

        // Insert the loan into the DB and get the id
        $loan = new DB\SQL\Mapper($db, 'public.loans');
        $loan->amount = $amount;
        $loan->interest_rate = $interestRate;
        $loan->length = $lengthOfLoan;
        $loan->save();

        $id = $loan->get('_id');

        // Create and return a new loan object
        return new self($id, $amount, $interestRate, $lengthOfLoan);
    }

    /**
     * This creates a Loan object by querying the database for the loan with id $id
     * 
     * @param int $id The unique identifier of the loan
     * @return Loan Returns a newly constructed Loan object
     */
    public static function getLoan(int $id): self {
        $f3 = \Base::instance();
        $db = $f3->get('DB');

        // Sanitize the input
        $id = intval($id);
        
        $loan = new DB\SQL\Mapper($db, 'public.loans');
        $loan->load(array('id=?', $id));

        // If no loan was found, throw an error
        if ($loan->dry()) {
            throw new Exception('No loan found with ID: ' . $id);
        }

        $amount = $loan->amount;
        $interestRate = $loan->interest_rate;
        $lengthOfLoan = $loan->length;

        return new self($id, $amount, $interestRate, $lengthOfLoan);
    }

    /**
     * This will update the loan based on the set values in $options
     * 
     * This function updates the loan values based on the different options in
     * the $options array. The options array should contain key => value pairs
     * that will contain the properties to be updated e.g.
     * ['amount' => 100.00, 'lengthOfLoan' => 36]
     * would set the loan's amount to $100.00 and the length of the loan to
     * 36 months
     * 
     * @param array $options Array that will contain key value pairs for updating the loan
     */
    public function updateLoan(array $options) {
        // Update Properties

        // DB Work
    }

    /**
     * Returns the loan's id
     * 
     * @return int The id of the loan
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Returns the amount of the loan
     * 
     * @return float The amount of the loan
     */
    public function getAmount(): float {
        return $this->amount;
    }

    /**
     * Returns the interest rate of the loan
     * 
     * @return float The interest rate of the loan
     */
    public function getInterestRate(): float {
        return $this->interestRate;
    }


    /**
     * Returns the length of the loan in months
     * 
     * @return int Returns the length of the loan in months
     */
    public function getLoanLength(): int {
        return $this->lengthOfLoan;
    }

    /**
     * Returns the monthly payment of the loan
     * 
     * @return float Returns the monthly payment of the loan
     */
    public function getPayment(): float {
        return $this->payment;
    }

    /**
     * Returns the loan as an array
     * 
     * @return array An array representing the loan
     */
    public function toArray(): array {
        $response = [];
        $response['id'] = $this->getId();
        $response['amount'] = $this->getAmount();
        $response['interest_rate'] = $this->getInterestRate();
        $response['length'] = $this->getLoanLength();
        $response['payment'] = $this->getPayment();

        return $response;
    }

}