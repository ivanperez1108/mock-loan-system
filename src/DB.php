<?php

/**
 * This class contains static methods that will be used to create the DB connection
 * and setup tables that may not exist in the database
 */
class DB {
    /**
     * Connects to the database using $f3 global variables
     * 
     * @param \Base $f3 FatFreeFramework object used to get the variables from
     * @return DB\SQL Returns a database connection object
     */
    public static function connectDb(\Base $f3) : DB\SQL {
        $driver = $host = $port = $dbname = $user = $password = null;
        
        if ($f3->exists('driver')) {
            $driver = $f3->get('driver');
            $host = $f3->get('host');
            $port = $f3->get('port');
            $dbname = $f3->get('dbname');
            $user = $f3->get('user');
            $password = $f3->get('password');
        } else {
            $dbopts = parse_url(getenv('DATABASE_URL'));

            $driver = 'pgsql';
            $host = $dbopts['host'];
            $port = $dbopts['port'];
            $dbname = ltrim($dbopts['path'], '/');
            $user = $dbopts['user'];
            $password = $dbopts['pass'];
        }
        

        return new DB\SQL("{$driver}:host={$host};port={$port};dbname={$dbname}", $user, $password);
    }

    /**
     * Prepares the database to be used by the app
     * 
     * If the database has not been used before, then there will be multiple tables
     * missing. This function checks for existance of required tables, and creates them
     * if needed.
     * 
     * @param \Base $f3 FatFreeFramework object used to get db variable
     */
    public static function prepareDatabase(\Base $f3) {
        $sql = 'CREATE TABLE IF NOT EXISTS public.loans
        (
            id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
            amount double precision NOT NULL,
            interest_rate double precision NOT NULL,
            length integer NOT NULL,
            CONSTRAINT loans_pkey PRIMARY KEY (id)
        )';

        $f3->get('DB')->exec($sql);
    }
}