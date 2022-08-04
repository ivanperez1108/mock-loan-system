<?php

/**
 * This route handles all the requests that are made to the server
 */
class RouteHandler {
    public function createLoan($f3) {
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

    public function getLoan($f3) {
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

    public function updateLoan($f3) {

    }
}