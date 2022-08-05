<?php

/**
 * This route handles all the requests that are made to the server
 */
class RouteHandler {

    /**
     * Creates a loan and outputs the loan in JSON form
     */
    public function createLoan(\Base $f3) {
        header('Content-Type: application/json; charset=utf-8');
        
        $response = [];

        try {
            $loan = Loan::createLoan(
                $f3->get('REQUEST.amount'), 
                $f3->get('REQUEST.interest_rate'),
                $f3->get('REQUEST.length')
            );
    
            $response['success'] = true;
            $response['loan'] = $loan->toArray();
        } catch (Throwable $e) {
            $response['success'] = false;
            $response['error_message'] = $e->getMessage();
        }

        echo json_encode($response);
    }

    /**
     * Gets a loan and outputs the loan as an array
     */
    public function getLoan(\Base $f3) {
        header('Content-Type: application/json; charset=utf-8');

        $response = [];

        try {
            $loan = Loan::getLoan(
                $f3->get('REQUEST.id')
            );

            $response['success'] = true;
            $response['loan'] = $loan->toArray();
        } catch (Throwable $e) {
            $response['success'] = false;
            $response['error_message'] = $e->getMessage();
        }

        echo json_encode($response);
    }

    /**
     * Updates an existing loan
     */
    public function updateLoan(\Base $f3) {
        header('Content-Type: application/json; charset=utf-8');

        $response = [];

        try {
            $loan = Loan::getLoan(
                $f3->get('REQUEST.id')
            );

            $options = [];

            if ($f3->exists('REQUEST.amount')) {
                $options['amount'] = $f3->get('REQUEST.amount');
            }

            if ($f3->exists('REQUEST.interest_rate')) {
                $options['interest_rate'] = $f3->get('REQUEST.interest_rate');
            }

            if ($f3->exists('REQUEST.length')) {
                $options['length'] = $f3->get('REQUEST.length');
            }

            $loan->updateLoan($options);

            $response['success'] = true;
            $response['loan'] = $loan->toArray();
        } catch (Throwable $e) {
            $response['success'] = false;
            $response['error_message'] = $e->getMessage();
        }

        echo json_encode($response);
    }
}